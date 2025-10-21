<?php
require_once 'pdo.php';

$userData = null;

if (isset($_SESSION['user_id'])) {
    try {
        $pdo = DB::getConnection();
        $userId = $_SESSION['user_id'];

        $query = "
            SELECT p.nombre, u.email 
            FROM PACIENTES p 
            JOIN USERS u ON p.id_user = u.id 
            WHERE p.id_user = :userId
        ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        // Optionally handle the error, e.g., log it
        // For now, we'll just let $userData remain null
    }
}
?>