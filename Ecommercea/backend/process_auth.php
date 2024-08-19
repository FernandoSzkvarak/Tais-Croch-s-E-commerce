<?php
session_start();
include '../backend/db.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['senha'])) {

        // Lógica de Registro
        if (isset($_POST['nome_completo'])) {
            $nome_usuario = trim($_POST['nome_completo']);
            $email = trim($_POST['email']);
            $telefone = trim($_POST['telefone']);
            $cpf = trim($_POST['cpf']);
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

            $sql = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $response['message'] = "Email já registrado. Por favor, use outro email.";
            } else {
                $sql = "INSERT INTO usuarios (nome_usuario, email, telefone, cpf, senha) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", $nome_usuario, $email, $telefone, $cpf, $senha);
                if ($stmt->execute()) {
                    $_SESSION['sucesso_registro'] = "Registro bem-sucedido! Você pode entrar agora.";
                    $response['success'] = true;
                    $response['message'] = "Registro realizado com sucesso!";
                } else {
                    $response['message'] = "Erro ao registrar. Tente novamente.";
                    error_log("Erro ao executar o statement: " . $stmt->error);
                }
            }

        // Lógica de Login
        } else {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $sql = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $usuario = $result->fetch_assoc();

                if (password_verify($senha, $usuario['senha'])) {
                    $_SESSION['usuario_id'] = $usuario['id_usuario'];
                    $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
                    $response['success'] = true;
                    $response['message'] = 'Login realizado com sucesso!';
                } else {
                    $response['message'] = 'Senha incorreta!';
                }
            } else {
                $response['message'] = 'Usuário não encontrado!';
            }
        }

        $stmt->close();
        $conn->close();
        echo json_encode($response);
        exit();
    }
}
?>
