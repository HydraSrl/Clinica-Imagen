<?php
function sanitizeInput($data) {
    $data = strip_tags($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}
?>