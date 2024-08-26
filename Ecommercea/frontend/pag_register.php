<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar - Tais Crochês</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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

        .register-container {
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

        .register-box h1 {
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

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #ff7f50;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="background-container">
        <div class="register-container">
            <div class="register-box">
                <h1>Registrar</h1>
                <form id="register-form" action="../backend/process_auth.php" method="POST">
                    <input type="hidden" name="action" value="register">
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
                        <input type="text" id="telefone" name="telefone" class="form-control" required maxlength="15">
                    </div>
                    <div class="form-group">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" class="form-control" required maxlength="14">
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
    </div>

    <script>
        // Aplicando as máscaras aos campos CPF e Telefone
        $(document).ready(function(){
            $('#cpf').mask('000.000.000-00');
            $('#telefone').mask('(00) 00000-0000');
        });

        $('#register-form').on('submit', function(event) {
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
                            title: 'Registrado com sucesso!',
                            showConfirmButton: false,
                            timer: 2000,
                            toast: true,
                            position: 'top-right'
                        }).then(() => {
                            window.location.href = 'pag_login.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao Registrar!',
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
