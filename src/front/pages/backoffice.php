<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/backoffice.css" />
    <title>Panel de Control</title>
</head>
<body>
  <aside class="toolbar" id="toolbar">
    <button id="ButtonSucursales">
      Sucursales
    </button>
  </aside>
  
  <div class="content">
    <div id="SucursalesMenu">
      <h1>Panel de control</h1>
      <label for="menu">Elige un menú:</label>
      <select id="menu">
        <option value="Caudillos">Caudillos</option>
        <option value="Mveo_Shopping">Mveo Shopping</option>
        <option value="Nuevo_Centro">Nuevo Centro</option>
        <option value="Lagomar">Lagomar</option>
        <option value="Las_Piedras">Las Piedras</option>
        <option value="Atlantida">Atlantida</option>
        <option value="Colonia">Colonia</option>
        <option value="Libertad">Libertad</option>
        <option value="Punta_del_Este">Punta del Este</option>
      </select>
    </div>
    <div id="AgregarUsuarioBD">
      <h2>Agregar Nuevo Usuario</h2>
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
          <option value="Paciente">Paciente</option>
        </select>
        
        <button type="submit">Agregar Usuario</button>
      </form>
      <div id="mensaje"></div>
    </div>
  </div>
</body>
<script src="/front/script/backoffice.js"></script>
</html>
