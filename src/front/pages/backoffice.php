<?php
include_once __DIR__ . '/../../back/check_permission.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/backoffice.css" />
    <title>Panel de Control</title>
</head>
<body>
  <?php if ($hasPermission): ?>
  <aside class="toolbar" id="toolbar">
    <button id="ButtonUsuarios">
      Personal
    </button>
    <button id="ButtonPacientes">
      Pacientes
    </button>
  </aside>
  
  <div class="content">
    <div id="UsuariosMenu">
      <div id="AgregarUsuarioBD">
        <h2>Agregar Nuevo Personal</h2>
        <form id="formAgregarUsuario">
          <label for="nombre">Nombre:</label>
          <input type="text" id="nombre" name="nombre" required>
          
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
          
          <label for="password">Contraseña:</label>
          <input type="password" id="password" name="password" required>
          
          <label for="rol">Rol:</label>
          <select id="rol" name="rol">
            <option value="Admin">Admin</option>
            <option value="Doctor">Doctor</option>
            <option value="Recepcionista">Recepcionista</option>
          </select>
          
          <button type="submit">Agregar Personal</button>
        </form>
        <div id="mensaje"></div>
      </div>

      <div id="EliminarUsuarioBD">
        <h2>Eliminar Personal</h2>
        <form id="formEliminarUsuario">
          <label for="usuarioEliminar">Seleccionar personal:</label>
          <select id="usuarioEliminar" name="id_user" required>
            <!-- Options will be populated by JavaScript -->
          </select>
          <button type="submit">Eliminar Personal</button>
        </form>
        <div id="mensajeEliminar"></div>
      </div>
    </div>

    <div id="PacientesMenu" style="display: none;">
      <div id="EliminarPacienteBD">
        <h2>Modificar o Eliminar Paciente</h2>
        <form id="formBuscarPaciente">
          <label for="cedulaPacienteBuscar">Cédula del paciente:</label>
          <input type="text" id="cedulaPacienteBuscar" name="cedula" required>
          <button type="submit">Buscar Paciente</button>
        </form>
        <div id="paciente-card-container"></div>
        <div id="mensajeEliminarPaciente"></div>
      </div>
    </div>
  </div>
  <script src="/front/script/backoffice.js"></script>
  <?php else: ?>
    <div style="text-align: center; padding: 50px;">
        <h1>Acceso Denegado</h1>
        <p>No tienes permiso para ver esta página.</p>
    </div>
  <?php endif; ?>
</body>
</html>
