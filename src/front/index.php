<?php
session_start();
include '../back/config.php';
?>
<?php
$page = $_GET['page'] ?? 'inicio'; // Si page es null, carga la landing (inicio.php)

if ($page === 'logout') {
    setcookie("loggedin", "", time() - 3600, "/");
    session_destroy();
    header("Location: index.php?page=login");
    exit;
}
?>

<?php
    if (in_array($page, $valid_pages)) {
        include "pages/$page.php"; // carga la página correspondiente
    } else {
        echo "<main><h2>Página no encontrada</h2></main>";
    }
?>