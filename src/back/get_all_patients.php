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

    // Build query with filters
    $query = "
        SELECT
            p.id,
            p.id_user,
            p.nombre,
            p.cedula,
            p.fecha_nacimiento,
            p.telefono,
            p.ciudad,
            u.email
        FROM PACIENTES p
        INNER JOIN USERS u ON p.id_user = u.id
        WHERE 1=1
    ";

    $params = [];

    // Filter by name
    if (isset($_GET['nombre']) && $_GET['nombre'] !== '') {
        $query .= " AND p.nombre LIKE :nombre";
        $params[':nombre'] = '%' . $_GET['nombre'] . '%';
    }

    // Filter by cedula
    if (isset($_GET['cedula']) && $_GET['cedula'] !== '') {
        $query .= " AND p.cedula = :cedula";
        $params[':cedula'] = $_GET['cedula'];
    }

    // Filter by city
    if (isset($_GET['ciudad']) && $_GET['ciudad'] !== '') {
        $query .= " AND p.ciudad LIKE :ciudad";
        $params[':ciudad'] = '%' . $_GET['ciudad'] . '%';
    }

    // Filter by email
    if (isset($_GET['email']) && $_GET['email'] !== '') {
        $query .= " AND u.email LIKE :email";
        $params[':email'] = '%' . $_GET['email'] . '%';
    }

    $query .= " ORDER BY p.nombre ASC";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['data'] = $patients;
    $response['message'] = 'Pacientes obtenidos exitosamente';

} catch (PDOException $e) {
    $response['message'] = 'Error al obtener los pacientes: ' . $e->getMessage();
}

echo json_encode($response);
?>
