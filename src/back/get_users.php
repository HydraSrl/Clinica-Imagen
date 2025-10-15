<?php
require_once 'pdo.php';

header('Content-Type: application/json');

$response = ['success' => false, 'users' => [], 'message' => ''];

try {
    $pdo = DB::getConnection();
    $sql = "SELECT id_user, nombre FROM PERSONAL";
    $stmt = $pdo->query($sql);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['users'] = $users;
} catch (PDOException $e) {
    $response['message'] = 'Error fetching users: ' . $e->getMessage();
}

echo json_encode($response);
?>