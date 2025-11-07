const toolbar = document.getElementById("toolbar");
const buttonUsuarios = document.getElementById("ButtonUsuarios");
const buttonPacientes = document.getElementById("ButtonPacientes");
const buttonCitas = document.getElementById("ButtonCitas");
const DashboardMenu = document.getElementById("DashboardMenu");
const UsuariosMenu = document.getElementById("UsuariosMenu");
const PacientesMenu = document.getElementById("PacientesMenu");
const CitasMenu = document.getElementById("CitasMenu");
 
 function cargarToolbarInicial() {
     toolbar.innerHTML = "";
     toolbar.appendChild(buttonUsuarios);
     toolbar.appendChild(buttonPacientes);
     toolbar.appendChild(buttonCitas);

     const modebtn = document.createElement("button");
     modebtn.textContent="Change theme"
     modebtn.onclick = pressToSwitch;
     toolbar.appendChild(modebtn)
 }
 
  buttonUsuarios.addEventListener('click', () => {
     DashboardMenu.style.display = "none";
     UsuariosMenu.style.display = "block";
     PacientesMenu.style.display = "none";
     CitasMenu.style.display = "none";
     loadPersonalMenu();
 });

 buttonPacientes.addEventListener('click', () => {
    DashboardMenu.style.display = "none";
    UsuariosMenu.style.display = "none";
    PacientesMenu.style.display = "block";
    CitasMenu.style.display = "none";
    loadPacientesMenu();
});

buttonCitas.addEventListener('click', () => {
    DashboardMenu.style.display = "none";
    UsuariosMenu.style.display = "none";
    PacientesMenu.style.display = "none";
    CitasMenu.style.display = "block";
    loadCitasMenu();
});
 
cargarToolbarInicial()
loadDashboard()

function pressToSwitch() {
    document.body.classList.toggle('dark-mode');
}

// ============================================
// DASHBOARD FUNCTIONALITY
// ============================================

function loadDashboard() {
    fetch('../../back/get_dashboard_info.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const welcomeMessage = document.getElementById('welcomeMessage');
                welcomeMessage.textContent = `Hola, ${data.nombre} (${data.rol})`;

                // Si es doctor, mostrar las estadísticas de citas
                if (data.rol === 'Doctor' && data.total_citas !== undefined) {
                    const doctorStats = document.getElementById('doctorStats');
                    const totalCitas = document.getElementById('totalCitas');
                    doctorStats.style.display = 'block';
                    totalCitas.textContent = data.total_citas;
                }
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => {
            console.error('Error loading dashboard:', error);
        });
}

// ============================================
// PERSONAL MENU FUNCTIONALITY
// ============================================

function loadPersonalMenu() {
    buscarPersonal();
}

// Buscar personal con filtros
function buscarPersonal() {
    const form = document.getElementById('formFiltrarPersonal');
    if (!form) return;

    const formData = new FormData(form);
    const params = new URLSearchParams();

    for (const [key, value] of formData) {
        if (value && value.trim() !== '') {
            params.append(key, value);
        }
    }

    fetch(`../../back/get_all_personal.php?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarTablaPersonal(data.data);
            } else {
                console.error('Error:', data.message);
                const container = document.getElementById('tablaPersonalContainer');
                if (container) {
                    container.innerHTML = `<p class="error">Error al cargar el personal: ${data.message}</p>`;
                }
            }
        })
        .catch(error => {
            console.error('Error loading personal:', error);
            const container = document.getElementById('tablaPersonalContainer');
            if (container) {
                container.innerHTML = `<p class="error">Error al cargar el personal</p>`;
            }
        });
}

// Mostrar tabla de personal
function mostrarTablaPersonal(personal) {
    const container = document.getElementById('tablaPersonalContainer');

    if (personal.length === 0) {
        container.innerHTML = '<p>No se encontró personal.</p>';
        return;
    }

    const table = document.createElement('table');
    table.className = 'citas-table';
    table.innerHTML = `
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    `;

    const tbody = table.querySelector('tbody');
    personal.forEach(p => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${p.id}</td>
            <td>${p.nombre}</td>
            <td>${p.email}</td>
            <td>${p.rol}</td>
            <td><button class="btn-edit" onclick="editarPersonal(${p.id})">Editar</button></td>
        `;
        tbody.appendChild(tr);
    });

    container.innerHTML = '';
    container.appendChild(table);
}

