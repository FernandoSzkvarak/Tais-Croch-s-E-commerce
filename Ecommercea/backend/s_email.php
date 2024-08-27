<?php

// Inclui o PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['support-name'] ?? '';
    $email = $_POST['support-email'] ?? '';
    $problem = $_POST['support-problem'] ?? '';
    $message = $_POST['support-message'] ?? '';

    // Cria uma nova instância do PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor de e-mail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'taiscroches@gmail.com'; // Seu endereço de email do Gmail
        $mail->Password = 'flkh advu tbqm csdc'; // Sua senha de app do Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinatário
        $mail->setFrom($email, $name);
        $mail->addAddress('taiscroches@gmail.com', 'Suporte'); // O endereço de email que receberá a mensagem de suporte

        // Conteúdo do email
        $mail->isHTML(true);
        $mail->Subject = 'Nova mensagem de suporte';
        $mail->Body = "Nome: $name<br>Email: $email<br>Problema: $problem<br>Mensagem:<br>$message";

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Email enviado com sucesso!']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Erro ao enviar email: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de requisição inválido.']);
}
