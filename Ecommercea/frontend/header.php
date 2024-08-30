<?php
@session_start(); // Inicie a sessão para acessar as variáveis de sessão

// Supondo que você já tenha uma variável de sessão `is_admin` armazenada quando o usuário faz login
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

// Verifica se estamos na raiz ou em um subdiretório
$basePath = (basename($_SERVER['SCRIPT_NAME']) == 'index.php') ? '.' : '..';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tais Crochês</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $basePath; ?>/styles-header-footer.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo $basePath; ?>/index.php">Tais Crochês</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $basePath; ?>/index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $basePath; ?>/pag_produtos.php">Produtos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $basePath; ?>/pag_suporte.php">Suporte</a>
            </li>
            <!-- Dropdown Perfil -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="<?php echo $basePath; ?>/img/usuario.png" alt="Avatar" class="rounded-circle" width="30" height="30" id="profileImage">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="<?php echo $basePath; ?>/ver_perfil.php">Ver Perfil</a>
                
                
                    <?php if ($isAdmin): ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo $basePath; ?>/admin/admin.php">Painel Adm</a>
                    <?php endif; ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="<?php echo $basePath; ?>/logout.php">Sair</a>
                </div>
            </li>
            <!-- Fim Dropdown Perfil -->
        </ul>
    </div>
</nav>
