<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="styles-index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles-header-footer.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2>Painel de Administração</h2>
        <button class="btn btn-success float-right mb-3" data-toggle="modal" data-target="#addProductModal">Adicionar Produto</button>
        <table class="table-admin table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Imagem</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="product-table-body">
                <?php
                include '../backend/db.php';

                $sql = "SELECT id_produto, nome_produto, descricao, imagem, preco, estoque FROM produtos";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_produto'] . "</td>";
                        echo "<td>" . $row['nome_produto'] . "</td>";
                        echo "<td>" . $row['descricao'] . "</td>";
                        echo "<td><img src='../backend/" . $row['imagem'] . "' alt='" . $row['nome_produto'] . "' style='width: 50px; height: auto;'></td>";
                        echo "<td>R$" . number_format($row['preco'], 2, ',', '.') . "</td>";
                        echo "<td>" . $row['estoque'] . "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-warning btn-sm edit-button' data-id='" . $row['id_produto'] . "'>Editar</button> ";
                        echo "<button class='btn btn-danger btn-sm remove-button' data-id='" . $row['id_produto'] . "'>Remover</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nenhum produto encontrado.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal para adicionar produto -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Adicionar Produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add-product-form">
                        <div class="form-group">
                            <label for="nome-produto">Nome do Produto</label>
                            <input type="text" class="form-control" id="nome-produto" name="nome-produto" required>
                        </div>
                        <div class="form-group">
                            <label for="descricao-produto">Descrição</label>
                            <textarea class="form-control" id="descricao-produto" name="descricao-produto" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="imagem-produto">Imagem do Produto</label>
                            <input type="file" class="form-control-file" id="imagem-produto" name="imagem-produto" required>
                        </div>
                        <div class="form-group">
                            <label for="preco-produto">Preço</label>
                            <input type="number" class="form-control" id="preco-produto" name="preco-produto" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="estoque-produto">Estoque</label>
                            <input type="number" class="form-control" id="estoque-produto" name="estoque-produto" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Adicionar Produto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar produto -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Editar Produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-product-form">
                        <input type="hidden" id="edit-product-id" name="product-id">
                        <div class="form-group">
                            <label for="edit-nome-produto">Nome do Produto</label>
                            <input type="text" class="form-control" id="edit-nome-produto" name="nome-produto" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-descricao-produto">Descrição</label>
                            <textarea class="form-control" id="edit-descricao-produto" name="descricao-produto" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit-imagem-produto">Imagem do Produto</label>
                            <input type="file" class="form-control-file" id="edit-imagem-produto" name="imagem-produto">
                        </div>
                        <div class="form-group">
                            <label for="edit-preco-produto">Preço</label>
                            <input type="number" class="form-control" id="edit-preco-produto" name="preco-produto" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-estoque-produto">Estoque</label>
                            <input type="number" class="form-control" id="edit-estoque-produto" name="estoque-produto" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="admin.js"></script>
</body>
</html>
