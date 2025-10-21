<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json:');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');

    require_once 'pdo.php';
    require_once 'utils.php';

    
        $pdo = DB::getConnection();

    try
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = sanitizeInput($data['email']);
        $passw = $data['passw'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'error' => 'Invalid email format']);
            exit();
        }

        $query = $pdo->prepare("SELECT * FROM USERS WHERE email = ? LIMIT 1"); // prepara
        $query->execute([$email]); //ejecuta query
        $user = $query->fetch(PDO::FETCH_ASSOC); // Nota: devuelve array, si es que el email existe en la DB
        
                   //El password verify compara el input con el hash del array de $user
        if ($user && password_verify($passw, $user['hash_passw'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            setcookie("loggedin", "true", time() + 432000, "/");
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

    } catch (Exception $e) 
    {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
?>