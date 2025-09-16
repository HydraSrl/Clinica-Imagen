<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="../styles/tratamientos.css" />
    <link rel="icon" href="img/logomini.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
    <title>Clínica Imagen</title>
</head>
<body>
    <!-- Header -->
    <header id="header">
        <nav style="cursor: pointer;" class="logo-header"><img src="img/logo.png" onclick="window.location.href='index.php'"></nav>
        <div class="buttons-header">
            <nav style="font-family: 'Karla';" class="links-header"><a href="pages/tratamientos.php">Tratamientos</a></nav>
            <nav style="font-family: 'Karla';" class="links-header"><a href="pages/contacto.php">Contacto</a></nav>
        </div>
        <div class="menu-perfil-container">
            <div class="mobile-buttons-header">
                <input type="checkbox" id="mobile-header-toggle">
                <label for="mobile-header-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                </label>
                <div class="mobile-header-view">
                    <nav class="links-header"><a href="pages/tratamientos.html">Tratamientos</a></nav> 
                    <nav class="links-header"><a href="#registro-button-section-main">Agendate</a></nav>
                    <nav class="links-header"><a href="sobrenosotros.html">Contacto</a></nav>
                </div>
            </div>
        </div>
    </header>