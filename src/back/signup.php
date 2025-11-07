<?php
    require_once 'cors.php';
    include('pdo.php');
    include('utils.php');

    try
    {
        $pdo = DB::getConnection();
        
        $data = json_decode(file_get_contents('php://input'), true);
        $nombre = sanitizeInput($data['nombre']);
        $birthdate = sanitizeInput($data['birthdate']);
        $email = sanitizeInput($data['email']);
        $cedula = sanitizeInput($data['cedula']);
        $ciudad = sanitizeInput($data['ciudad']);
        $telefono = sanitizeInput($data['telefono']);
        $passw = $data['passw'];
        $hashed_password = password_hash($passw, PASSWORD_DEFAULT);

        // Validar formato de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'error' => 'Formato de email inválido']);
            exit();
        }

        // Validar edad mínima
        $birthDateTime = new DateTime($birthdate);
        $today = new DateTime();
        $age = $today->diff($birthDateTime)->y;

        if ($age < 18) {
            echo json_encode(['success' => false, 'error' => 'Debes ser mayor de 18 años para registrarte']);
            exit();
        }

        // Verificar si el email ya existe
        $query = $pdo->prepare("SELECT * FROM USERS WHERE email = ?");
        $query->execute([$email]);
        $result = $query->fetch();

        if ($result)
        {
            echo json_encode(['success' => false, 'error' => 'El correo electrónico ya está registrado']);
            exit();
        }

        // Verificar si la cédula ya existe
        $queryCedula = $pdo->prepare("SELECT * FROM PACIENTES WHERE cedula = ?");
        $queryCedula->execute([$cedula]);
        $resultCedula = $queryCedula->fetch();

        if ($resultCedula)
        {
            echo json_encode(['success' => false, 'error' => 'La cédula ya está registrada']);
            exit();
        }

        // Si no existe, crear el usuario
        $pdo->beginTransaction();

        $insertUserQuery = $pdo->prepare("INSERT INTO USERS (email, hash_passw) VALUES (?, ?)");
        $insertUserQuery->execute([$email, $hashed_password]);

        $userId = $pdo->lastInsertId();

        $insertPatientQuery = $pdo->prepare("INSERT INTO PACIENTES (id_user, nombre, fecha_nacimiento, cedula, ciudad, telefono) VALUES (?, ?, ?, ?, ?, ?)");
        $insertPatientQuery->execute([$userId, $nombre, $birthdate, $cedula, $ciudad, $telefono]);

        $pdo->commit();

        // Autologin después del registro
        session_start();
        $_SESSION['user_id'] = $userId;
        setcookie("loggedin", "true", time() + 432000, "/");

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
