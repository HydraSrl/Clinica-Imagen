<?php
require_once 'cors.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'pdo.php';

$response = ['success' => false, 'message' => '', 'data' => []];

if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'No autorizado - no hay sesión activa';
    echo json_encode($response);
    exit;
}

try {
    $pdo = DB::getConnection();

    $checkPermission = $pdo->prepare("SELECT id FROM PERSONAL WHERE id_user = :userId");
    $checkPermission->bindParam(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
    $checkPermission->execute();

    if ($checkPermission->rowCount() === 0) {
        $response['message'] = 'No tienes permisos';
        echo json_encode($response);
        exit;
    }

    $query = "SELECT id, nombre, ubicacion, departamento, telefono, telefono_fijo FROM SUCURSALES ORDER BY nombre ASC";
    $stmt = $pdo->query($query);
    $sucursales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['data'] = $sucursales;
    $response['message'] = 'Sucursales obtenidas exitosamente';

} catch (PDOException $e) {
    $response['message'] = 'Error al obtener las sucursales: ' . $e->getMessage();
}

echo json_encode($response);
?>
