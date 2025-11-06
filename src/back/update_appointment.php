<?php
require_once 'cors.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'pdo.php';

$response = ['success' => false, 'message' => ''];

// Check if user has permission
if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'No autorizado - no hay sesión activa';
    echo json_encode($response);
    exit;
}

try {
    $pdo = DB::getConnection();

    // Verify user is in PERSONAL table
    $checkPermission = $pdo->prepare("SELECT id FROM PERSONAL WHERE id_user = :userId");
    $checkPermission->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
    $checkPermission->execute();

    if ($checkPermission->rowCount() === 0) {
        $response['message'] = 'No tienes permisos para actualizar citas';
        echo json_encode($response);
        exit;
    }

    // Get POST data
    $id_cita = $_POST['id_cita'] ?? null;
    $id_personal = $_POST['id_personal'] ?? null;
    $id_tratamiento = $_POST['id_tratamiento'] ?? null;
    $id_sucursal = $_POST['id_sucursal'] ?? null;
    $fecha_cita = $_POST['fecha_cita'] ?? null;
    $duracion = $_POST['duracion'] ?? 60;
    $estado = $_POST['estado'] ?? null;

    // Validate required fields
    if (!$id_cita || !$id_sucursal || !$fecha_cita || !$estado) {
        $response['message'] = 'Faltan campos requeridos';
        echo json_encode($response);
        exit;
    }

    // Verify appointment exists
    $checkAppointment = $pdo->prepare("SELECT id FROM CITAS WHERE id = :id_cita");
    $checkAppointment->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
    $checkAppointment->execute();

    if ($checkAppointment->rowCount() === 0) {
        $response['message'] = 'La cita no existe';
        echo json_encode($response);
        exit;
    }

    // Update appointment
    $query = "
        UPDATE CITAS
        SET
            id_personal = :id_personal,
            id_tratamiento = :id_tratamiento,
            id_sucursal = :id_sucursal,
            fecha_cita = :fecha_cita,
            duracion = :duracion,
            estado = :estado
        WHERE id = :id_cita
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);

    // Handle null values for optional fields
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
        $response['message'] = 'Cita actualizada exitosamente';
    } else {
        $response['message'] = 'Error al actualizar la cita';
    }

} catch (PDOException $e) {
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
}

echo json_encode($response);
?>
