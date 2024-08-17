<?php
include 'db.php'; 

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product-id'];

    $sql = "DELETE FROM produtos WHERE id_produto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        $response['message'] = "Produto removido com sucesso!";
    } else {
        $response['message'] = "Erro ao remover produto: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    echo json_encode($response);
}
?>
