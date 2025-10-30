<?php
session_start();
require_once 'pdo.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../front/pages/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id'])) {
    try {
        $pdo = DB::getConnection();
        $appointmentId = $_POST['appointment_id'];
        $userId = $_SESSION['user_id'];

        // Verify that the appointment belongs to the current user before deleting
        $query = "
            DELETE c FROM CITAS c
            JOIN PACIENTES p ON c.id_paciente = p.id
            WHERE c.id = :appointmentId AND p.id_user = :userId
        ";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':appointmentId', $appointmentId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: ../front/index.php?page=perfil&success=1');
        exit();

    } catch (PDOException $e) {
        header('Location: ../front/index.php?page=perfil&error=1');
        exit();
    }
} else {
    header('Location: ../front/index.php?page=perfil');
    exit();
}
?>