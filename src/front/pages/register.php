<?php include 'includes/header.php' ?>

<body>
    <main>
        <section class="login">
            <div class="login_back">
                <div class="login_box">
                    <button class="homeButton" onclick="location.href=('index.php?page=inicio')"><img src="/front/img/IconoCasa.webp"></button>
                    <div class="login_deco_box">
                        <p class="hover-efect" onclick="location='index.php?page=login'">Login   </p>
                        <p class="login_actual_loc">| Register</p>
                    </div>
                    <div class="login_box2">
                        <input require placeholder="Nombre">
                        <input placeholder="Email">
                        <input placeholder="Fecha de nacimiento" type="date">
                        <input placeholder="Contraseña" type="password">
                        <button class="button_register">Registrarse</button>
                    </div> 
                </div>
            </div>
        </section>
    </main>
</body>
</html>