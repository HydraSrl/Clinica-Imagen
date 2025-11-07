<?php
include_once 'cors.php';
include_once 'pdo.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'No autenticado']);
    exit;
}

try {
    $userId = $_SESSION['user_id'];
    $pdo = DB::getConnection();

    // Obtener información del usuario
    $stmt = $pdo->prepare("
        SELECT p.id as id_personal, p.nombre, p.rol
        FROM PERSONAL p
        WHERE p.id_user = ?
    ");
    $stmt->execute([$userId]);
    $personal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$personal) {
        echo json_encode(['success' => false, 'message' => 'Personal no encontrado']);
        exit;
    }

    $response = [
        'success' => true,
        'nombre' => $personal['nombre'],
        'rol' => $personal['rol']
    ];

    // Si es doctor, contar sus citas asignadas
    if ($personal['rol'] === 'Doctor') {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as total_citas
            FROM CITA
            WHERE id_personal = ?
            AND estado IN ('pendiente', 'confirmada')
        ");
        $stmt->execute([$personal['id_personal']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $response['total_citas'] = $result['total_citas'];
    }

    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al obtener información: ' . $e->getMessage()]);
}
?>
