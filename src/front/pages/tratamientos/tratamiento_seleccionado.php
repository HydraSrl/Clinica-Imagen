<?php
require_once '../back/get_tratamientos.php';
require_once '../back/utils.php';

$slug = $_GET['slug'] ?? null;

if (!$slug) {
    // Redirigir a la página de tratamientos o mostrar un error
    header('Location: ../tratamientos.php');
    exit;
}

$tratamiento = getTratamientoBySlug(sanitizeInput($slug));

if (!$tratamiento) {
    // Manejar el caso en que no se encuentra el tratamiento
    echo "Tratamiento no encontrado.";
    exit;
}

$detalles = json_decode($tratamiento['detalles_pagina'], true);

// Incluir encabezado
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($tratamiento['nombre']); ?></title>
    <link rel="stylesheet" href="styles/tratamiento_seleccionado.css">
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <main class="tratamiento-main-container">
        <img class="background-img" src="img/benyamin-bohlouli-B_sK_xgzwVA-unsplash.jpg" alt="Lobby de odontologia">
        <div class="tratamiento-grid">
            <div class="grid-item image-1">
                <img src="img/logo.png" alt="Logo Clinica Imagen">
            </div>
            <div class="grid-item title-card">
                <h1><?php echo htmlspecialchars($tratamiento['nombre']); ?></h1>
            </div>
            <div class="grid-item text-card">
                <p><?php echo nl2br(htmlspecialchars($detalles['texto_principal'] ?? '')); ?></p>
            </div>
            <div class="grid-item image-2">
                <img src="<?php echo htmlspecialchars($detalles['imagen_grid_2'] ?? ''); ?>" alt="<?php echo htmlspecialchars($tratamiento['nombre']); ?> 2">
            </div>
        </div>
    </main>
</body>
</html>