<?php
require_once 'cors.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'pdo.php';

$response = ['success' => false, 'message' => '', 'data' => []];

// Check if user has permission (must be in PERSONAL table)
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
        $response['message'] = 'No tienes permisos para ver las citas';
        echo json_encode($response);
        exit;
    }

    // Build query with filters
    $query = "
        SELECT
            c.id,
            c.id_paciente,
            c.id_personal,
            c.id_tratamiento,
            c.id_sucursal,
            c.fecha_cita,
            c.estado,
            c.fecha_creacion,
            p.nombre AS paciente_nombre,
            p.cedula AS paciente_cedula,
            p.telefono AS paciente_telefono,
            s.nombre AS sucursal_nombre,
            t.nombre AS tratamiento_nombre,
            pe.nombre AS personal_nombre
        FROM CITAS c
        JOIN PACIENTES p ON c.id_paciente = p.id
        JOIN SUCURSALES s ON c.id_sucursal = s.id
        LEFT JOIN TRATAMIENTOS t ON c.id_tratamiento = t.id
        LEFT JOIN PERSONAL pe ON c.id_personal = pe.id
        WHERE 1=1
    ";

    $params = [];

    // Apply filters
    if (isset($_GET['cedula']) && !empty($_GET['cedula'])) {
        $query .= " AND p.cedula LIKE :cedula";
        $params[':cedula'] = '%' . $_GET['cedula'] . '%';
    }

    if (isset($_GET['nombre']) && !empty($_GET['nombre'])) {
        $query .= " AND p.nombre LIKE :nombre";
        $params[':nombre'] = '%' . $_GET['nombre'] . '%';
    }

    if (isset($_GET['estado']) && !empty($_GET['estado'])) {
        $query .= " AND c.estado = :estado";
        $params[':estado'] = $_GET['estado'];
    }

    if (isset($_GET['id_sucursal']) && !empty($_GET['id_sucursal'])) {
        $query .= " AND c.id_sucursal = :id_sucursal";
        $params[':id_sucursal'] = $_GET['id_sucursal'];
    }

    if (isset($_GET['fecha_desde']) && !empty($_GET['fecha_desde'])) {
        $query .= " AND DATE(c.fecha_cita) >= :fecha_desde";
        $params[':fecha_desde'] = $_GET['fecha_desde'];
    }

    if (isset($_GET['fecha_hasta']) && !empty($_GET['fecha_hasta'])) {
        $query .= " AND DATE(c.fecha_cita) <= :fecha_hasta";
        $params[':fecha_hasta'] = $_GET['fecha_hasta'];
    }

    $query .= " ORDER BY c.fecha_cita DESC";

    $stmt = $pdo->prepare($query);

    // Bind parameters
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['data'] = $appointments;
    $response['message'] = 'Citas obtenidas exitosamente';

} catch (PDOException $e) {
    $response['message'] = 'Error al obtener las citas: ' . $e->getMessage();
}

echo json_encode($response);
?>
