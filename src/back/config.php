<?php
// Este archivo solamente define parametros de ruteo, por ahora.
define("BASE_URL", "/src/front/");

$valid_pages = ['inicio', 'contacto', 'tratamientos', 'login', 'register'];

$page_styles = [
  'inicio' => '../styles/tratamientos.css',
  'contacto' => '../styles/contacto.css',
  'tratamientos' => '../styles/tratamientos.css',
  'login' => '../styles/login&register.css',
  'register' => '../styles/login&register.css'
];