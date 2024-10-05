<?php
// Recebe os dados do Webhook
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se os dados essenciais foram recebidos
if (!isset($data['event']) || !isset($data['payment'])) {
    http_response_code(400);
    echo 'Webhook inválido.';
    exit();
}

// Conectar ao banco de dados
include 'db.php';

// Obter o ID do pagamento e o status do pagamento enviado pelo Asaas
$payment_id = $data['payment']['id'];
$status = $data['payment']['status']; // Status do pagamento (CONFIRMED, RECEIVED, etc.)

// Atualiza o status do pagamento no banco de dados
$sql = "UPDATE pedidos SET status_pagamento = ? WHERE id_pagamento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $status, $payment_id);

// Executa a consulta e verifica o sucesso
if ($stmt->execute()) {
    http_response_code(200);
    echo 'Webhook recebido com sucesso.';
} else {
    http_response_code(500);
    echo 'Erro ao atualizar o status do pagamento.';
}

// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
