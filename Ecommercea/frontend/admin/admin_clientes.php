<?php
@session_start(); // O "@" suprime qualquer erro gerado por esta linha

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit();
}
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Defina o diretório base
$baseDir = '../';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $baseDir; ?>styles-header-footer.css">

    <style>
        :root {
            --primary-color: #6a1b9a; /* Cor principal */
            --secondary-color: #d5a6e0; /* Cor secundária */
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            background-color: var(--light-gray);
        }
        footer {
            margin-top: auto;
        }
        .container {
            margin-top: 50px;
            max-width: 1200px;
        }
        h2 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: bold;
        }
        .table-admin th, .table-admin td {
            vertical-align: middle;
            text-align: center;
        }
        .table-admin th {
            background-color: var(--dark-gray);
            color: white;
        }
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .btn-editar {
            background-color: var(--warning-color) !important;
            color: black !important;
        }
        .btn-remover {
            background-color: var(--danger-color) !important;
            color: white !important;
        }
        .btn-admin {
            background-color: var(--info-color) !important;
            color: white !important;
        }
    </style>
</head>
<body>
    <?php include $baseDir . 'header.php'; ?>

    <div class="container">
        <h2>Gerenciar Clientes</h2>
        <table class="table-admin table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>CPF</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include $baseDir . '../backend/db.php';

                $sql = "SELECT id_usuario, nome_usuario, email, telefone, cpf, is_admin FROM usuarios";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_usuario'] . "</td>";
                        echo "<td>" . $row['nome_usuario'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['telefone'] . "</td>";
                        echo "<td>" . $row['cpf'] . "</td>";
                        echo "<td>";
                        echo "<div class='btn-group'>";
                        echo "<button class='btn btn-editar btn-sm' onclick='editarCliente(" . $row['id_usuario'] . ")'>Editar</button>";
                        echo "<button class='btn btn-remover btn-sm' onclick='removerCliente(" . $row['id_usuario'] . ")'>Remover</button>";
                        if ($row['is_admin'] != 1) { // Se não for admin, mostra o botão
                            echo "<button class='btn btn-admin btn-sm' onclick='tornarAdmin(" . $row['id_usuario'] . ")'>Tornar Admin</button>";
                        }
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhum cliente encontrado.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <?php include $baseDir . 'footer.php'; ?>

    <!-- Modal para editar cliente -->
    <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editClientModalLabel">Editar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-client-form">
                        <input type="hidden" id="edit-client-id" name="id">
                        <div class="form-group">
                            <label for="edit-nome-cliente">Nome</label>
                            <input type="text" class="form-control" id="edit-nome-cliente" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-email-cliente">Email</label>
                            <input type="email" class="form-control" id="edit-email-cliente" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-telefone-cliente">Telefone</label>
                            <input type="text" class="form-control" id="edit-telefone-cliente" name="telefone" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-cpf-cliente">CPF</label>
                            <input type="text" class="form-control" id="edit-cpf-cliente" name="cpf" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo $baseDir; ?>admin/admin_clientes.js"></script>
</body>
</html>