// Editar personal
window.editarPersonal = function(idPersonal) {
    fetch(`../../back/get_all_personal.php`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const personal = data.data.find(p => p.id == idPersonal);
                if (personal) {
                    document.getElementById('ListaPersonal').style.display = 'none';
                    document.getElementById('FiltrosPersonal').style.display = 'none';
                    document.getElementById('FormEditarPersonal').style.display = 'block';

                    document.getElementById('editPersonalId').value = personal.id;
                    document.getElementById('editPersonalNombre').value = personal.nombre;
                    document.getElementById('editPersonalEmail').value = personal.email;
                    document.getElementById('editPersonalRol').value = personal.rol;
                }
            }
        })
        .catch(error => console.error('Error:', error));
}

// Form filtrar personal
document.getElementById('formFiltrarPersonal').addEventListener('submit', function(e) {
    e.preventDefault();
    buscarPersonal();
});

// Limpiar filtros personal
document.getElementById('btnLimpiarFiltrosPersonal').addEventListener('click', function() {
    document.getElementById('formFiltrarPersonal').reset();
    buscarPersonal();
});

// Form editar personal
document.getElementById('formEditarPersonal').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const mensajeDiv = document.getElementById('mensajeEditarPersonal');

    fetch('../../back/update_personal.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        mensajeDiv.textContent = data.message;
        mensajeDiv.className = data.success ? 'success' : 'error';
        if (data.success) {
            setTimeout(() => {
                document.getElementById('FormEditarPersonal').style.display = 'none';
                document.getElementById('ListaPersonal').style.display = 'block';
                document.getElementById('FiltrosPersonal').style.display = 'block';
                buscarPersonal();
            }, 1500);
        }
    })
    .catch(error => {
        mensajeDiv.textContent = 'Error: ' + error;
        mensajeDiv.className = 'error';
    });
});

// Cancelar edición personal
document.getElementById('btnCancelarEdicionPersonal').addEventListener('click', function() {
    document.getElementById('FormEditarPersonal').style.display = 'none';
    document.getElementById('ListaPersonal').style.display = 'block';
    document.getElementById('FiltrosPersonal').style.display = 'block';
});

// Volver desde edición personal
document.getElementById('btnVolverDesdeEdicionPersonal').addEventListener('click', function() {
    document.getElementById('FormEditarPersonal').style.display = 'none';
    document.getElementById('ListaPersonal').style.display = 'block';
    document.getElementById('FiltrosPersonal').style.display = 'block';
});

// Botón nuevo personal
document.getElementById('btnNuevoPersonal').addEventListener('click', function() {
    document.getElementById('ListaPersonal').style.display = 'none';
    document.getElementById('FiltrosPersonal').style.display = 'none';
    document.getElementById('FormNuevoPersonal').style.display = 'block';
    document.getElementById('formAgregarUsuario').reset();
});

// Form agregar personal
document.getElementById('formAgregarUsuario').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const mensajeDiv = document.getElementById('mensajeAgregarPersonal');

    fetch('../../back/insert_user.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        mensajeDiv.textContent = data.message;
        if (data.success) {
            mensajeDiv.className = 'success';
            this.reset();
            setTimeout(() => {
                document.getElementById('FormNuevoPersonal').style.display = 'none';
                document.getElementById('ListaPersonal').style.display = 'block';
                document.getElementById('FiltrosPersonal').style.display = 'block';
                buscarPersonal();
            }, 1500);
        } else {
            mensajeDiv.className = 'error';
        }
    })
    .catch(error => {
        mensajeDiv.textContent = 'Error en la solicitud: ' + error;
        mensajeDiv.className = 'error';
    });
});

// Cancelar nuevo personal
document.getElementById('btnCancelarNuevoPersonal').addEventListener('click', function() {
    document.getElementById('FormNuevoPersonal').style.display = 'none';
    document.getElementById('ListaPersonal').style.display = 'block';
    document.getElementById('FiltrosPersonal').style.display = 'block';
});

// Volver desde nuevo personal
document.getElementById('btnVolverDesdeNuevoPersonal').addEventListener('click', function() {
    document.getElementById('FormNuevoPersonal').style.display = 'none';
    document.getElementById('ListaPersonal').style.display = 'block';
    document.getElementById('FiltrosPersonal').style.display = 'block';
});

// ============================================
// PACIENTES MENU FUNCTIONALITY
// ============================================

function loadPacientesMenu() {
    buscarPacientes();
}

