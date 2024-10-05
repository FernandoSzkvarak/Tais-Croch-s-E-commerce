<?php
@session_start(); // Inicia a sessão para acessar as variáveis de sessão

// Verifica se o usuário está logado como admin
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

// Define o caminho base relativo para acessar os arquivos de frontend e backend corretamente
$scriptPath = $_SERVER['SCRIPT_NAME'];

// Se estamos em uma página de administração, ajusta o caminho corretamente
$adminPath = (strpos($scriptPath, '/admin/') !== false);

// Verifica se estamos no frontend sem duplicar o caminho
if (basename($scriptPath) == 'index.php' || !$adminPath) {
    $basePath = '.';  // Para páginas no nível raiz do frontend (como index.php)
} elseif ($adminPath) {
    $basePath = '../..';  // Para páginas dentro do admin
} else {
    $basePath = '..';  // Para páginas em subdiretórios do frontend
}

// Corrige o caminho do CSS e da imagem de perfil, verificando se já estamos no frontend
$cssPath = $adminPath ? '../../frontend/styles-header-footer.css' : './styles-header-footer.css';
$imgPath = $adminPath ? '../../frontend/img/usuario.png' : './img/usuario.png';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tais Crochês</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $cssPath; ?>"> <!-- Caminho do CSS corrigido -->
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
                    <img src="<?php echo $imgPath; ?>" alt="Avatar" class="rounded-circle" width="30" height="30" id="profileImage"> <!-- Caminho da imagem corrigido -->
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

<!-- Scripts para garantir o funcionamento do dropdown -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
