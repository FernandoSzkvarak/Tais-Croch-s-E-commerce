<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tais Crochês</title>
    <link rel="stylesheet" href="styles-index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }

        .background-container {
            position: relative;
            width: 70%;
            max-width: 1000px;
            height: 80%;
            background-image: url('img/fundo.jpg');
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.4);
        }

        .brand-text {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: #000000; /* Cor preta para o texto */
            font-size: 2.5rem;
            font-weight: bold;
        }

        .login-container {
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            width: 85%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.4);
        }

        .login-box h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group label {
            color: #555;
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #ff7f50;
            box-shadow: 0 0 5px rgba(255, 127, 80, 0.5);
        }

        .btn {
            background-color: #ff7f50;
            border: none;
            color: white;
            width: 100%;
            margin-top: 15px;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s ease;
            padding: 10px;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #ff6347;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #ff7f50;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="background-container">
        <div class="brand-text">Tais Crochês</div>
        <div class="login-container">
            <div class="login-box">
                <h1>Login</h1>
                <form id="login-form" action="../backend/process_auth.php" method="POST">
                    <input type="hidden" name="action" value="login">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn">Entrar</button>
                    <p class="register-link">Não tem conta? <a href="pag_register.php">Registrar</a></p>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#login-form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: '../backend/process_auth.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Login realizado com sucesso!',
                            showConfirmButton: false,
                            timer: 2000,
                            toast: true,
                            position: 'top-right'
                        }).then(() => {
                            window.location.href = 'index.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro no Login!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000,
                            toast: true,
                            position: 'top-right'
                        });
                    }
                }
            });
        });
    </script>

</body>
</html>
