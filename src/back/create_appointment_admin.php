<?php
require_once 'cors.php';
require_once 'utils.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'pdo.php';

$response = ['success' => false, 'message' => ''];

// Verificar si el usuario tiene permiso
if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'No autorizado - no hay sesión activa';
    echo json_encode($response);
    exit;
}

try {
    $pdo = DB::getConnection();

    // Verificar si el usuario está en la tabla PERSONAL
    $checkPermission = $pdo->prepare("SELECT id FROM PERSONAL WHERE id_user = :userId");
    $checkPermission->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
    $checkPermission->execute();

    if ($checkPermission->rowCount() === 0) {
        $response['message'] = 'No tienes permisos para crear citas';
        echo json_encode($response);
        exit;
    }

    // Obtener datos POST
    $id_paciente = isset($_POST['id_paciente']) ? sanitizeInput($_POST['id_paciente']) : null;
    $id_personal = isset($_POST['id_personal']) ? sanitizeInput($_POST['id_personal']) : null;
    $id_tratamiento = isset($_POST['id_tratamiento']) ? sanitizeInput($_POST['id_tratamiento']) : null;
    $id_sucursal = isset($_POST['id_sucursal']) ? sanitizeInput($_POST['id_sucursal']) : null;
    $fecha_cita = isset($_POST['fecha_cita']) ? sanitizeInput($_POST['fecha_cita']) : null;
    $duracion = isset($_POST['duracion']) ? sanitizeInput($_POST['duracion']) : 60;
    $estado = isset($_POST['estado']) ? sanitizeInput($_POST['estado']) : 'pendiente';

    // Validar campos requeridos
    if (!$id_paciente || !$id_sucursal || !$fecha_cita) {
        $response['message'] = 'Faltan campos requeridos (paciente, sucursal, fecha)';
        echo json_encode($response);
        exit;
    }

    // Verificar si el paciente existe
    $checkPatient = $pdo->prepare("SELECT id FROM PACIENTES WHERE id = :id_paciente");
    $checkPatient->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
    $checkPatient->execute();

    if ($checkPatient->rowCount() === 0) {
        $response['message'] = 'El paciente no existe';
        echo json_encode($response);
        exit;
    }

    // Verificar si la sucursal existe
    $checkSucursal = $pdo->prepare("SELECT id FROM SUCURSALES WHERE id = :id_sucursal");
    $checkSucursal->bindParam(':id_sucursal', $id_sucursal, PDO::PARAM_INT);
    $checkSucursal->execute();

    if ($checkSucursal->rowCount() === 0) {
        $response['message'] = 'La sucursal no existe';
        echo json_encode($response);
        exit;
    }

    // Insertar cita
    $query = "
        INSERT INTO CITAS (id_paciente, id_personal, id_tratamiento, id_sucursal, fecha_cita, duracion, estado)
        VALUES (:id_paciente, :id_personal, :id_tratamiento, :id_sucursal, :fecha_cita, :duracion, :estado)
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);

    // Manejar valores nulos para campos opcionales
    if ($id_personal === '' || $id_personal === null) {
        $stmt->bindValue(':id_personal', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindParam(':id_personal', $id_personal, PDO::PARAM_INT);
    }

    if ($id_tratamiento === '' || $id_tratamiento === null) {
        $stmt->bindValue(':id_tratamiento', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindParam(':id_tratamiento', $id_tratamiento, PDO::PARAM_INT);
    }

    $stmt->bindParam(':id_sucursal', $id_sucursal, PDO::PARAM_INT);
    $stmt->bindParam(':fecha_cita', $fecha_cita);
    $stmt->bindParam(':duracion', $duracion, PDO::PARAM_INT);
    $stmt->bindParam(':estado', $estado);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Cita creada exitosamente';
        $response['id_cita'] = $pdo->lastInsertId();
    } else {
        $response['message'] = 'Error al crear la cita';
    }

} catch (PDOException $e) {
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
}

echo json_encode($response);
?>
