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
        include '../includes/header.php' ; 
    ?>
    <link rel="stylesheet" href="../styles/sobrenosotros.css">

    <main>
        <!-- portada -->
        <section class="portada_ab">
            <p>Sobre Nosotros</p>
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
                <img src="https://img.imageboss.me/scribe/cover:inside/476x728/quality:80/au/contributors/galeano-eduardo.jpg?bossToken=0e71077af9bea4988de6a81c205100d927d99dff89f48e709be23fffe48b9beb" alt="Javier de Lima">
                <p>Dr. Javier de Lima</p>
            </div>

            <div><img src="https://www.infobae.com/resizer/v2/https%3A%2F%2Fs3.amazonaws.com%2Farc-wordpress-client-uploads%2Finfobae-wp%2Fwp-content%2Fuploads%2F2018%2F09%2F13145720%2FEmma-Watson-41.jpg?auth=dda7929d80ba2cdd8e09f22d3f7440bd34fe1696e5eb57113817eb0f8514f3df&smart=true&width=1200&height=1200&quality=85" alt="Laura Duque"><p>Dra. Laura Duque</p></div>
            <div><img src="https://static.wikia.nocookie.net/doblaje/images/e/ea/Megan-fox-2019.jpg/revision/latest?cb=20190219011714&path-prefix=es" alt="Sabrina Nieves"><p>Dra. Sabrina Nieves</p></div>
            <div><img src="https://placehold.co/330" alt="Rosina Canavera"><p>Rosina Canavera</p></div>
        </section>
    </main>
    <footer></footer>
</body>
</html>