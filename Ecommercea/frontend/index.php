<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Simples</title>
    <link rel="stylesheet" href="styles-index.css">
    <link rel="stylesheet" href="styles-header-footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <!-- Banner Rotativo -->
    <div id="promoBanner" class="carousel slide mt-3" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/banner1.png" class="d-block w-100" alt="Promoção 1">
            </div>
            <div class="carousel-item">
                <img src="img/banner2.png" class="d-block w-100" alt="Promoção 2">
            </div>
            <div class="carousel-item">
                <img src="img/banner3.png" class="d-block w-100" alt="Promoção 3">
            </div>
        </div>
        <a class="carousel-control-prev" href="#promoBanner" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#promoBanner" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </a>
    </div>

    <!-- Grid de Produtos em Destaque -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Produtos em Destaque</h2>
        <div class="row">
            <?php
            include '../backend/db.php';
            $sql = "SELECT id_produto, nome_produto, preco, imagem FROM produtos ORDER BY RAND() LIMIT 6";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4'>";
                    echo "<div class='card mb-4'>";
                    echo "<img src='../backend/" . $row['imagem'] . "' alt='" . $row['nome_produto'] . "' class='card-img-top'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $row['nome_produto'] . "</h5>";
                    echo "<p class='card-text'>Preço: R$" . number_format($row['preco'], 2, ',', '.') . "</p>";
                    echo "<a href='pag_produtos.php?id=" . $row['id_produto'] . "' class='btn btn-primary'>Ver Produto</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12'>";
                echo "<p class='text-center'>Nenhum produto em destaque no momento.</p>";
                echo "</div>";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <!-- Popup de Suporte -->
    <div class="fixed-bottom p-3">
        <button type="button" class="btn btn-success support-button" data-bs-toggle="modal" data-bs-target="#supportModal">
            <i class="fa fa-comments"></i> Suporte
        </button>
    </div>

    <!-- Suporte Modal -->
    <div class="modal fade" id="supportModal" tabindex="-1" aria-labelledby="supportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supportModalLabel">Suporte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="support-form">
                        <div class="form-group mb-3">
                            <label for="support-name">Nome</label>
                            <input type="text" class="form-control" id="support-name" name="support-name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="support-email">Email</label>
                            <input type="email" class="form-control" id="support-email" name="support-email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="support-problem">Tipo de Problema</label>
                            <select class="form-control" id="support-problem" name="support-problem" required>
                                <option value="pagamento">Problema com Pagamento</option>
                                <option value="envio">Problema com Envio</option>
                                <option value="produto">Problema com Produto</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="support-message">Mensagem</label>
                            <textarea class="form-control" id="support-message" name="support-message" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="support-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Notificação</strong>
                <small class="text-muted">Agora</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Mensagem enviada com sucesso!
            </div>
        </div>
    </div>

    <script>
        // Função para enviar o formulário de suporte
        $('#support-form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: '../backend/process_support.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#support-toast .toast-body').text(response.message);
                        $('#support-toast').toast('show');
                        $('#supportModal').modal('hide');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao enviar a mensagem!',
                            text: response.message || 'Tente novamente mais tarde.',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro de conexão!',
                        text: 'Não foi possível enviar sua mensagem. Tente novamente.',
                    });
                }
            });
        });
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>
