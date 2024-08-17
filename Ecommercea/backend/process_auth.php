// Localização sugerida: /backend/process_auth.phpsession_start();
include'db.php'; // Inclua o arquivo de conexão ao banco de dadosif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == 'login') {
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['usuario'] = $user['nome_usuario'];
                header("Location: ../frontend/painel.php"); // Redireciona para o painelexit();
            } else {
                $_SESSION['erro_autenticacao'] = "Senha incorreta.";
            }
        } else {
            $_SESSION['erro_autenticacao'] = "Email não encontrado.";
        }
    } elseif ($action == 'register') {
        $nome_usuario = trim($_POST['nome_usuario']);
        $email = trim($_POST['email']);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['erro_autenticacao'] = "Email já registrado. Por favor, use outro email.";
        } else {
            $sql = "INSERT INTO usuarios (nome_usuario, email, senha) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nome_usuario, $email, $senha);

            if ($stmt->execute()) {
                $_SESSION['sucesso_registro'] = "Registro bem-sucedido! Você pode entrar agora.";
                header("Location: ../frontend/pag_auth.php");
                exit();
            } else {
                $_SESSION['erro_autenticacao'] = "Erro ao registrar. Tente novamente.";
            }
        }
    }

    $stmt->close();
    $conn->close();
    header("Location: ../frontend/pag_auth.php");
    exit();
} else {
    $_SESSION['erro_autenticacao'] = "Método de requisição inválido.";
    header("Location: ../frontend/pag_auth.php");
    exit();
}
