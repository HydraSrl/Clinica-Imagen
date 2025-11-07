<?php include 'includes/header.php'; ?>
<main>
    <section class="sectionAgenda">
        <h1>Agendar Cita</h1>
        <div class="agenda-container">
            <div class="agenda-column">
                <h2>1. Seleccione Sucursal</h2>
                <div class="form-group">
                    <label for="sucursal">Sucursal:</label>
                    <select id="sucursal" name="sucursal"></select>
                </div>
                
                <h2>2. Seleccione un Día</h2>
                <div id="calendario"></div>
            </div>
            <div class="agenda-column">
                <h2>3. Seleccione un Horario</h2>
                <div id="horarios-disponibles">
                    <p>Por favor, seleccione una sucursal y un día para ver los horarios disponibles.</p>
                </div>
                <button id="btn-agendar" class="disabled" disabled>Agendar Cita</button>
            </div>
        </div>
    </section>
</main>
<script src="script/agenda.js"></script>
</body>
</html>