<?php
session_start();
setcookie("loggedin", "", time() - 3600, "/");
setcookie("username", "", time() - 3600, "/");
session_destroy();
header("Location: login.php");
exit;
?>