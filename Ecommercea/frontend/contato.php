<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - Tais Crochês</title>
    <link rel="stylesheet" href="styles-header-footer.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }

        .contact-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 50px 15px;
        }

        .contact-info h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .contact-info p {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }

        .contact-links a {
            margin: 0 10px;
            color: #555;
            font-size: 24px;
            text-decoration: none;
        }

        .contact-links a:hover {
            color: #ff7f50;
        }

        footer {
            margin-top: auto;
        }
    </style>
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="contact-container">
        <div class="contact-info">
            <h2>Entre em Contato Conosco</h2>
            <p>Telefone/WhatsApp: (41) 99999-9999</p>
            <p>Email: <a href="mailto:taiscroches@gmail.com">taiscroches@gmail.com</a></p>
            <p>Instagram: <a href="https://www.instagram.com/tais_croches/" target="_blank">@tais_croches</a></p>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
