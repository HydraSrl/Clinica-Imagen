<?php
    require_once 'cors.php';
    require_once 'pdo.php';
    require_once 'utils.php';

    
        $pdo = DB::getConnection();

    try
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $identifier = sanitizeInput($data['email']); // Puede ser email o nombre
        $passw = $data['passw'];

        // Buscar por email o por nombre
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            // Es un email válido
            $query = $pdo->prepare("SELECT * FROM USERS WHERE email = ? LIMIT 1");
            $query->execute([$identifier]);
        } else {
            // Es un nombre, buscar en la tabla PACIENTES
            $query = $pdo->prepare("
                SELECT u.* FROM USERS u
                INNER JOIN PACIENTES p ON u.id = p.id_user
                WHERE p.nombre = ? LIMIT 1
            ");
            $query->execute([$identifier]);
        }

        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($passw, $user['hash_passw'])) {
            // Verificar edad del usuario
            $userIdCheck = $user['id'];
            $ageQuery = $pdo->prepare("
                SELECT fecha_nacimiento FROM PACIENTES WHERE id_user = ? LIMIT 1
            ");
            $ageQuery->execute([$userIdCheck]);
            $patientData = $ageQuery->fetch(PDO::FETCH_ASSOC);

            if ($patientData) {
                $birthDateTime = new DateTime($patientData['fecha_nacimiento']);
                $today = new DateTime();
                $age = $today->diff($birthDateTime)->y;

                if ($age < 18) {
                    echo json_encode(['success' => false, 'error' => 'Debes ser mayor de 18 años para acceder']);
                    exit();
                }
            }

            session_start();
            $_SESSION['user_id'] = $user['id'];
            setcookie("loggedin", "true", time() + 432000, "/");
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Usuario o contraseña incorrectos']);
        }

    } catch (Exception $e)
    {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
?>