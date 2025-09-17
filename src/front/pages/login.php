<?php include 'includes/header.php' ?>


    <main>
        <section class="login">
            <div class="login_back">
                <form id="loginForm" class="login_box">
                    <button class="homeButton" onclick="location.href=('index.php?page=inicio')"><img src="/front/img/IconoCasa.webp"></button>
                    <div class="login_deco_box">
                        <p class="login_actual_loc">Login |</p>
                        <p class="hover-efect" onclick="location='index.php?page=register'"> Register</p>
                    </div>
                    <div class="login_box2">
                        <input type="email" id="usuario" placeholder="Nombre o Email">
                        <input id="pass" placeholder="Contraseña" type="password">
                        <button type="submit" class="button_login">Iniciar sesión</button>
                    </div> 
                    <div id="mensaje"></div>
                </form>
            </div>
        </section>
    </main>
    <script src="/front/script/login.js"></script>
</body>
</html>