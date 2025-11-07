<?php
require_once 'cors.php';
require_once 'pdo.php';
require_once 'utils.php';

try {
    if (!isset($_GET['fecha']) || !isset($_GET['id_sucursal'])) {
        throw new Exception("Parámetros 'fecha' y 'id_sucursal' son requeridos.");
    }

    $fecha = $_GET['fecha'];
    $id_sucursal = (int)$_GET['id_sucursal'];

    // 1. Obtener el día de la semana y los horarios de apertura/cierre de la sucursal
    $dia_semana_num = date('N', strtotime($fecha));
    $dias_semana = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
    $dia_semana_nombre = $dias_semana[$dia_semana_num - 1];

    $pdo = DB::getConnection();
    $stmt_horario = $pdo->prepare("SELECT hora_apertura, hora_cierre FROM HORARIOS_SUCURSAL WHERE id_sucursal = :id_sucursal AND dia = :dia");
    $stmt_horario->execute(['id_sucursal' => $id_sucursal, 'dia' => $dia_semana_nombre]);
    $horario_sucursal = $stmt_horario->fetch(PDO::FETCH_ASSOC);

    if (!$horario_sucursal || is_null($horario_sucursal['hora_apertura']) || is_null($horario_sucursal['hora_cierre'])) {
        echo json_encode(['available_slots' => []]);
        exit;
    }

    $hora_apertura = new DateTime($horario_sucursal['hora_apertura']);
    $hora_cierre = new DateTime($horario_sucursal['hora_cierre']);

    // 2. Obtener las citas ya agendadas para ese día y sucursal CON SU DURACIÓN
    $stmt_citas = $pdo->prepare("SELECT fecha_cita, duracion FROM CITAS WHERE DATE(fecha_cita) = :fecha AND id_sucursal = :id_sucursal");
    $stmt_citas->execute(['fecha' => $fecha, 'id_sucursal' => $id_sucursal]);
    $citas_agendadas = $stmt_citas->fetchAll(PDO::FETCH_ASSOC);

    // Calcular todos los slots ocupados considerando la duración de cada cita
    $booked_slots = [];
    foreach ($citas_agendadas as $cita) {
        $inicio_cita = new DateTime($cita['fecha_cita']);
        $duracion_minutos = $cita['duracion'] ?? 60; // Default 60 si no tiene duración

        // Bloquear todos los slots de 30 min que están dentro de la duración de la cita
        $num_slots_bloqueados = ceil($duracion_minutos / 30);
        for ($i = 0; $i < $num_slots_bloqueados; $i++) {
            $slot_bloqueado = clone $inicio_cita;
            $slot_bloqueado->add(new DateInterval('PT' . ($i * 30) . 'M'));
            $booked_slots[] = $slot_bloqueado->format('H:i');
        }
    }

    // Eliminar duplicados
    $booked_slots = array_unique($booked_slots);

    // 3. Generar todos los posibles slots de 30 minutos y filtrar los disponibles
    $available_slots = [];
    $interval = new DateInterval('PT30M');
    $period = new DatePeriod($hora_apertura, $interval, $hora_cierre);

    foreach ($period as $slot) {
        $slot_time = $slot->format('H:i');
        if (!in_array($slot_time, $booked_slots)) {
            $available_slots[] = $slot_time;
        }
    }

    echo json_encode(['available_slots' => $available_slots]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}