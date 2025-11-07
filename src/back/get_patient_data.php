<?php
require_once 'pdo.php';

$userData = null;

if (isset($_SESSION['user_id'])) {
    try {
        $pdo = DB::getConnection();
        $userId = $_SESSION['user_id'];

        // Primero, intentar obtener datos del paciente
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

        // Si no se encuentra como paciente, buscar en personal
        if (!$userData) {
            $query = "
                SELECT pe.nombre, u.email
                FROM PERSONAL pe
                JOIN USERS u ON pe.id_user = u.id
                WHERE pe.id_user = :userId
            ";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        }

    } catch (PDOException $e) {
    }
}
?>