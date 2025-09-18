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
        
        $query = $pdo->prepare("SELECT * FROM users WHERE email = ? AND passw = ?");
        $query->execute([$email, $passw]);
        $result = $query->fetch();
        
        if ($result) 
        {
            echo json_encode(['success' => true]);
        } else 
        {
            echo json_encode(['success' => false]);
        }
        
    } catch (Exception $e) 
    {
        //echo json_encode(['success' => false, 'error' => 'Error de conexión']);
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
?>