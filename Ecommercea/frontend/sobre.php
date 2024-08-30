<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - Tais Crochês</title>
    <link rel="stylesheet" href="styles-header-footer.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
        }
        .container {
            margin-top: 50px;
            max-width: 800px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #6a1b9a;
            font-size: 2.5em;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .about-img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 30px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .section-title {
            font-size: 2em;
            margin-top: 30px;
            color: #d5a6e0;
            border-bottom: 2px solid #6a1b9a;
            padding-bottom: 10px;
        }
        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
            }
            .section-title {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Sobre Nós</h1>
        <p>
            Bem-vindo ao Tais Crochês, o seu e-commerce especializado em crochê com conceito e estilo. Aqui, mais do que vender produtos, entregamos arte e dedicação em cada peça que confeccionamos. Nosso objetivo é oferecer produtos de alta qualidade que agregam valor ao dia a dia dos nossos clientes, trazendo beleza e aconchego para suas casas.
        </p>
        <img src="img/sobre-nos.jpg" alt="Sobre nós - Tais Crochês" class="about-img">

        <h2 class="section-title">Nossa Missão</h2>
        <p>
            Nossa missão é proporcionar aos nossos clientes produtos de crochê que combinam criatividade, qualidade e funcionalidade. Valorizamos cada detalhe no processo de criação, desde a escolha dos materiais até o acabamento final, para garantir que cada peça seja única e especial.
        </p>

        <h2 class="section-title">Nossa História</h2>
        <p>
            O Tais Crochês nasceu da paixão pela arte do crochê e do desejo de levar essa arte para mais pessoas. Com anos de experiência e um olhar atento às tendências, nossa equipe se dedica a criar peças que vão desde acessórios e itens decorativos até utilidades para o lar, sempre com o toque artesanal que só o crochê pode oferecer.
        </p>

        <h2 class="section-title">O que Oferecemos</h2>
        <p>
            Em nossa loja, você encontrará uma variedade de produtos que vão além do comum. Oferecemos desde tapetes, mantas e almofadas até bolsas, acessórios e muito mais. Cada item é feito à mão com muito carinho, utilizando materiais de alta qualidade, como barbantes 100% algodão, para garantir durabilidade e conforto.
        </p>

        <h2 class="section-title">Nosso Compromisso</h2>
        <p>
            Estamos comprometidos em oferecer um atendimento de excelência, com uma experiência de compra fácil e segura. Se você precisar de qualquer ajuda ou tiver dúvidas, nossa equipe de suporte está sempre à disposição para atender você da melhor forma possível.
        </p>

        <h2 class="section-title">Entre em Contato</h2>
        <p>
            Quer saber mais sobre nossos produtos ou tem alguma sugestão? Fique à vontade para entrar em contato conosco através da nossa página de contato ou pelo nosso suporte via email. Adoraríamos ouvir de você e ajudar no que for necessário!
        </p>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
