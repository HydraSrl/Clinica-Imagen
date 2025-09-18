const form = document.getElementById('registerForm');
const mensajeDiv = document.getElementById('mensaje');

function mostrarMensaje(texto, tipo) {
    mensajeDiv.innerHTML = texto;
    mensajeDiv.className = 'mensaje ' + tipo;
}

async function verificarRegister(nombre, birthdate, email, passw) 
{
    try 
    {
        const response = await fetch('/back/signup.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nombre: nombre,
                birthdate: birthdate,
                email: email,
                passw: passw
            })
        });
        
        const data = await response.json();
        if (data.success) mostrarMensaje('Registro exitoso', 'exito');
        else mostrarMensaje('Error al registrarse, usuario ya existente', 'error');
    } catch (error) 
    {
        console.log(error)
        mostrarMensaje('Error de conexión', 'error');
    }
}

form.addEventListener('submit', async function(e) 
{
    e.preventDefault();
    await verificarRegister(nombre, birthdate, email, passw);
});