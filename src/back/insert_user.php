<?php
require_once 'cors.php';
require_once 'pdo.php';
require_once 'utils.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['nombre']) ? sanitizeInput($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
    $password = $_POST['password'] ?? '';
    $rol = isset($_POST['rol']) ? sanitizeInput($_POST['rol']) : '';

    if (empty($nombre) || empty($email) || empty($password) || empty($rol)) {
        $response['message'] = 'Todos los campos son obligatorios.';
    } else {
        // Validar formato de correo electrónico
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = 'Formato de email inválido.';
            echo json_encode($response);
            exit();
        }

        $pdo = DB::getConnection();

        try {
            // Verificar si el correo electrónico ya existe en USERS
            $checkEmailQuery = $pdo->prepare("SELECT id FROM USERS WHERE email = ?");
            $checkEmailQuery->execute([$email]);
            if ($checkEmailQuery->fetch()) {
                $response['message'] = 'El correo electrónico ya está registrado.';
                echo json_encode($response);
                exit();
            }

            $pdo->beginTransaction();

            // Insertar en la tabla USERS
            $sql = "INSERT INTO USERS (email, hash_passw) VALUES (:email, :hash_passw)";
            $stmt = $pdo->prepare($sql);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute(['email' => $email, 'hash_passw' => $hashed_password]);
            $userId = $pdo->lastInsertId();

            // Insertar en la tabla PERSONAL
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