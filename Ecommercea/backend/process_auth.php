<?php

include 'db.php';

function log_debug($message) {
    file_put_contents('debug.log', date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
}

log_debug("Início do script process_auth.php");

$response = array("success" => false, "message" => "");

$action = $_POST['action'] ?? '';
log_debug("Ação recebida: $action");

if ($action === 'register') {
    log_debug("Processando registro de usuário.");
    
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($nome) || empty($email) || empty($telefone) || empty($cpf) || empty($senha)) {
        $response["message"] = "Por favor, preencha todos os campos.";
    } else {
        // Verifica se o email já está registrado
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            log_debug("Email já registrado: $email");
            $response["message"] = "Email já registrado.";
        } else {
            // Hash da senha
            $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

            // Insere novo usuário no banco de dados
            $query = "INSERT INTO usuarios (nome_usuario, email, telefone, cpf, senha) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssss", $nome, $email, $telefone, $cpf, $senha_hash);

            if ($stmt->execute()) {
                log_debug("Usuário registrado com sucesso: $email");
                $response["success"] = true;
                $response["message"] = "Registro realizado com sucesso!";
            } else {
                log_debug("Erro ao registrar usuário: " . $stmt->error);
                $response["message"] = "Erro ao registrar. Tente novamente.";
            }
        }
    }
} elseif ($action === 'login') {
    log_debug("Processando login de usuário.");
    
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $response["message"] = "Por favor, preencha todos os campos.";
    } else {
        // Verifica se o email existe
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            log_debug("Usuário encontrado: $email");

            // Verifica a senha
            if (password_verify($senha, $user['senha'])) {
                log_debug("Senha correta para usuário: $email");

                $response["success"] = true;
                $response["message"] = "Login realizado com sucesso!";

                // Inicia a sessão e armazena os dados do usuário na sessão
                session_start();
                $_SESSION['user_id'] = $user['id_usuario'];
                $_SESSION['user_name'] = $user['nome_usuario'];
                $_SESSION['is_admin'] = $user['is_admin']; // Armazena se o usuário é admin ou não
                
                log_debug("Valor de is_admin no banco de dados: " . $user['is_admin']);
                log_debug("Valor de is_admin armazenado na sessão: " . $_SESSION['is_admin']);

                // Logs adicionais para garantir que as variáveis de sessão estão definidas
                log_debug("Valor de \$_SESSION['user_id'] após login: " . ($_SESSION['user_id'] ?? 'N/A'));
                log_debug("Valor de \$_SESSION['is_admin'] após login: " . ($_SESSION['is_admin'] ?? 'N/A'));
            } else {
                log_debug("Senha incorreta para usuário: $email");
                $response["message"] = "Senha incorreta.";
            }
        } else {
            log_debug("Usuário não encontrado: $email");
            $response["message"] = "Email não registrado.";
        }
    }
} else {
    $response["message"] = "Ação inválida.";
}

$conn->close();
log_debug("Finalizando script process_auth.php");

echo json_encode($response);
?>
