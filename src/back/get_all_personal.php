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
    $query = "
        SELECT
            p.id,
            p.id_user,
            p.nombre,
            p.rol,
            u.email
        FROM PERSONAL p
        INNER JOIN USERS u ON p.id_user = u.id
        WHERE 1=1
    ";

    $params = [];

    // Filtrado por nombre
    if (isset($_GET['nombre']) && $_GET['nombre'] !== '') {
        $query .= " AND p.nombre LIKE :nombre";
        $params[':nombre'] = '%' . $_GET['nombre'] . '%';
    }

    // Filtrado por rol
    if (isset($_GET['rol']) && $_GET['rol'] !== '') {
        $query .= " AND p.rol = :rol";
        $params[':rol'] = $_GET['rol'];
    }

    // Filtrado por mail
    if (isset($_GET['email']) && $_GET['email'] !== '') {
        $query .= " AND u.email LIKE :email";
        $params[':email'] = '%' . $_GET['email'] . '%';
    }

    $query .= " ORDER BY p.nombre ASC";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $personal = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['data'] = $personal;
    $response['message'] = 'Personal obtenido exitosamente';

} catch (PDOException $e) {
    $response['message'] = 'Error al obtener el personal: ' . $e->getMessage();
}

echo json_encode($response);
?>
