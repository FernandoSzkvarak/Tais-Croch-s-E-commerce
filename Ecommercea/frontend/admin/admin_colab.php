<?php
session_start();

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../index.php");
    exit();
}

include '../backend/db.php';

// Seleciona todos os administradores
$sql = "SELECT id_usuario, nome_usuario, email, telefone FROM usuarios WHERE is_admin = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Colaboradores</title>
    <link rel="stylesheet" href="../styles-index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles-header-footer.css">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="container mt-5">
        <h2>Lista de Colaboradores</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_usuario']; ?></td>
                        <td><?php echo $row['nome_usuario']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['telefone']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php include '../footer.php'; ?>
</body>
</html>

<?php $conn->close(); ?>
