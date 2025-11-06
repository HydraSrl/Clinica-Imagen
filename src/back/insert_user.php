<?php
require_once 'cors.php';
require_once 'pdo.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $rol = $_POST['rol'] ?? '';

    if (empty($nombre) || empty($email) || empty($password) || empty($rol)) {
        $response['message'] = 'Todos los campos son obligatorios.';
    } else {
        $pdo = DB::getConnection();
        
        try {
            $pdo->beginTransaction();

            // Insert into USERS table
            $sql = "INSERT INTO USERS (email, hash_passw) VALUES (:email, :hash_passw)";
            $stmt = $pdo->prepare($sql);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute(['email' => $email, 'hash_passw' => $hashed_password]);
            $userId = $pdo->lastInsertId();

            // Insert into PERSONAL table
            $sql = "INSERT INTO PERSONAL (id_user, nombre, rol) VALUES (:id_user, :nombre, :rol)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id_user' => $userId, 'nombre' => $nombre, 'rol' => $rol]);

            $pdo->commit();

            $response['success'] = true;
            $response['message'] = 'Usuario agregado correctamente.';
        } catch (PDOException $e) {
            $pdo->rollBack();
            $response['message'] = 'Error al agregar el usuario: ' . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Método de solicitud no válido.';
}

echo json_encode($response);
?>