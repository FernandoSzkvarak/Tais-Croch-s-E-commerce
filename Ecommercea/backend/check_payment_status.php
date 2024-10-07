<?php
include 'config.php'; // Inclua o arquivo de configuração com a chave da API
include 'db.php'; // Inclua a conexão com o banco de dados

// Receber o ID do pagamento que será verificado
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id_pagamento'])) {
    echo json_encode(['success' => false, 'message' => 'ID de pagamento não fornecido.']);
    exit;
}

$idPagamento = $data['id_pagamento'];

// Verifica o status do pagamento na API Asaas
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://sandbox.asaas.com/api/v3/payments/' . $idPagamento);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'access_token: ' . ASAAS_API_KEY
));

$response = curl_exec($ch);
curl_close($ch);

// Decodificar a resposta JSON
$paymentData = json_decode($response, true);

// Verificar o status do pagamento
if (isset($paymentData['status'])) {
    // Retorna o status atual do pagamento
    echo json_encode(['success' => true, 'status' => $paymentData['status']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Falha ao verificar o status do pagamento.']);
}
?>
