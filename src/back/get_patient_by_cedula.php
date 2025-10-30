<?php
require_once 'pdo.php';

header('Content-Type: application/json');

$response = ['success' => false, 'patient' => null, 'message' => ''];

if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];
    $pdo = DB::getConnection();

    try {
        $sql = "SELECT id, nombre, cedula, fecha_nacimiento, telefono, ciudad FROM PACIENTES WHERE cedula = :cedula";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['cedula' => $cedula]);
        $patient = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($patient) {
            $response['success'] = true;
            $response['patient'] = $patient;
        } else {
            $response['message'] = 'No se encontró ningún paciente con la cédula proporcionada.';
        }
    } catch (PDOException $e) {
        $response['message'] = 'Error al buscar el paciente: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'La cédula del paciente es requerida.';
}

echo json_encode($response);
?>