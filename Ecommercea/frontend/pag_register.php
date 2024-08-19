<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar - Tais Crochês</title>
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

        .register-container {
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

        .register-box {
            max-width: 350px;
            width: 100%;
        }

        .register-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .register-container .form-group label {
            color: #555;
        }

        .register-container .btn {
            background-color: #d5a6e0;
            border: none;
            color: white;
            width: 100%;
            margin-top: 10px;
        }

        .register-container .btn:hover {
            background-color: #c48ecf;
        }

        .register-container .login-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #333;
        }

        .register-container .login-link a {
            color: #d5a6e0;
            text-decoration: none;
        }

        .register-container .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="background-container"></div>

    <div class="register-container">
        <div class="register-box">
            <h1>Registrar</h1>
            <form id="register-form" action="../backend/process_auth.php" method="POST">
                <div class="form-group">
                    <label for="nome_completo">Nome Completo</label>
                    <input type="text" id="nome_completo" name="nome_completo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" class="form-control" required>
                </div>
                <button type="submit" class="btn">Registrar</button>
                <p class="login-link">Já tem conta? <a href="pag_login.php">Entrar</a></p>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $('#register-form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: '../backend/process_auth.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);  // Para depuração
                    response = JSON.parse(response);
                    if (response.success) {
                        alert(response.message);
                        window.location.href = 'pag_login.php';
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
    </script>

</body>
</html>
