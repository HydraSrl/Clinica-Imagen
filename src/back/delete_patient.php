<?php
require_once 'pdo.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cedula = $_POST['cedula'] ?? '';

    if (empty($cedula)) {
        $response['message'] = 'La cédula del paciente es requerida.';
    } else {
        $pdo = DB::getConnection();
        
        try {
            // First, get the id_user from the PACIENTES table
            $sql_get_user = "SELECT id_user FROM PACIENTES WHERE cedula = :cedula";
            $stmt_get_user = $pdo->prepare($sql_get_user);
            $stmt_get_user->execute(['cedula' => $cedula]);
            $patient = $stmt_get_user->fetch(PDO::FETCH_ASSOC);

            if ($patient) {
                $id_user = $patient['id_user'];

                // The ON DELETE CASCADE constraint on fk_id_user will handle deletion from PACIENTES table
                $sql_delete_user = "DELETE FROM USERS WHERE id = :id_user";
                $stmt_delete_user = $pdo->prepare($sql_delete_user);
                $stmt_delete_user->execute(['id_user' => $id_user]);

                $response['success'] = true;
                $response['message'] = 'Paciente eliminado correctamente.';
            } else {
                $response['message'] = 'No se encontró ningún paciente con la cédula proporcionada.';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Error al eliminar el paciente: ' . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Método de solicitud no válido.';
}

echo json_encode($response);
?>