<?php include '../back/config.php'; ?>


<?php $page = $_GET['page'] ?? 'inicio'; // Si page es null, carga la landing (inicio.php)?>

<?php
    if (in_array($page, $valid_pages)) {
        include "pages/$page.php"; // carga la página correspondiente
    } else {
        echo "<main><h2>Página no encontrada</h2></main>";
    }
?>