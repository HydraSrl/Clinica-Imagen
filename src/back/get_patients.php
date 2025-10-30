<?php
require_once 'pdo.php';

header('Content-Type: application/json');

$response = ['success' => false, 'patients' => [], 'message' => ''];

try {
    $pdo = DB::getConnection();
    $sql = "SELECT id, id_user, nombre, cedula, fecha_nacimiento, telefono, ciudad FROM PACIENTES";
    $stmt = $pdo->query($sql);
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['patients'] = $patients;
} catch (PDOException $e) {
    $response['message'] = 'Error fetching patients: ' . $e->getMessage();
}

echo json_encode($response);
?>