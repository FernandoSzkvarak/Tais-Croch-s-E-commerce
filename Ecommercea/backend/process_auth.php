<?php
include 'db.php';
$response = array("success" => false, "message" => "");

$action = $_POST['action'];

if ($action === 'register') {
    // Registro de usuário
    $nome_completo = $_POST['nome_completo'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    // Verifica se o email já está registrado
    $query = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response["message"] = "Este email já está registrado.";
    } else {
        // Insere o novo usuário
        $query = "INSERT INTO usuarios (nome_usuario, email, telefone, cpf, senha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $nome_completo, $email, $telefone, $cpf, $senha);

        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Registro realizado com sucesso!";
        } else {
            $response["message"] = "Erro ao registrar. Tente novamente.";
        }
    }
} elseif ($action === 'login') {
    // Autenticação de usuário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se o email existe
    $query = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifica a senha
        if (password_verify($senha, $user['senha'])) {
            $response["success"] = true;
            $response["message"] = "Login realizado com sucesso!";
            // Inicia a sessão e redireciona o usuário para o índice
            session_start();
            $_SESSION['user_id'] = $user['id_usuario'];
            $_SESSION['user_name'] = $user['nome_usuario'];
        } else {
            $response["message"] = "Senha incorreta.";
        }
    } else {
        $response["message"] = "Email não registrado.";
    }
}

$conn->close();
echo json_encode($response);
