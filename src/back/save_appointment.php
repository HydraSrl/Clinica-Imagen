<?php
require_once 'cors.php';
require_once 'pdo.php';
require_once 'utils.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido. Se esperaba POST.');
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['fecha_cita']) || !isset($data['id_sucursal'])) {
        throw new Exception("Parámetros 'fecha_cita' y 'id_sucursal' son requeridos.");
    }

    if (!isset($_SESSION['user_id'])) {
        http_response_code(403);
        throw new Exception("Usuario no autenticado. Por favor, inicie sesión.");
    }
    
    $pdo = DB::getConnection();
    $id_paciente = get_patient_id_from_user_id($pdo, $_SESSION['user_id']);
    if (!$id_paciente) {
        http_response_code(404);
        throw new Exception("No se encontró un paciente asociado a este usuario.");
    }

    $fecha_cita = $data['fecha_cita'];
    $id_sucursal = (int)$data['id_sucursal'];
    $duracion = isset($data['duracion']) ? (int)$data['duracion'] : 60; // Default 60 minutos

    // Validar que el slot de tiempo no esté ya ocupado (doble chequeo)
    // Ahora verificamos que no haya conflictos con citas existentes considerando su duración
    $fecha_cita_dt = new DateTime($fecha_cita);
    $stmt_check = $pdo->prepare("SELECT fecha_cita, duracion FROM CITAS WHERE DATE(fecha_cita) = :fecha AND id_sucursal = :id_sucursal");
    $stmt_check->execute([
        'fecha' => $fecha_cita_dt->format('Y-m-d'),
        'id_sucursal' => $id_sucursal
    ]);

    $citas_existentes = $stmt_check->fetchAll(PDO::FETCH_ASSOC);
    foreach ($citas_existentes as $cita_existente) {
        $inicio_existente = new DateTime($cita_existente['fecha_cita']);
        $duracion_existente = $cita_existente['duracion'] ?? 60;
        $fin_existente = clone $inicio_existente;
        $fin_existente->add(new DateInterval('PT' . $duracion_existente . 'M'));

        $fin_nueva = clone $fecha_cita_dt;
        $fin_nueva->add(new DateInterval('PT' . $duracion . 'M'));

        // Verificar si hay solapamiento
        if ($fecha_cita_dt < $fin_existente && $fin_nueva > $inicio_existente) {
            http_response_code(409); // Conflict
            throw new Exception("El horario seleccionado ya no está disponible.");
        }
    }

    $sql = "INSERT INTO CITAS (id_paciente, id_sucursal, fecha_cita, duracion, estado, fecha_creacion) VALUES (:id_paciente, :id_sucursal, :fecha_cita, :duracion, 'pendiente', NOW())";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'id_paciente' => $id_paciente,
        'id_sucursal' => $id_sucursal,
        'fecha_cita' => $fecha_cita,
        'duracion' => $duracion
    ]);

    echo json_encode(['success' => true, 'message' => 'Cita agendada correctamente.']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

function get_patient_id_from_user_id($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT id FROM PACIENTES WHERE id_user = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['id'] : null;
}

?>