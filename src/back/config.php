<?php
// Este archivo solamente define parametros de ruteo, y un array de enlaces dinamico.
define("BASE_URL", "/src/front/");

// Si no existe, false. Solamente true, si existe y es true.
$loggedin = ($_COOKIE['loggedin'] ?? 'false') === 'true';

$valid_pages = ['inicio', 'contacto', 'tratamientos', 'login', 'register', 'backoffice', 'perfil', 'logout', 'tratamientos/tratamiento_seleccionado'];

$page_styles = [
  'inicio' => '../styles/tratamientos.css',
  'contacto' => '../styles/contacto.css',
  'tratamientos' => '../styles/tratamientos.css',
  'login' => '../styles/login&register.css',
  'register' => '../styles/login&register.css',
  'perfil' => '../styles/perfil.css'
];

if($loggedin) {
  $navpages = [
    "contacto" => "Contacto",
    "tratamientos" => "Tratamientos",
    "perfil" => "Mi perfil"
  ];
} else {
  $navpages = [
    "contacto" => "Contacto",
    "tratamientos" => "Tratamientos",
    "login" => "Mi perfil"
  ];
}