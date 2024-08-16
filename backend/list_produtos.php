<?php
include 'db.php'; // Inclui o script de conexão ao banco de dados.

$sql = "SELECT id_produto, nome_produto, preco, estoque, imagem, descricao FROM produtos ORDER BY nome_produto ASC";
$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();

echo json_encode($products);
?>
