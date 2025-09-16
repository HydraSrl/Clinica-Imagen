const form = document.getElementById('loginForm');
const mensajeDiv = document.getElementById('mensaje');

function mostrarMensaje(texto, tipo) {
    mensajeDiv.innerHTML = texto;
    mensajeDiv.className = 'mensaje ' + tipo;
}

async function verificarLogin(usuario, pass) 
{
    try 
    {
        const response = await fetch('/back/auth.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                usuario: usuario,
                pass: pass
            })
        });
        
        const data = await response.json();
        if (data.success) mostrarMensaje('¡Login exitoso!', 'exito');
        else mostrarMensaje('Usuario o contraseña incorrectos', 'error');
    } catch (error) 
    {
        console.log(error)
        mostrarMensaje('Error de conexión', 'error');
    }
}

form.addEventListener('submit', async function(e) 
{
    e.preventDefault();
    const usuario = document.getElementById('usuario').value;
    const pass = document.getElementById('pass').value;
    await verificarLogin(usuario, pass);
});
