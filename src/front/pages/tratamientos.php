<?php
require_once '../back/get_tratamientos.php';
$tratamientos = getAllTratamientos();
include 'includes/header.php';
?>
<p></p>
<main id="Tratsweb">
    <div class="div-text-img-tratamientos">
        <h1 class="text1-tratamientos-web">Lorem</h1>
        <h2 class="text2-tratamientos-web">Lorem ipsum dolor sit amet, consectetur adipisicing
            elit. Tenetur quod ducimus fugit quam autem asperiores aut sint delectus?
            Accusamus, quos ducimus. Quisquam, adipisci praesentium? Sint obcaecati itaque
            dicta dolor molestiae.</h2>
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