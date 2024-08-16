<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['support-name'] ?? '';
    $email = $_POST['support-email'] ?? '';
    $message = $_POST['support-message'] ?? '';

    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'taiscroches@gmail.com'; // Seu endereço de email do Gmail
        $mail->Password = 'flkh advu tbqm csdc'; // Sua senha de app do Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinatário
        $mail->setFrom('taiscroches@gmail.com', 'Suporte'); // O mesmo endereço de email
        $mail->addAddress('taiscroches@gmail.com'); // O endereço de email que receberá a mensagem de suporte

        // Conteúdo
        $mail->isHTML(true);
        $mail->Subject = 'Nova mensagem de suporte';
        $mail->Body = "Nome: $name<br>Email: $email<br>Mensagem:<br>$message";

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Email enviado com sucesso!']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Erro ao enviar email: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de requisição inválido.']);
}
?>