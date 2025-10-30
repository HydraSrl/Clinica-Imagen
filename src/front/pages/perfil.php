<?php
include 'includes/header.php';
include '../back/get_patient_data.php';
include '../back/get_appointments.php';

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
                <div class="avatar_initial"><?php echo $inicial; ?></div>
            </div>
            <div class="profile-info">
                <h1 class="profile-name"><?php echo htmlspecialchars($nombre); ?></h1>
                <div class="profile-contact">
                    <?php if (!empty($email) && $email !== 'No disponible'): ?>
                    <p><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    </span> <?php echo htmlspecialchars($email); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="profile-content">
            <h2>Mis Próximas Citas</h2>
            <ul class="appointments-list">
                <?php if (!empty($appointments)): ?>
                    <?php foreach ($appointments as $cita): ?>
                        <li>
                            <p><strong>Fecha y Hora:</strong> <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($cita['fecha_cita']))); ?>hs</p>
                            <?php if (isset($cita['tratamiento_nombre'])): ?>
                                <p><strong>Tratamiento:</strong> <?php echo htmlspecialchars($cita['tratamiento_nombre']); ?></p>
                            <?php else: ?>
                                <p><strong>Tipo de cita:</strong> Consulta</p>
                            <?php endif; ?>
                            <?php if (isset($cita['personal_nombre'])): ?>
                                <p><strong>Atendido por:</strong> <?php echo htmlspecialchars($cita['personal_nombre']); ?></p>
                            <?php endif; ?>
                            <p><strong>Sucursal:</strong> <?php echo htmlspecialchars($cita['sucursal_nombre']); ?></p>
                            <p><strong>Estado:</strong> <?php echo htmlspecialchars(ucfirst($cita['estado'])); ?></p>
                            <p><strong>Fecha de Creación:</strong> <?php echo htmlspecialchars(date('d/m/Y', strtotime($cita['fecha_creacion']))); ?></p>
                            <form action="../back/delete_appointment.php" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres cancelar esta cita?');">
                                <input type="hidden" name="appointment_id" value="<?php echo $cita['id']; ?>">
                                <button type="submit" class="cancel-button">Cancelar Cita</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="no-appointments">
                        <p>No tiene próximas citas.</p>
                        <a href="index.php?page=agenda" class="schedule-button">Agendar Cita</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="sesion-button">
        <a href="index.php?page=logout"><p>Cerrar Sesion</p></a>
    </div>
</body>
</html>
