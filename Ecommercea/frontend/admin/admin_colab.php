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
    <title>Gerenciar Colaboradores</title>
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
        .btn-promo {
            background-color: var(--info-color) !important;
            color: white !important;
        }
        .btn-promover {
            background-color: #17a2b8;
            color: white;
        }
    </style>
</head>
<body>
    <?php include $baseDir . 'header.php'; ?>

    <div class="container">
        <h2>Gerenciar Colaboradores</h2>
        <button class="btn btn-promover" data-toggle="modal" data-target="#promoUserModal">Promover Usuário</button>
        <table class="table-admin table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>CPF</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include $baseDir . '../backend/db.php';

                // Mostra todos os administradores e colaboradores (is_admin = 1 ou 2)
                $sql = "SELECT id_usuario, nome_usuario, email, telefone, cpf, is_admin FROM usuarios WHERE is_admin IN (1, 2)";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id_usuario'] . "</td>";
                        echo "<td>" . $row['nome_usuario'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['telefone'] . "</td>";
                        echo "<td>" . $row['cpf'] . "</td>";
                        echo "<td>" . ($row['is_admin'] == 1 ? 'Administrador' : 'Colaborador') . "</td>";
                        echo "<td>";
                        echo "<div class='btn-group'>";
                        echo "<button class='btn btn-editar btn-sm' onclick='editarColab(" . $row['id_usuario'] . ")'>Editar</button>";
                        echo "<button class='btn btn-remover btn-sm' onclick='removerColab(" . $row['id_usuario'] . ")'>Remover</button>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nenhum colaborador encontrado.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <?php include $baseDir . 'footer.php'; ?>

    <!-- Modal para promoção de usuário -->
    <div class="modal fade" id="promoUserModal" tabindex="-1" aria-labelledby="promoUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="promoUserModalLabel">Promover Usuário</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="promo-user-form">
                        <div class="form-group">
                            <label for="promo-email">Email do Usuário</label>
                            <input type="email" class="form-control" id="promo-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="promo-id">ID do Usuário</label>
                            <input type="number" class="form-control" id="promo-id" name="id" required>
                        </div>
                        <div class="form-group">
                            <label for="promo-role">Promover para</label>
                            <select class="form-control" id="promo-role" name="role" required>
                                <option value="1">Administrador</option>
                                <option value="2">Colaborador</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Promover Usuário</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Envio do formulário de promoção de usuário
        $('#promo-user-form').submit(function(e) {
            e.preventDefault();
            var email = $('#promo-email').val();
            var id = $('#promo-id').val();
            var role = $('#promo-role').val();

            $.ajax({
                url: '../../backend/promo_user.php',
                method: 'POST',
                data: {
                    email: email,
                    id: id,
                    role: role
                },
                success: function(response) {
                    Swal.fire('Sucesso', response, 'success').then(() => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire('Erro', 'Erro ao promover o usuário.', 'error');
                }
            });
        });
    </script>
</body>
</html>
