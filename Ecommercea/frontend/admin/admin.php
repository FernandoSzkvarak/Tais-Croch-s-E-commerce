<?php
session_start();

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    // Se não for administrador, redireciona para a página inicial
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="../styles-index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles-header-footer.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }
        footer {
            margin-top: auto;
        }
        .dashboard-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }
        .dashboard-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .dashboard-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        .dashboard-buttons a {
            width: 200px;
            padding: 15px;
            border-radius: 5px;
            font-size: 1.2rem;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .dashboard-buttons a.produtos {
            background-color: #28a745;
        }
        .dashboard-buttons a.produtos:hover {
            background-color: #218838;
        }
        .dashboard-buttons a.clientes {
            background-color: #007bff;
        }
        .dashboard-buttons a.clientes:hover {
            background-color: #0069d9;
        }
    </style>
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="dashboard-container">
        <h2 class="dashboard-title">Painel de Administração</h2>
        <div class="dashboard-buttons">
            <a href="admin_produtos.php" class="produtos">Produtos</a>
            <a href="admin_clientes.php" class="clientes">Clientes</a>
        </div>
    </div>

    <?php include '../footer.php'; ?>
</body>
</html>
