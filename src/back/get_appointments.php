<?php
require_once 'pdo.php';

$appointments = [];

if (isset($_SESSION['user_id'])) {
    try {
        $pdo = DB::getConnection();
        $userId = $_SESSION['user_id'];

        $query = "
            SELECT
                c.id,
                c.fecha_cita,
                s.nombre AS sucursal_nombre,
                c.estado,
                c.fecha_creacion,
                t.nombre AS tratamiento_nombre,
                pe.nombre AS personal_nombre
            FROM CITAS c
            JOIN SUCURSALES s ON c.id_sucursal = s.id
            JOIN PACIENTES p ON c.id_paciente = p.id
            LEFT JOIN TRATAMIENTOS t ON c.id_tratamiento = t.id
            LEFT JOIN PERSONAL pe ON c.id_personal = pe.id
            WHERE p.id_user = :userId
            ORDER BY c.fecha_cita ASC
        ";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        // For now, we'll just let $appointments remain an empty array
    }
}
?>