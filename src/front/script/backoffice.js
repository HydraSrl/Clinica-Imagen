const toolbar = document.getElementById("toolbar");
 const buttonUsuarios = document.getElementById("ButtonUsuarios")
 const buttonPacientes = document.getElementById("ButtonPacientes")
 const AgregarUsuarioBD = document.getElementById("AgregarUsuarioBD")
 const UsuariosMenu = document.getElementById("UsuariosMenu")
 const PacientesMenu = document.getElementById("PacientesMenu")
 const EliminarUsuarioBD = document.getElementById("EliminarUsuarioBD")
 let Doc = 0;
 
 function cargarToolbarInicial() {
     toolbar.innerHTML = "";
     toolbar.appendChild(buttonUsuarios);
     toolbar.appendChild(buttonPacientes);
     
     const modebtn = document.createElement("button");
     modebtn.textContent="Change theme"
     modebtn.onclick = pressToSwitch;
     toolbar.appendChild(modebtn)
 }
 
  buttonUsuarios.addEventListener('click', () => {
     UsuariosMenu.style.display = "block";
     PacientesMenu.style.display = "none";
     populateUsersToDelete()
 });
 
 buttonPacientes.addEventListener('click', () => {
    UsuariosMenu.style.display = "none";
    PacientesMenu.style.display = "block";
});
 
cargarToolbarInicial()

function pressToSwitch() {
    document.body.classList.toggle('dark-mode');
}

document.getElementById('formAgregarUsuario').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const mensajeDiv = document.getElementById('mensaje');

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
        } else {
            mensajeDiv.className = 'error';
        }
    })
    .catch(error => {
        mensajeDiv.textContent = 'Error en la solicitud: ' + error;
        mensajeDiv.className = 'error';
    });
});

function populateUsersToDelete() {
   fetch('../../back/get_users.php')
       .then(response => response.json())
       .then(data => {
           const select = document.getElementById('usuarioEliminar');
           select.innerHTML = '';
           if (data.success) {
               data.users.forEach(user => {
                   const option = document.createElement('option');
                   option.value = user.id_user;
                   option.textContent = user.nombre;
                   select.appendChild(option);
               });
           } else {
               console.error('Error fetching users:', data.message);
           }
       })
       .catch(error => console.error('Error:', error));
}

document.getElementById('formEliminarUsuario').addEventListener('submit', function(event) {
   event.preventDefault();

   const formData = new FormData(this);
   const mensajeDiv = document.getElementById('mensajeEliminar');

   fetch('../../back/delete_user.php', {
       method: 'POST',
       body: formData
   })
   .then(response => response.json())
   .then(data => {
       mensajeDiv.textContent = data.message;
       if (data.success) {
           mensajeDiv.className = 'success';
           populateUsersToDelete(); // Refresh the list
       } else {
           mensajeDiv.className = 'error';
       }
   })
   .catch(error => {
       mensajeDiv.textContent = 'Error en la solicitud: ' + error;
       mensajeDiv.className = 'error';
   });
});

document.getElementById('formBuscarPaciente').addEventListener('submit', function(event) {
    event.preventDefault();

    const cedula = document.getElementById('cedulaPacienteBuscar').value;
    const mensajeDiv = document.getElementById('mensajeEliminarPaciente');
    const cardContainer = document.getElementById('paciente-card-container');
    cardContainer.innerHTML = '';
    mensajeDiv.textContent = '';

    fetch(`../../back/get_patient_by_cedula.php?cedula=${cedula}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.patient) {
                const patient = data.patient;
                const form = document.createElement('form');
                form.id = 'formModificarPaciente';
                form.innerHTML = `
                    <input type="hidden" name="id" value="${patient.id}">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="${patient.nombre}" required>
                    
                    <label for="cedula">Cédula:</label>
                    <input type="text" id="cedula" name="cedula" value="${patient.cedula}" required>
                    
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="${patient.fecha_nacimiento}" required>
                    
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" value="${patient.telefono}" required>
                    
                    <label for="ciudad">Ciudad:</label>
                    <input type="text" id="ciudad" name="ciudad" value="${patient.ciudad}" required>
                    
                    <button type="submit">Guardar Cambios</button>
                    <button type="button" class="delete-patient-btn" data-cedula="${patient.cedula}">Eliminar Paciente</button>
                `;
                cardContainer.appendChild(form);

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    fetch('../../back/update_patient.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(updateData => {
                        mensajeDiv.textContent = updateData.message;
                        mensajeDiv.className = updateData.success ? 'success' : 'error';
                    })
                    .catch(error => {
                        mensajeDiv.textContent = 'Error al actualizar: ' + error;
                        mensajeDiv.className = 'error';
                    });
                });

                document.querySelector('.delete-patient-btn').addEventListener('click', function() {
                    const cedulaToDelete = this.getAttribute('data-cedula');
                    const formData = new FormData();
                    formData.append('cedula', cedulaToDelete);

                    fetch('../../back/delete_patient.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(deleteData => {
                        mensajeDiv.textContent = deleteData.message;
                        if (deleteData.success) {
                            mensajeDiv.className = 'success';
                            cardContainer.innerHTML = '';
                            document.getElementById('cedulaPacienteBuscar').value = '';
                        } else {
                            mensajeDiv.className = 'error';
                        }
                    })
                    .catch(error => {
                        mensajeDiv.textContent = 'Error en la solicitud de eliminación: ' + error;
                        mensajeDiv.className = 'error';
                    });
                });

            } else {
                mensajeDiv.textContent = data.message;
                mensajeDiv.className = 'error';
            }
        })
        .catch(error => {
            mensajeDiv.textContent = 'Error en la solicitud de búsqueda: ' + error;
            mensajeDiv.className = 'error';
        });
});
