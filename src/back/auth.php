<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type');

    $host = 'db';
    $dbname = 'clinicas'; 
    $username = 'root';     
    $password = 'root123';         

    try 
    {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        $data = json_decode(file_get_contents('php://input'), true);
        $usuario = $data['usuario'];
        $pass = $data['pass'];
        
        $query = $pdo->prepare("SELECT * FROM users WHERE usuario = ? AND pass = ?");
        $query->execute([$usuario, $pass]);
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
        echo json_encode(['success' => false, 'error' => 'Error de conexión']);
    }
?>