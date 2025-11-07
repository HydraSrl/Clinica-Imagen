<?php
require_once 'cors.php';
require_once 'pdo.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCita = $_POST['id_cita'] ?? '';

    if (empty($idCita)) {
        $response['message'] = 'ID de cita no proporcionado.';
    } else {
        $pdo = DB::getConnection();

        try {
            // Verificar que la cita existe
            $checkQuery = $pdo->prepare("SELECT id FROM CITAS WHERE id = ?");
            $checkQuery->execute([$idCita]);

            if (!$checkQuery->fetch()) {
                $response['message'] = 'La cita no existe.';
            } else {
                // Eliminar la cita
                $deleteQuery = $pdo->prepare("DELETE FROM CITAS WHERE id = ?");
                $deleteQuery->execute([$idCita]);

                $response['success'] = true;
                $response['message'] = 'Cita cancelada correctamente.';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Error al cancelar la cita: ' . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Método de solicitud no válido.';
}

echo json_encode($response);
?>
