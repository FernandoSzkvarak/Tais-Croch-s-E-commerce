<!-- header.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tais Crochês</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles-header-footer.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">Tais Crochês</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pag_produtos.php">Produtos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pag_suporte.php">Suporte</a>
            </li>
            <!-- Dropdown Perfil -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <!-- Aqui usamos uma imagem de exemplo, você pode substituir pela imagem do usuário -->
                    <img src="img/usuario.png" alt="Avatar" class="rounded-circle" width="30" height="30" id="profileImage">
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="ver_perfil.php">Ver Perfil</a>
                    <a class="dropdown-item" href="editar_perfil.php">Editar Perfil</a>
                    <a class="dropdown-item" href="ver_compras.php">Ver Compras</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="logout.php">Sair</a>
                </div>
            </li>
            <!-- Fim Dropdown Perfil -->
        </ul>
    </div>
</nav>
