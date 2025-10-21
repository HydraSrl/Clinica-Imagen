<?php
include 'includes/header.php';
include '../back/get_patient_data.php';

$nombre = $userData['nombre'] ?? 'Usuario no encontrado';
$email = $userData['email'] ?? 'No disponible';
$inicial = !empty($userData['nombre']) ? strtoupper(substr($userData['nombre'], 0, 1)) : '?';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-avatar">
                <div class="avatar-initial"><?php echo $inicial; ?></div>
            </div>
            <div class="profile-info">
                <h1 class="profile-name"><?php echo htmlspecialchars($nombre); ?></h1>
                <div class="profile-contact">
                    <p><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    </span> <?php echo htmlspecialchars($email); ?></p>
                </div>
            </div>
        </div>
        <div class="profile-content">
            <h2>Mis Próximas Citas</h2>
            <ul class="appointments-list">
                <li>Control de Ortodoncia - 25 de Octubre, 2024 - 15:30</li>
                <li>Limpieza Dental - 15 de Noviembre, 2024 - 10:00</li>
                <li>Consulta General - 10 de Diciembre, 2024 - 09:00</li>
            </ul>
        </div>
    </div>
    <div>
        <a href="index.php?page=logout"><p>Cerrar Sesion</p></a>
    </div>
</body>
</html>
