<?php
require_once 'pdo.php';

function getAllTratamientos() {
    $pdo = DB::getConnection();
    $stmt = $pdo->query('SELECT * FROM TRATAMIENTOS');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTratamientoBySlug($slug) {
    $pdo = DB::getConnection();
    $stmt = $pdo->prepare('SELECT * FROM TRATAMIENTOS WHERE slug = :slug');
    $stmt->execute(['slug' => $slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>