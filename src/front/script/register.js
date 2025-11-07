const form = document.getElementById('registerForm');
const mensajeDiv = document.getElementById('mensaje');

function mostrarMensaje(texto, tipo) {
    mensajeDiv.innerHTML = texto;
    mensajeDiv.className = 'mensaje ' + tipo;
}

function validarContrasena(password) {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    return regex.test(password);
}

function validarEdad(birthdate) {
    const today = new Date();
    const birth = new Date(birthdate);
    let age = today.getFullYear() - birth.getFullYear();
    const monthDiff = today.getMonth() - birth.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
    }

    return age >= 18;
}

function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

async function verificarRegister(nombre, birthdate, email, passw, cedula, ciudad, telefono)
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
                passw: passw,
                cedula: cedula,
                ciudad: ciudad,
                telefono: telefono
            })
        });

        const data = await response.json();
        if (data.success) {
            mostrarMensaje('Registro exitoso. Redirigiendo...', 'exito');
            setTimeout(() => {
                window.location.href = '/front/index.php?page=perfil';
            }, 1500);
        } else {
            mostrarMensaje(data.error || 'Error al registrarse', 'error');
        }
    } catch (error)
    {
        console.log(error)
        mostrarMensaje('Error de conexión', 'error');
    }
}

form.addEventListener('submit', async function(e)
{
    e.preventDefault();
    const nombre = document.getElementById('nombre').value;
    const birthdate = document.getElementById('birthdate').value;
    const email = document.getElementById('email').value;
    const passw = document.getElementById('passw').value;
    const cedula = document.getElementById('cedula').value;
    const telefono = document.getElementById('phonenum').value;
    const ciudad = document.getElementById('ciudad').value;

    // Validaciones
    if (!validarEmail(email)) {
        mostrarMensaje('Por favor, ingrese un correo electrónico válido', 'error');
        return;
    }

    if (!validarEdad(birthdate)) {
        mostrarMensaje('Debes ser mayor de 18 años para registrarte', 'error');
        return;
    }

    if (!validarContrasena(passw)) {
        mostrarMensaje('La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas, números y caracteres especiales (@$!%*?&)', 'error');
        return;
    }

    await verificarRegister(nombre, birthdate, email, passw, cedula, ciudad, telefono);
});