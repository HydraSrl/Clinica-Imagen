<?php include 'includes/header.php' ?>

<body>
    <main>
        <section class="login">
            <div class="login_back">
                <div class="login_box">
                    <button class="homeButton" onclick="location.href=('index.php?page=inicio')"><img src="/front/img/IconoCasa.webp"></button>
                    <div class="login_deco_box">
                        <p class="hover-efect" onclick="location='index.php?page=login'">Login   </p>
                        <p class="login_actual_loc">| Registrate</p>
                    </div>
                    <form id="registerForm" class="login_box2">
                        <input id="nombre" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras y espacios"  placeholder="Nombre">
                        <input id="birthdate" placeholder="Fecha de nacimiento" type="date">
                        <input id="email" placeholder="Email">
                        <input id="passw" placeholder="Contraseña" type="password">
                        <button type="submit" class="button_register">Registrarse</button>
                    </form> 
                    <div id="mensaje"></div>
                </div>
            </div>
        </section>
    </main>
    <script src="/front/script/register.js"></script>
</body>
</html>