// Buscar pacientes con filtros
function buscarPacientes() {
    const form = document.getElementById('formFiltrarPacientes');
    if (!form) return;

    const formData = new FormData(form);
    const params = new URLSearchParams();

    for (const [key, value] of formData) {
        if (value && value.trim() !== '') {
            params.append(key, value);
        }
    }

    fetch(`../../back/get_all_patients.php?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarTablaPacientes(data.data);
            } else {
                console.error('Error:', data.message);
                const container = document.getElementById('tablaPacientesContainer');
                if (container) {
                    container.innerHTML = `<p class="error">Error al cargar los pacientes: ${data.message}</p>`;
                }
            }
        })
        .catch(error => {
            console.error('Error loading patients:', error);
            const container = document.getElementById('tablaPacientesContainer');
            if (container) {
                container.innerHTML = `<p class="error">Error al cargar los pacientes</p>`;
            }
        });
}

// Mostrar tabla de pacientes
function mostrarTablaPacientes(pacientes) {
    const container = document.getElementById('tablaPacientesContainer');

    if (pacientes.length === 0) {
        container.innerHTML = '<p>No se encontraron pacientes.</p>';
        return;
    }

    const table = document.createElement('table');
    table.className = 'citas-table';
    table.innerHTML = `
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Ciudad</th>
                <th>Fecha Nacimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    `;

    const tbody = table.querySelector('tbody');
    pacientes.forEach(p => {
        const tr = document.createElement('tr');
        const fechaNac = new Date(p.fecha_nacimiento).toLocaleDateString('es-UY');
        tr.innerHTML = `
            <td>${p.id}</td>
            <td>${p.nombre}</td>
            <td>${p.cedula}</td>
            <td>${p.email}</td>
            <td>${p.telefono}</td>
            <td>${p.ciudad}</td>
            <td>${fechaNac}</td>
            <td><button class="btn-edit" onclick="editarPaciente(${p.id})">Editar</button></td>
        `;
        tbody.appendChild(tr);
    });

    container.innerHTML = '';
    container.appendChild(table);
}

// Editar paciente
window.editarPaciente = function(idPaciente) {
    fetch(`../../back/get_all_patients.php`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const paciente = data.data.find(p => p.id == idPaciente);
                if (paciente) {
                    document.getElementById('ListaPacientes').style.display = 'none';
                    document.getElementById('FiltrosPacientes').style.display = 'none';
                    document.getElementById('FormEditarPaciente').style.display = 'block';

                    document.getElementById('editPacienteId').value = paciente.id;
                    document.getElementById('editPacienteNombre').value = paciente.nombre;
                    document.getElementById('editPacienteCedula').value = paciente.cedula;
                    document.getElementById('editPacienteFechaNacimiento').value = paciente.fecha_nacimiento;
                    document.getElementById('editPacienteTelefono').value = paciente.telefono;
                    document.getElementById('editPacienteCiudad').value = paciente.ciudad;
                    document.getElementById('editPacienteEmail').value = paciente.email;
                }
            }
        })
        .catch(error => console.error('Error:', error));
}

// Form filtrar pacientes
document.getElementById('formFiltrarPacientes').addEventListener('submit', function(e) {
    e.preventDefault();
    buscarPacientes();
});

// Limpiar filtros pacientes
document.getElementById('btnLimpiarFiltrosPacientes').addEventListener('click', function() {
    document.getElementById('formFiltrarPacientes').reset();
    buscarPacientes();
});

// Form editar paciente
document.getElementById('formEditarPaciente').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const mensajeDiv = document.getElementById('mensajeEditarPaciente');

    fetch('../../back/update_patient.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        mensajeDiv.textContent = data.message;
        mensajeDiv.className = data.success ? 'success' : 'error';
        if (data.success) {
            setTimeout(() => {
                document.getElementById('FormEditarPaciente').style.display = 'none';
                document.getElementById('ListaPacientes').style.display = 'block';
                document.getElementById('FiltrosPacientes').style.display = 'block';
                buscarPacientes();
            }, 1500);
        }
    })
    .catch(error => {
        mensajeDiv.textContent = 'Error: ' + error;
        mensajeDiv.className = 'error';
    });
});

// Cancelar edición paciente
document.getElementById('btnCancelarEdicionPaciente').addEventListener('click', function() {
    document.getElementById('FormEditarPaciente').style.display = 'none';
    document.getElementById('ListaPacientes').style.display = 'block';
    document.getElementById('FiltrosPacientes').style.display = 'block';
});

// Volver desde edición paciente
document.getElementById('btnVolverDesdeEdicionPaciente').addEventListener('click', function() {
    document.getElementById('FormEditarPaciente').style.display = 'none';
    document.getElementById('ListaPacientes').style.display = 'block';
    document.getElementById('FiltrosPacientes').style.display = 'block';
});

// Eliminar paciente
document.getElementById('btnEliminarPaciente').addEventListener('click', function() {
    const idPaciente = document.getElementById('editPacienteId').value;
    const cedulaPaciente = document.getElementById('editPacienteCedula').value;
    const mensajeDiv = document.getElementById('mensajeEditarPaciente');

    if (confirm('¿Está seguro de que desea eliminar este paciente?')) {
        const formData = new FormData();
        formData.append('cedula', cedulaPaciente);

        fetch('../../back/delete_patient.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            mensajeDiv.textContent = data.message;
            mensajeDiv.className = data.success ? 'success' : 'error';
            if (data.success) {
                setTimeout(() => {
                    document.getElementById('FormEditarPaciente').style.display = 'none';
                    document.getElementById('ListaPacientes').style.display = 'block';
                    document.getElementById('FiltrosPacientes').style.display = 'block';
                    buscarPacientes();
                }, 1500);
            }
        })
        .catch(error => {
            mensajeDiv.textContent = 'Error: ' + error;
            mensajeDiv.className = 'error';
        });
    }
});

// ============================================
// CITAS MENU FUNCTIONALITY
// ============================================

function loadCitasMenu() {
    populateSucursalesDropdowns();
    populatePersonalDropdowns();
    populateTratamientosDropdowns();
    buscarCitas();
}

// Populate dropdowns
function populateSucursalesDropdowns() {
    fetch('../../back/get_sucursales_list.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const selects = [
                    document.getElementById('filtroSucursal'),
                    document.getElementById('editSucursal'),
                    document.getElementById('nuevaCitaSucursal')
                ];

                selects.forEach(select => {
                    if (select) {
                        const currentValue = select.value;
                        const isFilter = select.id === 'filtroSucursal';
                        select.innerHTML = isFilter ? '<option value="">Todas</option>' : '<option value="">Seleccione una sucursal</option>';
                        data.data.forEach(sucursal => {
                            const option = document.createElement('option');
                            option.value = sucursal.id;
                            option.textContent = sucursal.nombre;
                            select.appendChild(option);
                        });
                        if (currentValue) select.value = currentValue;
                    }
                });
            }
        })
        .catch(error => console.error('Error loading sucursales:', error));
}

function populatePersonalDropdowns() {
    fetch('../../back/get_personal_list.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const selects = [
                    document.getElementById('editPersonal'),
                    document.getElementById('nuevaCitaPersonal')
                ];

                selects.forEach(select => {
                    if (select) {
                        const currentValue = select.value;
                        select.innerHTML = '<option value="">Sin asignar</option>';
                        data.data.forEach(personal => {
                            const option = document.createElement('option');
                            option.value = personal.id;
                            option.textContent = `${personal.nombre} (${personal.rol})`;
                            select.appendChild(option);
                        });
                        if (currentValue) select.value = currentValue;
                    }
                });
            }
        })
        .catch(error => console.error('Error loading personal:', error));
}

function populateTratamientosDropdowns() {
    fetch('../../back/get_tratamientos_list.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const selects = [
                    document.getElementById('editTratamiento'),
                    document.getElementById('nuevaCitaTratamiento')
                ];

                selects.forEach(select => {
                    if (select) {
                        const currentValue = select.value;
                        select.innerHTML = '<option value="">Sin asignar</option>';
                        data.data.forEach(tratamiento => {
                            const option = document.createElement('option');
                            option.value = tratamiento.id;
                            option.textContent = tratamiento.nombre;
                            select.appendChild(option);
                        });
                        if (currentValue) select.value = currentValue;
                    }
                });
            }
        })
        .catch(error => console.error('Error loading tratamientos:', error));
}

// Buscar citas con filtros
function buscarCitas() {
    const form = document.getElementById('formFiltrarCitas');
    if (!form) return;

    const formData = new FormData(form);
    const params = new URLSearchParams();

    for (const [key, value] of formData) {
        if (value && value.trim() !== '') {
            params.append(key, value);
        }
    }

    fetch(`../../back/get_all_appointments.php?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarTablaCitas(data.data);
            } else {
                console.error('Error:', data.message);
                const container = document.getElementById('tablaCitasContainer');
                if (container) {
                    container.innerHTML = `<p class="error">Error al cargar las citas: ${data.message}</p>`;
                }
            }
        })
        .catch(error => {
            console.error('Error loading appointments:', error);
            const container = document.getElementById('tablaCitasContainer');
            if (container) {
                container.innerHTML = `<p class="error">Error al cargar las citas</p>`;
            }
        });
}

