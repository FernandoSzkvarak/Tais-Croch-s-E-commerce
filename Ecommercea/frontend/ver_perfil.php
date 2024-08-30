<?php
@session_start(); // O "@" suprime qualquer erro gerado por esta linha

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: pag_login.php");
    exit();
}

include '../backend/db.php';

// Obtém os dados do usuário logado
$user_id = $_SESSION['user_id'];
$sql = "SELECT nome_usuario, email, telefone, cpf, foto_perfil FROM usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Usuário não encontrado.";
        exit();
    }
} else {
    echo "Erro na preparação da consulta SQL: " . $conn->error;
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Perfil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles-header-footer.css">
    <style>
        .profile-container {
            margin-top: 50px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .profile-container h2 {
            font-size: 2rem;
            color: #343a40;
            margin-bottom: 20px;
        }
        .profile-container img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            margin-bottom: 20px;
        }
        .profile-container p {
            font-size: 1.2rem;
            color: #343a40;
            margin-bottom: 10px;
        }
        .profile-container form {
            margin-top: 20px;
        }
        footer {
            margin-top: 50vh;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="profile-container">
        <h2>Perfil de <?php echo isset($user['nome_usuario']) ? htmlspecialchars($user['nome_usuario']) : 'Nome não disponível'; ?></h2>
        <img src="img/<?php echo isset($user['foto_perfil']) ? htmlspecialchars($user['foto_perfil']) : 'usuario.png'; ?>" alt="Foto de Perfil">
        <p>Email: <?php echo isset($user['email']) ? htmlspecialchars($user['email']) : 'Email não disponível'; ?></p>
        <p>Telefone: <?php echo isset($user['telefone']) ? htmlspecialchars($user['telefone']) : 'Telefone não disponível'; ?></p>
        <p>CPF: <?php echo isset($user['cpf']) ? htmlspecialchars($user['cpf']) : 'CPF não disponível'; ?></p>

        <form action="../backend/atualizar_foto.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="foto_perfil">Trocar Foto de Perfil:</label>
                <input type="file" class="form-control-file" id="foto_perfil" name="foto_perfil">
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Foto</button>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
