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
        $response['message'] = 'No tienes permisos para actualizar personal';
        echo json_encode($response);
        exit;
    }

    // Get POST data
    $id_personal = $_POST['id_personal'] ?? null;
    $nombre = $_POST['nombre'] ?? null;
    $email = $_POST['email'] ?? null;
    $rol = $_POST['rol'] ?? null;

    // Validate required fields
    if (!$id_personal || !$nombre || !$email || !$rol) {
        $response['message'] = 'Faltan campos requeridos';
        echo json_encode($response);
        exit;
    }

    // Verify personal exists and get id_user
    $checkPersonal = $pdo->prepare("SELECT id_user FROM PERSONAL WHERE id = :id_personal");
    $checkPersonal->bindParam(':id_personal', $id_personal, PDO::PARAM_INT);
    $checkPersonal->execute();

    if ($checkPersonal->rowCount() === 0) {
        $response['message'] = 'El personal no existe';
        echo json_encode($response);
        exit;
    }

    $personalData = $checkPersonal->fetch(PDO::FETCH_ASSOC);
    $id_user = $personalData['id_user'];

    $pdo->beginTransaction();

    // Update PERSONAL table
    $queryPersonal = "
        UPDATE PERSONAL
        SET nombre = :nombre, rol = :rol
        WHERE id = :id_personal
    ";

    $stmtPersonal = $pdo->prepare($queryPersonal);
    $stmtPersonal->bindParam(':nombre', $nombre);
    $stmtPersonal->bindParam(':rol', $rol);
    $stmtPersonal->bindParam(':id_personal', $id_personal, PDO::PARAM_INT);
    $stmtPersonal->execute();

    // Update USERS table
    $queryUser = "
        UPDATE USERS
        SET email = :email
        WHERE id = :id_user
    ";

    $stmtUser = $pdo->prepare($queryUser);
    $stmtUser->bindParam(':email', $email);
    $stmtUser->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmtUser->execute();

    $pdo->commit();

    $response['success'] = true;
    $response['message'] = 'Personal actualizado exitosamente';

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
}

echo json_encode($response);
?>