// Mostrar tabla de citas
function mostrarTablaCitas(citas) {
    const container = document.getElementById('tablaCitasContainer');

    if (citas.length === 0) {
        container.innerHTML = '<p>No se encontraron citas.</p>';
        return;
    }

    const table = document.createElement('table');
    table.className = 'citas-table';
    table.innerHTML = `
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Cédula</th>
                <th>Fecha/Hora</th>
                <th>Sucursal</th>
                <th>Doctor</th>
                <th>Tratamiento</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    `;

    const tbody = table.querySelector('tbody');
    citas.forEach(cita => {
        const tr = document.createElement('tr');
        const fechaCita = new Date(cita.fecha_cita);
        const fechaFormateada = fechaCita.toLocaleString('es-UY');

        tr.innerHTML = `
            <td>${cita.id}</td>
            <td>${cita.paciente_nombre}</td>
            <td>${cita.paciente_cedula}</td>
            <td>${fechaFormateada}</td>
            <td>${cita.sucursal_nombre}</td>
            <td>${cita.personal_nombre || 'Sin asignar'}</td>
            <td>${cita.tratamiento_nombre || 'Sin asignar'}</td>
            <td><span class="badge badge-${cita.estado}">${cita.estado}</span></td>
            <td><button class="btn-edit" onclick="editarCita(${cita.id})">Editar</button></td>
        `;
        tbody.appendChild(tr);
    });

    container.innerHTML = '';
    container.appendChild(table);
}

