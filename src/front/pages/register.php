<?php include 'includes/header.php' ?>

<body>
    <main>
        <section class="login">
            <div class="login_back">
                <div class="login_box">
                    <button type="button" class="homeButton" onclick="location.href=('index.php?page=inicio')"><img src="/front/img/IconoCasa.webp"></button>
                    <div class="login_deco_box">
                        <p class="hover-efect" onclick="location='index.php?page=login'">Login   </p>
                        <p class="login_actual_loc">| Registrate</p>
                    </div>
                    <form id="registerForm" class="login_box2">
                        <input id="nombre" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras y espacios" placeholder="Nombre" required>
                        <input id="birthdate" placeholder="Fecha de nacimiento" type="date" required>
                        <input id="email" type="email" placeholder="Email" required>
                        <input id="cedula" placeholder="Cedula" pattern="^[0-9]{7,8}$" title="La cédula debe tener 7 u 8 dígitos" required>
                        <input id="ciudad" placeholder="Ciudad" required>
                        <input id="phonenum" placeholder="Telefono" pattern="^[0-9]{8,9}$" title="El teléfono debe tener 8 o 9 dígitos" required>
                        <input id="passw" placeholder="Contraseña" type="password" minlength="8" required>
                        <div id="mensaje"></div>
                        <button type="submit" class="button_register">Registrarse</button>
                    </form> 
                </div>
            </div>
        </section>
    </main>
    <script src="/front/script/register.js"></script>
</body>
</html>