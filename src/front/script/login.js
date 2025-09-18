const form = document.getElementById('loginForm');
const mensajeDiv = document.getElementById('mensaje');

function mostrarMensaje(texto, tipo) {
    mensajeDiv.innerHTML = texto;
    mensajeDiv.className = 'mensaje ' + tipo;
}

async function verificarLogin(email, passw) 
{
    try 
    {
        const response = await fetch('/back/auth.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                passw: passw
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
    const email = document.getElementById('email').value;
    const passw = document.getElementById('passw').value;
    await verificarLogin(email, passw);
});
