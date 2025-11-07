<?php include 'includes/header.php' ?>


    <main>
        <section class="login">
            <div class="login_back">
                <form id="loginForm" class="login_box">
                    <button type="button" class="homeButton" onclick="location.href=('index.php?page=inicio')"><img src="/front/img/IconoCasa.webp"></button>
                    <div class="login_deco_box">
                        <p class="login_actual_loc">Login |</p>
                        <p class="hover-efect" onclick="location='index.php?page=register'"> Registrate</p>
                    </div>
                    <div class="login_box2">
                        <input type="text" id="email" placeholder="Nombre o Email" required>
                        <input id="passw" placeholder="Contraseña" type="password" required>
                        <div class="mensaje" id="mensaje"></div>
                        <button type="submit" class="button_login">Iniciar sesión</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <script src="/front/script/login.js"></script>
</body>
</html>