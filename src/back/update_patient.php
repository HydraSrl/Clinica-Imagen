<?php
require_once 'pdo.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $cedula = $_POST['cedula'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';

    if (empty($id) || empty($nombre) || empty($cedula) || empty($fecha_nacimiento) || empty($telefono) || empty($ciudad)) {
        $response['message'] = 'Todos los campos son requeridos.';
    } else {
        $pdo = DB::getConnection();
        
        try {
            $sql = "UPDATE PACIENTES SET nombre = :nombre, cedula = :cedula, fecha_nacimiento = :fecha_nacimiento, telefono = :telefono, ciudad = :ciudad WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'nombre' => $nombre,
                'cedula' => $cedula,
                'fecha_nacimiento' => $fecha_nacimiento,
                'telefono' => $telefono,
                'ciudad' => $ciudad
            ]);

            $response['success'] = true;
            $response['message'] = 'Paciente actualizado correctamente.';
        } catch (PDOException $e) {
            $response['message'] = 'Error al actualizar el paciente: ' . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Método de solicitud no válido.';
}

echo json_encode($response);
?>