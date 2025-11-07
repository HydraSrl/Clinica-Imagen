<?php
require_once 'cors.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'pdo.php';
require_once 'utils.php';

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
        $response['message'] = 'No tienes permisos para actualizar pacientes';
        echo json_encode($response);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? sanitizeInput($_POST['id']) : (isset($_POST['id_paciente']) ? sanitizeInput($_POST['id_paciente']) : '');
        $nombre = isset($_POST['nombre']) ? sanitizeInput($_POST['nombre']) : '';
        $cedula = isset($_POST['cedula']) ? sanitizeInput($_POST['cedula']) : '';
        $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? sanitizeInput($_POST['fecha_nacimiento']) : '';
        $telefono = isset($_POST['telefono']) ? sanitizeInput($_POST['telefono']) : '';
        $ciudad = isset($_POST['ciudad']) ? sanitizeInput($_POST['ciudad']) : '';
        $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';

        if (empty($id) || empty($nombre) || empty($cedula) || empty($fecha_nacimiento) || empty($telefono) || empty($ciudad) || empty($email)) {
            $response['message'] = 'Todos los campos son requeridos.';
        } else {
            // Verificar si el paciente existe y obtener el id_user
            $checkPatient = $pdo->prepare("SELECT id_user FROM PACIENTES WHERE id = :id");
            $checkPatient->bindParam(':id', $id, PDO::PARAM_INT);
            $checkPatient->execute();

            if ($checkPatient->rowCount() === 0) {
                $response['message'] = 'El paciente no existe';
                echo json_encode($response);
                exit;
            }

            $patientData = $checkPatient->fetch(PDO::FETCH_ASSOC);
            $id_user = $patientData['id_user'];

            $pdo->beginTransaction();

            // Actualizar la tabla PACIENTES
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

            // Actualizar la tabla USERS
            $sqlUser = "UPDATE USERS SET email = :email WHERE id = :id_user";
            $stmtUser = $pdo->prepare($sqlUser);
            $stmtUser->execute([
                'email' => $email,
                'id_user' => $id_user
            ]);

            $pdo->commit();

            $response['success'] = true;
            $response['message'] = 'Paciente actualizado correctamente.';
        }
    } else {
        $response['message'] = 'Método de solicitud no válido.';
    }
} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $response['message'] = 'Error al actualizar el paciente: ' . $e->getMessage();
}

echo json_encode($response);
?>