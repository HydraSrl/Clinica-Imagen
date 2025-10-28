<?php
    // Incluir el archivo para obtener los datos del usuario
    include_once __DIR__ . '/../../back/get_patient_data.php';

    $nombre = $userData['nombre'] ?? null;
    $inicial = $nombre ? strtoupper(substr($nombre, 0, 1)) : '?';
?>
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
            <?php
            $navpages_filtered = array_filter($navpages, function($slug) {
                return $slug !== 'perfil';
            }, ARRAY_FILTER_USE_KEY);

            foreach ($navpages_filtered as $slug => $title):
            ?>
            <nav style="font-family: 'Karla';" class="links-header"><a href="index.php?page=<?php echo $slug ?>"><?php echo $title ?></a></nav>
            <?php endforeach; ?>

            <div class="profile-avatar-header">
                <?php if (isset($_SESSION['user_id']) && $nombre): ?>
                    <a href="index.php?page=perfil">
                        <div class="avatar-initial"><?php echo $inicial; ?></div>
                    </a>
                <?php else: ?>
                    <a href="index.php?page=login">
                        <svg class="profile-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
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
    