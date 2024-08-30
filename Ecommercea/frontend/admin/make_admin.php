<?php
include 'db.php';
header('Content-Type: application/json');

$response = array("success" => false);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['id_usuario'])) {
        $id_usuario = $data['id_usuario'];

        $query = "UPDATE usuarios SET is_admin = 1 WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);

        if ($stmt->execute()) {
            $response["success"] = true;
        }
    }
}

$conn->close();
echo json_encode($response);
?>
