<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>
    <!-- configuracion de rutas y dependencias -->
    <?php
        $page = "sobrenosotros";
        $aux = "pages";
        include 'includes/header.php' ; 
    ?>
    <link rel="stylesheet" href="../styles/sobrenosotros.css">

    <main>
        <!-- portada -->
        <section class="portada_ab">
            <p>Encuéntranos</p>
        </section>

        <section class="sedes-container">
            <div class="sedes-grid">
                <div class="sede-card">
                    <div class="sede-icon"></div>
                    <h3>Sede Caudillos</h3>
                    <p><i class="icon-location"></i> Bv. Artigas esq. Rivera 1443, oficina 121, Montevideo.</p>
                    <p><i class="icon-clock"></i> <strong>Lunes a viernes:</strong> 8:00 a 20:00 hs.</p>
                    <p><i class="icon-clock"></i> <strong>Sábados:</strong> 9:00 a 14:00 hs.</p>
                    <p><i class="icon-phone"></i> 2602 6631 - 092 745 398</p>
                    <a href="#" class="btn-ubicacion">VER UBICACIÓN</a>
                </div>
                <div class="sede-card">
                    <div class="sede-icon"></div>
                    <h3>Sede Montevideo Shopping</h3>
                    <p><i class="icon-location"></i> Luis A. de Herrera 1248, oficina 321, Montevideo.</p>
                    <p><i class="icon-clock"></i> <strong>Lunes a viernes:</strong> 8:00 a 20:00 hs.</p>
                    <p><i class="icon-clock"></i> <strong>Sábados:</strong> 8:00 a 13:00 hs.</p>
                    <p><i class="icon-phone"></i> 2602 6631 - 092 745 398</p>
                    <a href="#" class="btn-ubicacion">VER UBICACIÓN</a>
                </div>
                <div class="sede-card">
                    <div class="sede-icon"></div>
                    <h3>Sede Nuevo Centro</h3>
                    <p><i class="icon-location"></i> Bv Artigas 3126, apto. 1103, Montevideo.</p>
                    <p><i class="icon-clock"></i> <strong>Lunes a viernes:</strong> 8:00 a 20:00 hs.</p>
                    <p><i class="icon-clock"></i> <strong>Sábados:</strong> 9:00 a 14:00 hs.</p>
                    <p><i class="icon-phone"></i> 2602 6631 - 092 745 398</p>
                    <a href="#" class="btn-ubicacion">VER UBICACIÓN</a>
                </div>
                <div class="sede-card">
                    <div class="sede-icon"></div>
                    <h3>Sede Carrasco</h3>
                    <p><i class="icon-location"></i> Portal de las Américas, loc. 109. Av. De las Américas.</p>
                    <p><i class="icon-clock"></i> <strong>Lunes a viernes:</strong> 8:00 a 20:00 hs.</p>
                    <p><i class="icon-clock"></i> <strong>Sábados:</strong> 9:00 a 14:00 hs.</p>
                    <p><i class="icon-phone"></i> 2602 6631 - 092 745 398</p>
                    <a href="#" class="btn-ubicacion">VER UBICACIÓN</a>
                </div>
                <div class="sede-card">
                    <div class="sede-icon"></div>
                    <h3>Sede Lagomar</h3>
                    <p><i class="icon-location"></i> Av. Giannattasio, 236, y Av. Secco García, Lagomar Norte</p>
                    <p><i class="icon-clock"></i> <strong>Lunes a viernes:</strong> 8:00 a 20:00 hs.</p>
                    <p><i class="icon-clock"></i> <strong>Sábados:</strong> 9:00 a 14:00 hs.</p>
                    <p><i class="icon-phone"></i> 2602 6631 - 092 745 398</p>
                    <a href="#" class="btn-ubicacion">VER UBICACIÓN</a>
                </div>
                <div class="sede-card">
                    <div class="sede-icon"></div>
                    <h3>Sede Atlántida</h3>
                    <p>(Solo periapicales)</p>
                    <p><i class="icon-location"></i> Calle 22 esq. calle 7</p>
                    <p><i class="icon-clock"></i> <strong>Lunes:</strong> 8:00 a 14:00hs</p>
                    <p><i class="icon-clock"></i> <strong>Martes, jueves y viernes:</strong> 8:00 a 16:00hs.</p>
                    <p><i class="icon-phone"></i> 2602 6631 - 092 745 398</p>
                    <a href="#" class="btn-ubicacion">VER UBICACIÓN</a>
                </div>
                <div class="sede-card">
                    <div class="sede-icon"></div>
                    <h3>Sede Colonia</h3>
                    <p><i class="icon-location"></i> 18 de julio esq. Lavalleja. Paseo Imagen, entrada por 18 de Julio. Colonia del Sacramento.</p>
                    <p><i class="icon-clock"></i> <strong>Lunes a viernes:</strong> 08:00 a 20:00hs</p>
                    <p><i class="icon-clock"></i> <strong>Sábados:</strong> 09:00 a 13:00hs.</p>
                    <p><i class="icon-phone"></i> 092 745 398</p>
                    <a href="#" class="btn-ubicacion">VER UBICACIÓN</a>
                </div>
                <div class="sede-card">
                    <div class="sede-icon"></div>
                    <h3>Sede Libertad</h3>
                    <p><i class="icon-location"></i> Gral. José Artigas 815, Libertad, San José.</p>
                    <p><i class="icon-clock"></i> <strong>Lunes:</strong> 14:00 a 18:30hs.</p>
                    <p><i class="icon-clock"></i> <strong>Martes y viernes:</strong> 9:00 a 12:00hs.</p>
                    <p><i class="icon-clock"></i> <strong>Miércoles:</strong> 9:00 a 12:00, 14:00 a 18:30hs.</p>
                    <p><i class="icon-clock"></i> <strong>Jueves:</strong> 17:00 a 20:00hs</p>
                    <p><i class="icon-phone"></i> 092 390 847</p>
                    <a href="#" class="btn-ubicacion">VER UBICACIÓN</a>
                </div>
                <div class="sede-card">
                    <div class="sede-icon"></div>
                    <h3>Sede Punta del Este</h3>
                    <p><i class="icon-location"></i> Avda. Roosvelt 1246 esq. Camacho, apt 1605. Edificio More Atlántico, Maldonado.</p>
                    <p><i class="icon-clock"></i> <strong>Lunes a jueves:</strong> 10:00 a 18:00hs.</p>
                    <p><i class="icon-clock"></i> <strong>Viernes:</strong> 09:00 a 20:00hs.</p>
                    <p><i class="icon-clock"></i> <strong>Sábados:</strong> 09:00 a 13:00hs.</p>
                    <p><i class="icon-phone"></i> 092 745 398</p>
                    <a href="#" class="btn-ubicacion">VER UBICACIÓN</a>
                </div>
                <div class="sede-card">
                    <div class="sede-icon"></div>
                    <h3>Sede Las Piedras</h3>
                    <p><i class="icon-location"></i> Gral. Leandro Gómez 618, Las Piedras, Canelones.</p>
                    <p><i class="icon-clock"></i> <strong>Lunes a viernes:</strong> 8:30 a 12:30hs, 15:00 a 19:00hs.</p>
                    <p><i class="icon-clock"></i> <strong>Sábados:</strong> 8:00 a 14:00hs.</p>
                    <p><i class="icon-phone"></i> 098 786 833</p>
                    <a href="#" class="btn-ubicacion">VER UBICACIÓN</a>
                </div>
            </div>
        </section>
        
        <!-- info contenidos -->
        <section class="textos_ab">
            <!-- mision -->
            <div>
                <div>
                    <p>Nuestra misión</p>
                </div>
                <div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, veritatis? Explicabo quisquam eveniet optio voluptatibus dolores deserunt praesentium ad quos, laudantium temporibus neque exercitationem laborum sed facilis cumque reprehenderit doloremque earum architecto omnis consectetur expedita soluta facere ipsam. <br><br>Excepturi ea numquam laboriosam nulla facilis sed doloribus illo ipsa, saepe accusantium!Excepturi ea numquam laboriosam nulla facilis sed doloribus illo ipsa, saepe accusantium!Excepturi ea numquam laboriosam nulla facilis sed doloribus illo ipsa, saepe accusantium!</p>
                </div>
            </div>

            <div>
                <div>
                    <p>Nuestra Vision</p>
                </div>
                <div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, veritatis? Explicabo quisquam eveniet optio voluptatibus dolores deserunt praesentium ad quos, laudantium temporibus neque exercitationem laborum sed facilis cumque reprehenderit doloremque earum architecto omnis consectetur expedita soluta facere ipsam. <br><br>Excepturi ea numquam laboriosam nulla facilis sed doloribus illo ipsa, saepe accusantium!Excepturi ea numquam laboriosam nulla facilis sed doloribus illo ipsa, saepe accusantium!Excepturi ea numquam laboriosam nulla facilis sed doloribus illo ipsa, saepe accusantium!</p>
                </div>
                <div class="fondo"></div>
            </div>
            <div>
                <div>
                    <p>Nuestros Valores</p>
                </div>
                <div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, veritatis? Explicabo quisquam eveniet optio voluptatibus dolores deserunt praesentium ad quos, laudantium temporibus neque exercitationem laborum sed facilis cumque reprehenderit doloremque earum architecto omnis consectetur expedita soluta facere ipsam. <br><br>Excepturi ea numquam laboriosam nulla facilis sed doloribus illo ipsa, saepe accusantium!Excepturi ea numquam laboriosam nulla facilis sed doloribus illo ipsa, saepe accusantium!Excepturi ea numquam laboriosam nulla facilis sed doloribus illo ipsa, saepe accusantium!</p>
                </div>
            </div>
        </section>

        <!-- galeria personal -->
        <section class="galeria_ab">
            <div>
                <img src="https://img.imageboss.me/scribe/cover:inside/476x728/quality:80/au/contributors/galeano-eduardo.jpg?bossToken=0e71077af9bea4988de6a81c205100d927d99dff89f48e709be23fffe48b9beb" alt="CEO de la empresa Clinica Imagen">
                <p>Dr. Javier de Lima</p>
            </div>

            <div><img src="https://www.infobae.com/resizer/v2/https%3A%2F%2Fs3.amazonaws.com%2Farc-wordpress-client-uploads%2Finfobae-wp%2Fwp-content%2Fuploads%2F2018%2F09%2F13145720%2FEmma-Watson-41.jpg?auth=dda7929d80ba2cdd8e09f22d3f7440bd34fe1696e5eb57113817eb0f8514f3df&smart=true&width=1200&height=1200&quality=85" alt="Odontologa imagenologica"><p>Dra. Laura Duque</p></div>
            <div><img src="https://static.wikia.nocookie.net/doblaje/images/e/ea/Megan-fox-2019.jpg/revision/latest?cb=20190219011714&path-prefix=es" alt="Secretaria Jefe"><p>Dra. Sabrina Nieves</p></div>
            <div><img src="https://placehold.co/330" alt="Odontologa de ortodoncia"><p>Rosina Canavera</p></div>
        </section>
    </main>
    <footer></footer>
</body>
</html>