// Editar cita
window.editarCita = function(idCita) {
    fetch(`../../back/get_all_appointments.php`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const cita = data.data.find(c => c.id == idCita);
                if (cita) {
                    document.getElementById('ListaCitas').style.display = 'none';
                    document.getElementById('FiltrosCitas').style.display = 'none';
                    document.getElementById('FormEditarCita').style.display = 'block';

                    document.getElementById('editCitaId').value = cita.id;
                    document.getElementById('editPacienteNombre').textContent = `${cita.paciente_nombre} (${cita.paciente_cedula})`;
                    document.getElementById('editSucursal').value = cita.id_sucursal || '';
                    document.getElementById('editPersonal').value = cita.id_personal || '';
                    document.getElementById('editTratamiento').value = cita.id_tratamiento || '';

                    const fecha = new Date(cita.fecha_cita);
                    const fechaLocal = new Date(fecha.getTime() - fecha.getTimezoneOffset() * 60000);
                    document.getElementById('editFechaCita').value = fechaLocal.toISOString().slice(0, 16);

                    document.getElementById('editEstado').value = cita.estado;
                }
            }
        })
        .catch(error => console.error('Error:', error));
}

// Form filtrar citas
document.getElementById('formFiltrarCitas').addEventListener('submit', function(e) {
    e.preventDefault();
    buscarCitas();
});

// Limpiar filtros
document.getElementById('btnLimpiarFiltros').addEventListener('click', function() {
    document.getElementById('formFiltrarCitas').reset();
    buscarCitas();
});

// Form editar cita
document.getElementById('formEditarCita').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const mensajeDiv = document.getElementById('mensajeEditarCita');

    fetch('../../back/update_appointment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        mensajeDiv.textContent = data.message;
        mensajeDiv.className = data.success ? 'success' : 'error';
        if (data.success) {
            setTimeout(() => {
                document.getElementById('FormEditarCita').style.display = 'none';
                document.getElementById('ListaCitas').style.display = 'block';
                document.getElementById('FiltrosCitas').style.display = 'block';
                buscarCitas();
            }, 1500);
        }
    })
    .catch(error => {
        mensajeDiv.textContent = 'Error: ' + error;
        mensajeDiv.className = 'error';
    });
});

// Cancelar edición
document.getElementById('btnCancelarEdicion').addEventListener('click', function() {
    document.getElementById('FormEditarCita').style.display = 'none';
    document.getElementById('ListaCitas').style.display = 'block';
    document.getElementById('FiltrosCitas').style.display = 'block';
});

