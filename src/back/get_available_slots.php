<?php
header('Content-Type: application/json');

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

    // 2. Obtener las citas ya agendadas para ese día y sucursal
    $stmt_citas = $pdo->prepare("SELECT fecha_cita FROM CITAS WHERE DATE(fecha_cita) = :fecha AND id_sucursal = :id_sucursal");
    $stmt_citas->execute(['fecha' => $fecha, 'id_sucursal' => $id_sucursal]);
    $citas_agendadas = $stmt_citas->fetchAll(PDO::FETCH_COLUMN, 0);

    $booked_slots = [];
    foreach ($citas_agendadas as $cita) {
        $booked_slots[] = (new DateTime($cita))->format('H:i');
    }

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