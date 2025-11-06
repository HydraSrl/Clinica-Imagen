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

        //echo $data['nombre'];
        $query = $pdo->prepare("SELECT * FROM USERS WHERE email = ?");
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
            $pdo->beginTransaction();
            
            $insertUserQuery = $pdo->prepare("INSERT INTO USERS (email, hash_passw) VALUES (?, ?)");
            $insertUserQuery->execute([$email, $hashed_password]);
            
            $userId = $pdo->lastInsertId();
            
            $insertPatientQuery = $pdo->prepare("INSERT INTO PACIENTES (id_user, nombre, fecha_nacimiento, cedula, ciudad, telefono) VALUES (?, ?, ?, ?, ?, ?)");
            $insertPatientQuery->execute([$userId, $nombre, $birthdate, $cedula, $ciudad, $telefono]);
            
            $pdo->commit();
            
            echo json_encode(['success' => true]);
        }
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
