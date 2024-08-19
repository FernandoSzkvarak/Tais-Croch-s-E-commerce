<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header('Location: admin.php');
    exit();
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
            background-color: white;
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
            background-image: url('img/fundo.jpg');
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
    
    <div class="login-container">
        <div class="login-box">
            <h1>Tais Crochês<br>E-Commerce</h1>
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
            <?php endif; ?>
            <form action="process_auth.php" method="POST">
                <div class="form-group">
                    <label for="email">Usuário ou email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" class="form-control" required>
                    <small class="form-text text-muted"><a href="#">Esqueceu a senha?</a></small>
                </div>
                <button type="submit" class="btn">Entrar</button>
                <p class="register-link">Não tem conta? <a href="pag_register.php">Registrar</a></p>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
