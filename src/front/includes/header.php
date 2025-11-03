<?php
// Incluir el archivo para obtener los datos del usuario
include_once __DIR__ . '/../../back/get_patient_data.php';

$nombre = $userData['nombre'] ?? null;
$inicial = $nombre ? strtoupper(substr($nombre, 0, 1)) : '?';
?>

<!-- Header -->
<?php if ($page != 'login' && $page != 'register'): ?>

    <link rel="stylesheet" href="
        <?php
        if ($aux == 'pages') {
            echo "../styles/menu.css";
        } else {
            echo "styles/menu.css";
        } ?>">

    <header id="header">
        <nav>
            <img src="<?php
        if ($aux == 'pages') {
            echo "../img/logo.png";
        } else {
            echo "img/logo.png";
        } ?>" onclick="window.location.href='index.php'">

            <ul>
                <li><a href="">Sobre nosotros</a></li>
                <li><a href="">Agenda</a></li>
                <li><a href="">Tratamientos</a></li>
                <li>
                    <?php if (isset($_SESSION['user_id']) && $nombre): ?>
                        <a href="index.php?page=perfil">
                            <div class="avatar-initial"><?php echo $inicial; ?></div>
                        </a>
                    <?php else: ?>
                        <a href="index.php?page=login">
                            <svg class="profile-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
        <div>
            <p>Sucursal Montevideo Shopping</p>
            <p>|</p>
            <p>Horario de atención: 08:00hs a 19:00hs</p>
        </div>
    </header>
<?php endif; ?>