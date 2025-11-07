<?php
require_once '../back/get_tratamientos.php';
$tratamientos = getAllTratamientos();
include 'includes/header.php';
?>
<main id="Tratsweb">
    <img class="background-img" src="img/shedrack-salami-Aeg3jIg0xsQ-unsplash.jpg" alt="Dientes postizos de ejemplo">
    <div class="div-text-img-tratamientos">
        <h1 class="text1-tratamientos-web">Nuestros Tratamientos</h1>
        <h2 class="text2-tratamientos-web">Descubre la variedad de soluciones que ofrecemos para cuidar de tu salud bucal. En Clínica Imagen, nos especializamos en tratamientos de vanguardia para garantizarte una sonrisa sana y radiante.</h2>
        <img src="">
    </div>
    <section class="grid-tratamientos">
        <?php foreach ($tratamientos as $tratamiento) : ?>
            <a href="index.php?page=tratamientos/tratamiento_seleccionado&slug=<?php echo htmlspecialchars($tratamiento['slug']); ?>" class="Tratlinks">
                <div>
                    <h2><?php echo htmlspecialchars($tratamiento['nombre']); ?></h2>
                    <button>Ver más</button>
                </div>
            </a>
        <?php endforeach; ?>
    </section>
</main>
</body>
</html>