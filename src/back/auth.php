<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json:');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');

    $configPath = __DIR__ .'/dbcreds.json';

    $config = json_decode(file_get_contents($configPath), true);

    if (!$config) {
    die("Error: no se pudo leer la configuración.");
    }

    $host = $config['host'];
    $dbname = $config['dbname'];
    $username = $config['username'];
    $password = $config['password'];

    try 
    {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'];
        $passw = $data['passw'];
        
        $query = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $query->execute([$email]);
        $user = $query->fetch(PDO::FETCH_ASSOC); // Nota: devuelve array, si es que el email existe en la DB
        
                   //El password verify compara el input con el hash del array de $user
        if ($user && password_verify($passw, $user['passw'])) { 
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

    } catch (Exception $e) 
    {
        echo json_encode(['success' => false, 'error' => 'Error de conexión']);
    }
?>