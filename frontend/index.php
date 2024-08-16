<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Simples</title>
    <link rel="stylesheet" href="styles-index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Estilo para o carrossel */
        .carousel-item img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
            object-position: center;
        }

        /* Estilo para o toast */
        .toast-container {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1055;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <!-- Carrossel de Imagens Fixas -->
    <div id="productCarousel" class="carousel slide mt-3" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/Img carrossel.png" class="d-block w-100" alt="Primeira Imagem">
            </div>
            <div class="carousel-item">
                <img src="img/Img carrossel02.png" class="d-block w-100" alt="Segunda Imagem">
            </div>
            <div class="carousel-item">
                <img src="img/Img carrossel03.png" class="d-block w-100" alt="Terceira Imagem">
            </div>
        </div>
        <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="container mt-5">
        <div class="row">
            <?php
            include '../backend/db.php';
            $sql = "SELECT id_produto, nome_produto, preco, imagem FROM produtos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4'>";
                    echo "<div class='card mb-4'>";
                    echo "<img src='../backend/" . $row['imagem'] . "' alt='" . $row['nome_produto'] . "' class='card-img-top product-zoom'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $row['nome_produto'] . "</h5>";
                    echo "<p class='card-text'>Preço: R$" . number_format($row['preco'], 2, ',', '.') . "</p>";
                    echo "<a href='pag_produtos.php?id=" . $row['id_produto'] . "' class='btn btn-success'>Adicionar ao Carrinho</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12'>";
                echo "<p class='text-center'>Nenhum produto encontrado.</p>";
                echo "</div>";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toast-container">
        <div id="email-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Notificação</strong>
                <small class="text-muted">Agora</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Email enviado com sucesso!
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <?php include 'footer.php'; ?>

    
</body>
</html>
