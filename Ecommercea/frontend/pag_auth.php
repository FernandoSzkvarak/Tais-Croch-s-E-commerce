<?phpsession_start();
include'../backend/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        // Lógica de Login$sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();

            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id_usuario'];
                $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
                header("Location: admin.php");
                exit();
            } else {
                $erro = "Senha incorreta!";
            }
        } else {
            $erro = "Usuário não encontrado!";
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'register') {
        // Lógica de Registro$nome_usuario = trim($_POST['nome_usuario']);
        $email = trim($_POST['email']);
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $erro = "Email já registrado. Por favor, use outro email.";
        } else {
            $sql = "INSERT INTO usuarios (nome_usuario, email, senha) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nome_usuario, $email, $senha);
            if ($stmt->execute()) {
                $_SESSION['sucesso_registro'] = "Registro bem-sucedido! Você pode entrar agora.";
                header("Location: pag_login.php");
                exit();
            } else {
                $erro = "Erro ao registrar. Tente novamente.";
            }
        }
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tais Crochês</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: white; /* Fundo branco */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .background-container {
            width: 50%;
            height: 100%;
            background-image: url('img/fundo.jpg'); /* Caminho para a imagem de fundo */
            background-size: cover;
            background-position: center;
        }

        .login-container {
            width: 50%;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .login-box {
            max-width: 350px;
            width: 100%;
        }

        .login-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .login-container .form-group label {
            color: #555;
        }

        .login-container .btn {
            background-color: #d5a6e0;
            border: none;
            color: white;
            width: 100%;
            margin-top: 10px;
        }

        .login-container .btn:hover {
            background-color: #c48ecf;
        }

        .login-container .social-login {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .login-container .social-login button {
            width: 48%;
            background-color: #d5a6e0;
            border: none;
            color: white;
        }

        .login-container .social-login button i {
            margin-right: 5px;
        }

        .login-container .social-login button.google {
            background-color: #db4a39;
        }

        .login-container .social-login button.facebook {
            background-color: #3b5998;
        }

        .login-container .register-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #333;
        }

        .login-container .register-link a {
            color: #d5a6e0;
            text-decoration: none;
        }

        .login-container .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="background-container"></div>
    
    <divclass="login-container">
        <divclass="login-box">
            <h1>TaisCrochês<br>E-Commerce</h1>
            <?phpif (isset($erro)): ?>
                <divclass="alertalert-danger"><?phpecho $erro; ?></div>
            <?phpendif; ?>
            <formaction="pag_login.php" method="POST">
                <divclass="form-group">
                    <labelfor="email">Usuárioouemail</label>
                    <inputtype="email" name="email" class="form-control" required>
                </div>
                <divclass="form-group">
                    <labelfor="senha">Senha</label>
                    <inputtype="password" name="senha" class="form-control" required>
                    <smallclass="form-texttext-muted"><ahref="#">Esqueceuasenha?</a></small>
                </div>
                <buttontype="submit" class="btn" name="action" value="login">Entrar</button>
                <divclass="social-login">
                    <buttontype="button" class="btngoogle"><iclass="fabfa-google"></i> EntrarcomGoogle</button>
                    <buttontype="button" class="btnfacebook"><iclass="fabfa-facebook-f"></i> EntrarcomFacebook</button>
                </div>
                <pclass="register-link">Nãotemconta? <ahref="#" onclick="toggleForms()">Registrar</a></p>
            </form>
        </div>
    </div>

    <scriptsrc="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <scriptsrc="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <scriptsrc="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <scriptsrc="https://kit.fontawesome.com/a076d05399.js"></script>

    <script>
        functiontoggleForms() {
            // Alternar entre os formulários de login e registro
            document.querySelector('.login-box form').classList.toggle('d-none');
            document.querySelector('.register-link').classList.toggle('d-none');
        }
    </script>
</body>
</html>
