<?php
// Este archivo solamente define parametros de ruteo, y un array de enlaces dinamico.
define("BASE_URL", "/src/front/");

session_start();
$loggedin = $_SESSION['loggedin'] ?? false;
$username = $_SESSION['username'] ?? false;

$valid_pages = ['inicio', 'contacto', 'tratamientos', 'login', 'register', 'backoffice', 'perfil'];

$page_styles = [
  'inicio' => '../styles/tratamientos.css',
  'contacto' => '../styles/contacto.css',
  'tratamientos' => '../styles/tratamientos.css',
  'login' => '../styles/login&register.css',
  'register' => '../styles/login&register.css',
  'perfil' => '../styles/perfil.css'
];

$navpages = [
    "contacto" => "Contacto",
    "tratamientos" => "Tratamientos",
    "login" => $loggedin ? "Hola $username" : "Login"
];