// Volver desde edición
document.getElementById('btnVolverDesdeEdicion').addEventListener('click', function() {
    document.getElementById('FormEditarCita').style.display = 'none';
    document.getElementById('ListaCitas').style.display = 'block';
    document.getElementById('FiltrosCitas').style.display = 'block';
});

// Cancelar cita
document.getElementById('btnCancelarCita').addEventListener('click', function() {
    const idCita = document.getElementById('editCitaId').value;
    const mensajeDiv = document.getElementById('mensajeEditarCita');

    if (confirm('¿Está seguro de que desea cancelar esta cita?')) {
        const formData = new FormData();
        formData.append('id_cita', idCita);

        fetch('../../back/cancel_appointment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            mensajeDiv.textContent = data.message;
            mensajeDiv.className = data.success ? 'success' : 'error';
            if (data.success) {
                setTimeout(() => {
                    document.getElementById('FormEditarCita').style.display = 'none';
                    document.getElementById('ListaCitas').style.display = 'block';
                    document.getElementById('FiltrosCitas').style.display = 'block';
                    buscarCitas();
                }, 1500);
            }
        })
        .catch(error => {
            mensajeDiv.textContent = 'Error: ' + error;
            mensajeDiv.className = 'error';
        });
    }
});

// Botón nueva cita
document.getElementById('btnNuevaCita').addEventListener('click', function() {
    document.getElementById('ListaCitas').style.display = 'none';
    document.getElementById('FiltrosCitas').style.display = 'none';
    document.getElementById('FormNuevaCita').style.display = 'block';
    document.getElementById('DatosCita').style.display = 'none';
    document.getElementById('pacienteEncontradoContainer').innerHTML = '';
    document.getElementById('formBuscarPacienteCita').reset();
});

// Buscar paciente para nueva cita
document.getElementById('formBuscarPacienteCita').addEventListener('submit', function(e) {
    e.preventDefault();
    const cedula = document.getElementById('cedulaPacienteCita').value;
    const container = document.getElementById('pacienteEncontradoContainer');

    fetch(`../../back/get_patient_by_cedula.php?cedula=${cedula}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.patient) {
                const patient = data.patient;
                container.innerHTML = `
                    <div class="paciente-info">
                        <h4>Paciente encontrado:</h4>
                        <p><strong>Nombre:</strong> ${patient.nombre}</p>
                        <p><strong>Cédula:</strong> ${patient.cedula}</p>
                        <p><strong>Teléfono:</strong> ${patient.telefono}</p>
                        <p><strong>Ciudad:</strong> ${patient.ciudad}</p>
                    </div>
                `;
                document.getElementById('nuevaCitaIdPaciente').value = patient.id;
                document.getElementById('DatosCita').style.display = 'block';
            } else {
                container.innerHTML = `<p class="error">${data.message || 'Paciente no encontrado'}</p>`;
                document.getElementById('DatosCita').style.display = 'none';
            }
        })
        .catch(error => {
            container.innerHTML = `<p class="error">Error: ${error}</p>`;
        });
});

// Form crear cita
document.getElementById('formCrearCita').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const mensajeDiv = document.getElementById('mensajeCrearCita');

    fetch('../../back/create_appointment_admin.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        mensajeDiv.textContent = data.message;
        mensajeDiv.className = data.success ? 'success' : 'error';
        if (data.success) {
            this.reset();
            setTimeout(() => {
                document.getElementById('FormNuevaCita').style.display = 'none';
                document.getElementById('ListaCitas').style.display = 'block';
                document.getElementById('FiltrosCitas').style.display = 'block';
                buscarCitas();
            }, 1500);
        }
    })
    .catch(error => {
        mensajeDiv.textContent = 'Error: ' + error;
        mensajeDiv.className = 'error';
    });
});

// Cancelar nueva cita
document.getElementById('btnCancelarNuevaCita').addEventListener('click', function() {
    document.getElementById('FormNuevaCita').style.display = 'none';
    document.getElementById('ListaCitas').style.display = 'block';
    document.getElementById('FiltrosCitas').style.display = 'block';
});

// Volver desde nueva cita
document.getElementById('btnVolverDesdeNuevaCita').addEventListener('click', function() {
    document.getElementById('FormNuevaCita').style.display = 'none';
    document.getElementById('ListaCitas').style.display = 'block';
    document.getElementById('FiltrosCitas').style.display = 'block';
    document.getElementById('DatosCita').style.display = 'none';
    document.getElementById('pacienteEncontradoContainer').innerHTML = '';
    document.getElementById('formBuscarPacienteCita').reset();
});
