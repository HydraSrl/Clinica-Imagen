<?php
require_once 'cors.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'pdo.php';

$response = ['success' => false, 'message' => '', 'data' => []];

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
        $response['message'] = 'No tienes permisos';
        echo json_encode($response);
        exit;
    }

    // Get all tratamientos (treatments)
    $query = "SELECT id, nombre, descripcion FROM TRATAMIENTOS ORDER BY nombre ASC";
    $stmt = $pdo->query($query);
    $tratamientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['data'] = $tratamientos;
    $response['message'] = 'Tratamientos obtenidos exitosamente';

} catch (PDOException $e) {
    $response['message'] = 'Error al obtener los tratamientos: ' . $e->getMessage();
}

echo json_encode($response);
?>
