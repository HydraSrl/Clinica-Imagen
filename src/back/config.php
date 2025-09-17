<?php
// Este archivo solamente define parametros de ruteo, y un array de enlaces dinamico.
define("BASE_URL", "/src/front/");
//Linea para testing
$loggedin = false;

$valid_pages = ['inicio', 'contacto', 'tratamientos', 'login', 'register', 'backoffice'];

$page_styles = [
  'inicio' => '../styles/tratamientos.css',
  'contacto' => '../styles/contacto.css',
  'tratamientos' => '../styles/tratamientos.css',
  'login' => '../styles/login&register.css',
  'register' => '../styles/login&register.css'
];

$navpages = [
    "contacto" => "Contacto",
    "tratamientos" => "Tratamientos",
    "login" => $loggedin ? "Hola Usuario" : "Login"
];