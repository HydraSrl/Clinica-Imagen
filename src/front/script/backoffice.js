const toolbar = document.getElementById("toolbar");
const menu = document.getElementById("menu");
let Doc = 0 ;

// Objetos con los items para cada opción
const opciones = {
    Caudillos: [{nombre: "Hiara", accion: ()=> Doc==11}, 
                {nombre: "Camila", accion: ()=> Doc==12}, 
                {nombre: "Nicolas", accion: ()=> Doc==13}, 
                {nombre: "Volver", accion: ()=> Doc==0}
            ],
    Mveo_Shopping: [{nombre: "Ramiel", accion: ()=> Doc==21}, 
                {nombre: "Michael", accion: ()=> Doc==22}, 
                {nombre: "Lizandro", accion: ()=> Doc==23}, 
                {nombre: "Volver", accion: ()=> Doc==0}
            ],
    Nuevo_Centro: [{nombre: "Christina", accion: ()=> Doc==31}, 
                {nombre: "Eduardo", accion: ()=> Doc==32}, 
                {nombre: "XD", accion: ()=> Doc==33}, 
                {nombre: "Volver", accion: ()=> Doc==0}
            ],
            
    Lagomar: [{nombre: "Clara", accion: ()=> Doc==41}, 
                {nombre: "Maria", accion: ()=> Doc==42}, 
                {nombre: "Miguel", accion: ()=> Doc==43}, 
                {nombre: "Volver", accion: ()=> Doc==0}
            ],

    Las_Piedras: [{nombre: "Valeria", accion: ()=> Doc==51}, 
                {nombre: "Rodrigo", accion: ()=> Doc==52}, 
                {nombre: "Carlos", accion: ()=> Doc==53}, 
                {nombre: "Volver", accion: ()=> Doc==0}
            ],
    Atlantida: [{nombre: "Javier", accion: ()=> Doc==51}, 
                {nombre: "Ana", accion: ()=> Doc==52}, 
                {nombre: "Diego", accion: ()=> Doc==53}, 
                {nombre: "Volver", accion: ()=> Doc==0}
            ],
    Colonia: [{nombre: "Sahaquiel", accion: ()=> Doc==61}, 
                {nombre: "Sandalphon", accion: ()=> Doc==62}, 
                {nombre: "Gagiel", accion: ()=> Doc==63}, 
                {nombre: "Volver", accion: ()=> Doc==0}
            ],
    Libertad: [{nombre: "Meruel", accion: ()=> Doc==71}, 
                {nombre: "Tabris", accion: ()=> Doc==72}, 
                {nombre: "Armisael", accion: ()=> Doc==73}, 
                {nombre: "Volver", accion: ()=> Doc==0}
            ],
    Punta_del_Este: [{nombre: "Mahito", accion: ()=> Doc==81}, 
                {nombre: "Itadori", accion: ()=> Doc==82}, 
                {nombre: "Jinji", accion: ()=> Doc==83}, 
                {nombre: "Volver", accion: ()=> Doc==0}
            ]
};

function cargarToolbar(seleccion) {
  toolbar.innerHTML = "";
  opciones[seleccion].forEach(item => {
    const btn = document.createElement("button");
    btn.textContent = item.nombre;
    btn.onclick = item.accion;
    toolbar.appendChild(btn);
  });
}
cargarToolbar(menu.value);

menu.addEventListener("change", () => {
    cargarToolbar(menu.value);
});

let whichmode = 0;
const modebtn = document.createElement("button");
const content = document.querySelector(".content")
const h1 = document.querySelector("h1")
const label = document.querySelector("label")
toolbar.appendChild(modebtn)
modebtn.textContent="Change theme"
modebtn.onclick = pressToSwitch;


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
    console.log("ahora es dark mode")
}
function lightMode() {
    content.style.backgroundColor = "white";
    h1.style.color = "black";
    label.style.color = "black";
    console.log("ahora es light mode")
}
function switchMode (whichmode) {
    if (whichmode===0) {
        lightMode()
    } else 
        darkMode()
}
