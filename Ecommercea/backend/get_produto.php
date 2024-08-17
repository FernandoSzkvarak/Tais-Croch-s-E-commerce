<?php
include 'db.php'; 

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $sql = "SELECT * FROM produtos WHERE id_produto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $response = $result->fetch_assoc();
            // Formata o preço com vírgula
            $response['preco'] = number_format($response['preco'], 2, ',', '.');
        } else {
            $response['message'] = "Produto não encontrado";
        }
    } else {
        $response['message'] = "Erro ao buscar produto: " . $stmt->error;
    }
    $stmt->close();
}
echo json_encode($response);
?>
