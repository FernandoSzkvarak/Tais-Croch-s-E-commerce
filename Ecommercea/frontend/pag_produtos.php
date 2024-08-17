<?php
include '../backend/db.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $sql = "SELECT * FROM produtos WHERE id_produto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Produto não encontrado.";
        exit;
    }

    $stmt->close();
} else {
    echo "ID do produto não especificado.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['nome_produto']); ?></title>
    <link rel="stylesheet" href="styles-index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="../backend/<?php echo htmlspecialchars($product['imagem']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['nome_produto']); ?>">
            </div>
            <div class="col-md-6">
                <h2><?php echo htmlspecialchars($product['nome_produto']); ?></h2>
                <p>Preço: R$<?php echo number_format($product['preco'], 2, ',', '.'); ?></p>
                <p>Estoque: <?php echo htmlspecialchars($product['estoque']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($product['descricao'])); ?></p>

                <!-- Seleção de cores, se aplicável -->
                <?php if (!empty($product['cores_disponiveis'])): ?>
                    <label for="product-color">Escolha a cor:</label>
                    <select id="product-color" class="form-control mb-3">
                        <?php
                        $cores = explode(',', $product['cores_disponiveis']);
                        foreach ($cores as $cor) {
                            echo "<option value='$cor'>$cor</option>";
                        }
                        ?>
                    </select>
                <?php endif; ?>

                <button class="btn btn-success">Adicionar ao Carrinho</button>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
