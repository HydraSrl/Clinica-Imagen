<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');
// Por ahora este archivo es una copia de auth.php  
    $configPath = __DIR__ .'/dbcreds.json';

    $config = json_decode(file_get_contents($configPath), true);

    if (!$config) {
    die("Error de acceso a DB");
    }

    $host = $config['host'];
    $dbname = $config['dbname'];
    $username = $config['username'];
    $password = $config['password'];

    try 
    {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        $data = json_decode(file_get_contents('php://input'), true);
        $nombre = "Juan Granizo";
        $birthdate = "1998-03-03";
        $email = "juan@ejemplo.com";
        $passw = "ejemplo123";

        //echo $data['nombre'];
        $query = $pdo->prepare("SELECT 1 FROM users WHERE email = ?");
        $query->execute([$email]);
        $result = $query->fetch();

        //echo $result;
        
        if ($result) 
        {
            //aca no debo agregar el usuario porque existe
            echo json_encode(['success' => false]);
        } else 
        {
            //no encontro a nadie, aca agregas el usuario
            $insertQuery = $pdo -> prepare ("INSERT into users (nombre, birthdate, email, passw) VALUES ?, ?, ?, ?");
            $insertQuery->execute([$nombre, $birthdate, $email, $passw]);
            echo json_encode(['success' => true]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}