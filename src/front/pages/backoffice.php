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
    <button id="ButtonCitas">
      Citas
    </button>
  </aside>
  
  <div class="content">
    <div id="DashboardMenu">
      <div class="dashboard-welcome">
        <h1>Bienvenido al Panel de Control</h1>
        <p id="welcomeMessage">Cargando...</p>

        <div id="doctorStats" style="display: none;">
          <div class="stats-card">
            <h3>Citas Asignadas</h3>
            <p class="stats-number" id="totalCitas">0</p>
          </div>
        </div>

        <div class="dashboard-actions">
          <p>Selecciona una opción del menú lateral para comenzar.</p>
        </div>
      </div>
    </div>

    <div id="UsuariosMenu" style="display: none;">
      <div id="FiltrosPersonal">
        <h2>Buscar Personal</h2>
        <form id="formFiltrarPersonal">
          <label for="filtroNombrePersonal">Nombre:</label>
          <input type="text" id="filtroNombrePersonal" name="nombre" placeholder="Ej: Juan">

          <label for="filtroEmailPersonal">Email:</label>
          <input type="text" id="filtroEmailPersonal" name="email" placeholder="Ej: juan@example.com">

          <label for="filtroRolPersonal">Rol:</label>
          <select id="filtroRolPersonal" name="rol">
            <option value="">Todos</option>
            <option value="Admin">Admin</option>
            <option value="Doctor">Doctor</option>
            <option value="Recepcionista">Recepcionista</option>
          </select>

          <button type="submit">Buscar Personal</button>
          <button type="button" id="btnLimpiarFiltrosPersonal">Limpiar Filtros</button>
        </form>
      </div>

      <div id="ListaPersonal">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <h2>Lista de Personal</h2>
          <button id="btnNuevoPersonal" class="btn-primary">+ Nuevo Personal</button>
        </div>
        <div id="tablaPersonalContainer">
          <!-- Table populated by JavaScript -->
        </div>
      </div>

      <div id="FormEditarPersonal" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <h2>Editar Personal</h2>
          <button type="button" id="btnVolverDesdeEdicionPersonal" class="btn-secondary">← Volver</button>
        </div>
        <form id="formEditarPersonal">
          <input type="hidden" id="editPersonalId" name="id_personal">

          <label for="editPersonalNombre">Nombre:</label>
          <input type="text" id="editPersonalNombre" name="nombre" required>

          <label for="editPersonalEmail">Email:</label>
          <input type="email" id="editPersonalEmail" name="email" required>

          <label for="editPersonalRol">Rol:</label>
          <select id="editPersonalRol" name="rol" required>
            <option value="Admin">Admin</option>
            <option value="Doctor">Doctor</option>
            <option value="Recepcionista">Recepcionista</option>
          </select>

          <button type="submit">Guardar Cambios</button>
          <button type="button" id="btnCancelarEdicionPersonal">Cancelar</button>
        </form>
        <div id="mensajeEditarPersonal"></div>
      </div>

      <div id="FormNuevoPersonal" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <h2>Nuevo Personal</h2>
          <button type="button" id="btnVolverDesdeNuevoPersonal" class="btn-secondary">← Volver</button>
        </div>
        <form id="formAgregarUsuario">
          <label for="nombre">Nombre:</label>
          <input type="text" id="nombre" name="nombre" required>

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>

          <label for="password">Contraseña:</label>
          <input type="password" id="password" name="password" required>

          <label for="rol">Rol:</label>
          <select id="rol" name="rol" required>
            <option value="Admin">Admin</option>
            <option value="Doctor">Doctor</option>
            <option value="Recepcionista">Recepcionista</option>
          </select>

          <button type="submit">Crear Personal</button>
          <button type="button" id="btnCancelarNuevoPersonal">Cancelar</button>
        </form>
        <div id="mensajeAgregarPersonal"></div>
      </div>
    </div>

    <div id="PacientesMenu" style="display: none;">
      <div id="FiltrosPacientes">
        <h2>Buscar Pacientes</h2>
        <form id="formFiltrarPacientes">
          <label for="filtroNombrePaciente">Nombre:</label>
          <input type="text" id="filtroNombrePaciente" name="nombre" placeholder="Ej: María">

          <label for="filtroCedulaPaciente">Cédula:</label>
          <input type="text" id="filtroCedulaPaciente" name="cedula" placeholder="Ej: 12345678">

          <label for="filtroCiudadPaciente">Ciudad:</label>
          <input type="text" id="filtroCiudadPaciente" name="ciudad" placeholder="Ej: Montevideo">

          <label for="filtroEmailPaciente">Email:</label>
          <input type="text" id="filtroEmailPaciente" name="email" placeholder="Ej: maria@example.com">

          <button type="submit">Buscar Pacientes</button>
          <button type="button" id="btnLimpiarFiltrosPacientes">Limpiar Filtros</button>
        </form>
      </div>

      <div id="ListaPacientes">
        <h2>Lista de Pacientes</h2>
        <div id="tablaPacientesContainer">
          <!-- Table populated by JavaScript -->
        </div>
      </div>

      <div id="FormEditarPaciente" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <h2>Editar Paciente</h2>
          <button type="button" id="btnVolverDesdeEdicionPaciente" class="btn-secondary">← Volver</button>
        </div>
        <form id="formEditarPaciente">
          <input type="hidden" id="editPacienteId" name="id_paciente">

          <label for="editPacienteNombre">Nombre:</label>
          <input type="text" id="editPacienteNombre" name="nombre" required>

          <label for="editPacienteCedula">Cédula:</label>
          <input type="text" id="editPacienteCedula" name="cedula" required>

          <label for="editPacienteFechaNacimiento">Fecha de Nacimiento:</label>
          <input type="date" id="editPacienteFechaNacimiento" name="fecha_nacimiento" required>

          <label for="editPacienteTelefono">Teléfono:</label>
          <input type="text" id="editPacienteTelefono" name="telefono" required>

          <label for="editPacienteCiudad">Ciudad:</label>
          <input type="text" id="editPacienteCiudad" name="ciudad" required>

          <label for="editPacienteEmail">Email:</label>
          <input type="email" id="editPacienteEmail" name="email" required>

          <button type="submit">Guardar Cambios</button>
          <button type="button" id="btnCancelarEdicionPaciente">Cancelar</button>
          <button type="button" class="delete-patient-btn" id="btnEliminarPaciente">Eliminar Paciente</button>
        </form>
        <div id="mensajeEditarPaciente"></div>
      </div>
    </div>

    <div id="CitasMenu" style="display: none;">
      <div id="FiltrosCitas">
        <h2>Buscar Citas</h2>
        <form id="formFiltrarCitas">
          <label for="filtroCedula">Cédula del paciente:</label>
          <input type="text" id="filtroCedula" name="cedula" placeholder="Ej: 12345678">

          <label for="filtroNombre">Nombre del paciente:</label>
          <input type="text" id="filtroNombre" name="nombre" placeholder="Ej: Juan">

          <label for="filtroEstado">Estado:</label>
          <select id="filtroEstado" name="estado">
            <option value="">Todos</option>
            <option value="pendiente">Pendiente</option>
            <option value="confirmada">Confirmada</option>
          </select>

          <label for="filtroSucursal">Sucursal:</label>
          <select id="filtroSucursal" name="id_sucursal">
            <option value="">Todas</option>
            <!-- Options populated by JavaScript -->
          </select>

          <label for="filtroFechaDesde">Fecha desde:</label>
          <input type="date" id="filtroFechaDesde" name="fecha_desde">

          <label for="filtroFechaHasta">Fecha hasta:</label>
          <input type="date" id="filtroFechaHasta" name="fecha_hasta">

          <button type="submit">Buscar Citas</button>
          <button type="button" id="btnLimpiarFiltros">Limpiar Filtros</button>
        </form>
      </div>

      <div id="ListaCitas">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <h2>Lista de Citas</h2>
          <button id="btnNuevaCita" class="btn-primary">+ Nueva Cita</button>
        </div>
        <div id="tablaCitasContainer">
          <!-- Table populated by JavaScript -->
        </div>
      </div>

      <div id="FormEditarCita" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <h2>Editar Cita</h2>
          <button type="button" id="btnVolverDesdeEdicion" class="btn-secondary">← Volver</button>
        </div>
        <form id="formEditarCita">
          <input type="hidden" id="editCitaId" name="id_cita">

          <div class="form-group-readonly">
            <label>Paciente:</label>
            <p id="editPacienteNombre"></p>
          </div>

          <label for="editSucursal">Sucursal:</label>
          <select id="editSucursal" name="id_sucursal" required>
            <!-- Options populated by JavaScript -->
          </select>

          <label for="editPersonal">Doctor/Personal:</label>
          <select id="editPersonal" name="id_personal">
            <option value="">Sin asignar</option>
            <!-- Options populated by JavaScript -->
          </select>

          <label for="editTratamiento">Tratamiento:</label>
          <select id="editTratamiento" name="id_tratamiento">
            <option value="">Sin asignar</option>
            <!-- Options populated by JavaScript -->
          </select>

          <label for="editFechaCita">Fecha y Hora:</label>
          <input type="datetime-local" id="editFechaCita" name="fecha_cita" required>

          <label for="editDuracion">Duración:</label>
          <select id="editDuracion" name="duracion" required>
            <option value="30">30 minutos</option>
            <option value="60">1 hora</option>
            <option value="90">1 hora 30 minutos</option>
            <option value="120">2 horas</option>
            <option value="150">2 horas 30 minutos</option>
            <option value="180">3 horas</option>
          </select>

          <label for="editEstado">Estado:</label>
          <select id="editEstado" name="estado" required>
            <option value="pendiente">Pendiente</option>
            <option value="confirmada">Confirmada</option>
          </select>

          <button type="submit">Guardar Cambios</button>
          <button type="button" id="btnCancelarEdicion">Cancelar</button>
        </form>
        <div id="mensajeEditarCita"></div>
      </div>

      <div id="FormNuevaCita" style="display: none;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <h2>Nueva Cita</h2>
          <button type="button" id="btnVolverDesdeNuevaCita" class="btn-secondary">← Volver</button>
        </div>

        <div id="BuscarPacienteCita">
          <h3>1. Buscar Paciente</h3>
          <form id="formBuscarPacienteCita">
            <label for="cedulaPacienteCita">Cédula del paciente:</label>
            <input type="text" id="cedulaPacienteCita" name="cedula" required>
            <button type="submit">Buscar Paciente</button>
          </form>
          <div id="pacienteEncontradoContainer"></div>
        </div>

        <div id="DatosCita" style="display: none;">
          <h3>2. Datos de la Cita</h3>
          <form id="formCrearCita">
            <input type="hidden" id="nuevaCitaIdPaciente" name="id_paciente">

            <label for="nuevaCitaSucursal">Sucursal:</label>
            <select id="nuevaCitaSucursal" name="id_sucursal" required>
              <option value="">Seleccione una sucursal</option>
              <!-- Options populated by JavaScript -->
            </select>

            <label for="nuevaCitaPersonal">Doctor/Personal:</label>
            <select id="nuevaCitaPersonal" name="id_personal">
              <option value="">Sin asignar</option>
              <!-- Options populated by JavaScript -->
            </select>

            <label for="nuevaCitaTratamiento">Tratamiento:</label>
            <select id="nuevaCitaTratamiento" name="id_tratamiento">
              <option value="">Sin asignar</option>
              <!-- Options populated by JavaScript -->
            </select>

            <label for="nuevaCitaFecha">Fecha y Hora:</label>
            <input type="datetime-local" id="nuevaCitaFecha" name="fecha_cita" required>

            <label for="nuevaCitaDuracion">Duración:</label>
            <select id="nuevaCitaDuracion" name="duracion" required>
              <option value="30">30 minutos</option>
              <option value="60">1 hora</option>
              <option value="90">1 hora 30 minutos</option>
              <option value="120">2 horas</option>
              <option value="150">2 horas 30 minutos</option>
              <option value="180">3 horas</option>
            </select>

            <label for="nuevaCitaEstado">Estado:</label>
            <select id="nuevaCitaEstado" name="estado" required>
              <option value="pendiente">Pendiente</option>
              <option value="confirmada">Confirmada</option>
            </select>

            <button type="submit">Crear Cita</button>
            <button type="button" id="btnCancelarNuevaCita">Cancelar</button>
          </form>
          <div id="mensajeCrearCita"></div>
        </div>
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
