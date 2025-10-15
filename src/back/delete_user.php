<?php
require_once 'pdo.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_POST['id_user'] ?? '';

    if (empty($id_user)) {
        $response['message'] = 'User ID is required.';
    } else {
        $pdo = DB::getConnection();
        
        try {
            // The ON DELETE CASCADE constraint will handle the deletion from the PERSONAL table
            $sql = "DELETE FROM USERS WHERE id = :id_user";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id_user' => $id_user]);

            $response['success'] = true;
            $response['message'] = 'User deleted successfully.';
        } catch (PDOException $e) {
            $response['message'] = 'Error deleting user: ' . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>