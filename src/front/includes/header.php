<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    
    <!-- Cargar estilo segun pagina actual -->
    <?php if (isset($page_styles[$page])): // Si page actual esta en array page_styles entonces cargar css correspondiente?>
    <link rel="stylesheet" href="css/<?php echo $page_styles[$page] ?>">
    <?php endif; ?>
    
    <link rel="icon" href="img/logomini.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Clínica Imagen</title>
</head>
<body>
    <!-- Header -->
<?php if ($page != 'login' && $page != 'register'):?>
    <header id="header">
        <nav style="cursor: pointer;" class="logo-header"><img src="img/logo.png" onclick="window.location.href='index.php'"></nav>
        <div class="buttons-header">
            <?php foreach ($navpages as $slug => $title): ?>
            <nav style="font-family: 'Karla';" class="links-header"><a href="index.php?page=<?php echo $slug ?>"><?php echo $title ?></a></nav>
            <?php endforeach; ?>
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
                    <?php foreach ($navpages as $slug => $title): ?>
                    <a href="index.php?page=<?php echo $slug ?>"><?php echo $title ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </header>
    <?php endif; ?>
    