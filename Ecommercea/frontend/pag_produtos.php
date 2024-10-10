<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto - Tais Crochês</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../frontend/styles-header-footer.css"> <!-- Corrigido o caminho -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        .product-container {
            display: flex;
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .product-images {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .product-images img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .product-thumbnails {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }
        .product-thumbnails img {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
            border-radius: 5px;
            cursor: pointer;
            object-fit: cover;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }
        .product-info {
            flex: 2;
            padding-left: 40px;
        }
        .product-info h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .product-info .price {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 20px;
        }
        .product-info .color-options {
            display: flex;
            margin-bottom: 20px;
        }
        .color-options span {
            display: inline-block;
            width: 25px;
            height: 25px;
            margin-right: 10px;
            border-radius: 50%;
            border: 2px solid #ddd;
            cursor: pointer;
        }
        .color-options .selected {
            border-color: #6a1b9a;
        }
        .product-actions {
            margin-top: 20px;
            display: flex;
            gap: 15px;
        }
        .product-actions button {
            border-radius: 30px;
            padding: 10px 20px;
            font-size: 1.1rem;
        }
        .product-actions .buy-now {
            background-color: #000;
            color: #fff;
        }
        .product-actions .add-to-cart {
            border: 2px solid #6a1b9a;
            background-color: transparent;
            color: #6a1b9a;
        }
        .product-actions .add-to-cart i {
            margin-right: 8px;
        }
        .related-products {
            margin-top: 50px;
        }
        .related-products h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #6a1b9a;
        }
        .related-products .card {
            border: none;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .related-products .card img {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .related-products .card-body {
            padding: 15px;
        }
        .related-products .card-title {
            font-size: 1.2rem;
            color: #333;
        }
        .related-products .card-price {
            font-size: 1.5rem;
            color: #6a1b9a;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?> <!-- Corrigido o caminho -->

    <div class="container product-container">
        <?php
        include '../backend/db.php';

        // Supondo que o ID do produto é passado como parâmetro na URL
        $productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Consulta para obter detalhes do produto
        $sql = "SELECT nome_produto, descricao, preco, imagem FROM produtos WHERE id_produto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            echo "
                <div class='product-images'>
                    <img id='main-image' src='../backend/" . $product['imagem'] . "' alt='Produto'>
                    <div class='product-thumbnails'>
                        <img src='../backend/" . $product['imagem'] . "' alt='Thumbnail 1' onclick=\"document.getElementById('main-image').src='../backend/" . $product['imagem'] . "'\">
                        <img src='../backend/" . $product['imagem'] . "' alt='Thumbnail 2' onclick=\"document.getElementById('main-image').src='../backend/" . $product['imagem'] . "'\">
                        <img src='../backend/" . $product['imagem'] . "' alt='Thumbnail 3' onclick=\"document.getElementById('main-image').src='../backend/" . $product['imagem'] . "'\">
                    </div>
                </div>
                <div class='product-info'>
                    <h1>" . $product['nome_produto'] . "</h1>
                    <div class='color-options'>
                        <span class='selected' style='background-color: #F5CBA7;'></span>
                        <span style='background-color: #FAD7A0;'></span>
                        <span style='background-color: #F4D03F;'></span>
                        <span style='background-color: #BFC9CA;'></span>
                        <span style='background-color: #AAB7B8;'></span>
                    </div>
                    <p class='price'>R$" . number_format($product['preco'], 2, ',', '.') . " <span style='font-size: 0.8rem;'>à vista</span></p>
                    <p>10x de R$" . number_format($product['preco'] / 10, 2, ',', '.') . " sem juros</p>

                    <div class='product-actions'>
                        <button id='buy-now' class='btn buy-now' data-id='" . $productId . "' data-preco='" . $product['preco'] . "'>Comprar</button>
                        <button class='btn add-to-cart'>
                            <i class='fas fa-shopping-cart'></i>Adicionar ao sacola
                        </button>
                    </div>
                </div>";
        } else {
            echo "<p>Produto não encontrado.</p>";
        }

        $conn->close();
        ?>
    </div>

    <div class="container related-products">
        <h3>Produtos relacionados</h3>
        <div class="row">
            <?php
            include '../backend/db.php';
            $sql = "SELECT id_produto, nome_produto, preco, imagem FROM produtos LIMIT 4"; // Ajuste o limite conforme necessário
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "
                        <div class='col-md-3'>
                            <div class='card'>
                                <img src='../backend/" . $row['imagem'] . "' class='card-img-top' alt='Produto'>
                                <div class='card-body'>
                                    <h5 class='card-title'>" . $row['nome_produto'] . "</h5>
                                    <p class='card-price'>R$" . number_format($row['preco'], 2, ',', '.') . "</p>
                                </div>
                            </div>
                        </div>";
                }
            } else {
                echo "<p>Nenhum produto encontrado.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <?php include '../frontend/footer.php'; ?> <!-- Corrigido o caminho -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
      // Modifique a função para garantir que está enviando todos os dados
// Ao clicar no botão "Comprar"
$('#buy-now').on('click', function () {
    const id_produto = $(this).data('id');
    const valor = $(this).data('preco');
    const id_cliente = '123456'; // Substitua pelo ID do cliente que você tem no seu banco de dados

    // Verifica se todos os dados necessários estão definidos
    if (!id_cliente) {
        alert('Erro: Cliente não encontrado.');
        return;
    }

    // Fazer a requisição AJAX para o backend
    $.ajax({
        url: '../backend/proxy.php',  // Endpoint que cria a cobrança
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            idCliente: id_cliente,
            valor: valor,
            dataVencimento: '2024-12-31', // Data fictícia de exemplo
            descricao: 'Compra de produto Tais Crochês',
            tipoPagamento: 'BOLETO',
            externalReference: 'Pedido_' + id_produto
        }),
        success: function (response) {
            const result = JSON.parse(response);
            if (result.success) {
                // Redireciona para o link de pagamento/boleto
                window.location.href = result.payment_url;
            } else {
                alert('Erro ao processar o pagamento: ' + result.message);
            }
        },
        error: function (error) {
            alert('Erro ao processar o pagamento.');
        }
    });
});


    </script>
</body>
</html>
