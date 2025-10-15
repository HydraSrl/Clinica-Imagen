const toolbar = document.getElementById("toolbar");
const menu = document.getElementById("menu");
const SucursalesMenu = document.getElementById("SucursalesMenu")
const buttonSucursales = document.getElementById("ButtonSucursales")
const buttonUsuarios = document.getElementById("ButtonUsuarios")
const AgregarUsuarioBD = document.getElementById("AgregarUsuarioBD")
const UsuariosMenu = document.getElementById("UsuariosMenu")
const EliminarUsuarioBD = document.getElementById("EliminarUsuarioBD")
let Doc = 0;

// Objetos con los items para cada opción
const opciones = {
    Caudillos: [{nombre: "Hiara", accion: ()=> Doc==11}, 
                {nombre: "Camila", accion: ()=> Doc==12}, 
                {nombre: "Nicolas", accion: ()=> Doc==13}, 
                {nombre: "Volver", accion: cargarToolbarInicial}
            ],
    Mveo_Shopping: [{nombre: "Ramiel", accion: ()=> Doc==21}, 
                {nombre: "Michael", accion: ()=> Doc==22}, 
                {nombre: "Lizandro", accion: ()=> Doc==23}, 
                {nombre: "Volver", accion: cargarToolbarInicial}
            ],
    Nuevo_Centro: [{nombre: "Christina", accion: ()=> Doc==31}, 
                {nombre: "Eduardo", accion: ()=> Doc==32}, 
                {nombre: "XD", accion: ()=> Doc==33}, 
                {nombre: "Volver", accion: cargarToolbarInicial}
            ],
            
    Lagomar: [{nombre: "Clara", accion: ()=> Doc==41}, 
                {nombre: "Maria", accion: ()=> Doc==42}, 
                {nombre: "Miguel", accion: ()=> Doc==43}, 
                {nombre: "Volver", accion: cargarToolbarInicial}
            ],

    Las_Piedras: [{nombre: "Valeria", accion: ()=> Doc==51}, 
                {nombre: "Rodrigo", accion: ()=> Doc==52}, 
                {nombre: "Carlos", accion: ()=> Doc==53}, 
                {nombre: "Volver", accion: cargarToolbarInicial}
            ],
    Atlantida: [{nombre: "Javier", accion: ()=> Doc==51}, 
                {nombre: "Ana", accion: ()=> Doc==52}, 
                {nombre: "Diego", accion: ()=> Doc==53}, 
                {nombre: "Volver", accion: cargarToolbarInicial}
            ],
    Colonia: [{nombre: "Sahaquiel", accion: ()=> Doc==61}, 
                {nombre: "Sandalphon", accion: ()=> Doc==62}, 
                {nombre: "Gagiel", accion: ()=> Doc==63}, 
                {nombre: "Volver", accion: cargarToolbarInicial}
            ],
    Libertad: [{nombre: "Meruel", accion: ()=> Doc==71}, 
                {nombre: "Tabris", accion: ()=> Doc==72}, 
                {nombre: "Armisael", accion: ()=> Doc==73}, 
                {nombre: "Volver", accion: cargarToolbarInicial}
            ],
    Punta_del_Este: [{nombre: "Mahito", accion: ()=> Doc==81}, 
                {nombre: "Itadori", accion: ()=> Doc==82}, 
                {nombre: "Jinji", accion: ()=> Doc==83}, 
                {nombre: "Volver", accion: cargarToolbarInicial}
            ]
};

function cargarToolbar(seleccion) {
  toolbar.innerHTML = "";
  opciones[seleccion].forEach(item => {
    const btn = document.createElement("button");
    btn.textContent = item.nombre;
    btn.onclick = item.accion;
    toolbar.appendChild(btn);
    SucursalesMenu.style.display = "block"
  });
}

function cargarToolbarInicial() {
    toolbar.innerHTML = "";
    toolbar.appendChild(buttonSucursales);
    toolbar.appendChild(buttonUsuarios);
    AgregarUsuarioBD.style.display = "block"
    
    const modebtn = document.createElement("button");
    modebtn.textContent="Change theme"
    modebtn.onclick = pressToSwitch;
    toolbar.appendChild(modebtn)
    SucursalesMenu.style.display = "none"
}

buttonSucursales.addEventListener('click', () => {
    cargarToolbar(menu.value);
    AgregarUsuarioBD.style.display = "none"
    UsuariosMenu.style.display = "none"
 });

 buttonUsuarios.addEventListener('click', () => {
    SucursalesMenu.style.display = "none";
    UsuariosMenu.style.display = "block";
    cargarToolbarInicial()
    populateUsersToDelete()
});
 
 menu.addEventListener("change", () => {
     cargarToolbar(menu.value);
 });
 
 
 let whichmode = 0;
const content = document.querySelector(".content")
const h1 = document.querySelector("h1")
const label = document.querySelector("label")

cargarToolbarInicial()

function pressToSwitch() {
    if(whichmode===0) {
        whichmode=1;
        console.log(whichmode)
        switchMode(whichmode)
    } else {
        whichmode=0;
        console.log(whichmode)
        switchMode(whichmode)
    }
}
function darkMode() {
    content.style.backgroundColor = "#141414";
    h1.style.color = "#ffffff";
    label.style.color = "#ffffff";
    AgregarUsuarioBD.style.color = "#ffffff"
}
function lightMode() {
    content.style.backgroundColor = "white";
    h1.style.color = "black";
    label.style.color = "black";
    AgregarUsuarioBD.style.color = "black"
}
function switchMode (whichmode) {
    if (whichmode===0) {
        lightMode()
    } else 
        darkMode()
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
