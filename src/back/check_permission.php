<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once 'pdo.php';

function hasBackofficePermission() {
    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    $userId = $_SESSION['user_id'];
    $pdo = DB::getConnection();

    $stmt = $pdo->prepare("SELECT 1 FROM PERSONAL WHERE id_user = ?");
    $stmt->execute([$userId]);

    return $stmt->fetchColumn() !== false;
}

$hasPermission = hasBackofficePermission();
?>