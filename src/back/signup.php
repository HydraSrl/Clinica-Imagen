<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');
    include('pdo.php');
    include('utils.php');

    try
    {
        $pdo = DB::getConnection();
        
        $data = json_decode(file_get_contents('php://input'), true);
        $nombre = sanitizeInput($data['nombre']);
        $birthdate = sanitizeInput($data['birthdate']);
        $email = sanitizeInput($data['email']);
        $passw = $data['passw'];
        $hashed_password = password_hash($passw, PASSWORD_DEFAULT);

        //echo $data['nombre'];
        $query = $pdo->prepare("SELECT * FROM users WHERE email = ?");
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
            $insertQuery = $pdo -> prepare ("INSERT into users (fullname, birthdate, email, passw) VALUES (?, ?, ?, ?)");
            $insertQuery->execute([$nombre, $birthdate, $email, $hashed_password]);
            echo json_encode(['success' => true]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
