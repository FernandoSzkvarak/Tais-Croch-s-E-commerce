<?php
include 'config.php'; // Inclui as configurações da API

// Verifica se o ID do pagamento foi fornecido
if (!isset($_GET['payment_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID do pagamento não fornecido.']);
    exit();
}

$paymentId = $_GET['payment_id'];

// Inicializa o cURL para realizar a requisição à API do Asaas
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, ASAAS_API_URL . "/payments/{$paymentId}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'access_token: ' . ASAAS_API_KEY
));

// Executa a requisição e captura a resposta
$response = curl_exec($ch);

// Verifica se houve algum erro na requisição cURL
if (curl_errno($ch)) {
    echo json_encode(['success' => false, 'message' => 'Erro ao se conectar com o Asaas: ' . curl_error($ch)]);
    curl_close($ch);
    exit();
}

curl_close($ch);

// Decodifica a resposta da API
$responseData = json_decode($response, true);

// Verifica se a resposta contém o status do pagamento
if (isset($responseData['status'])) {
    echo json_encode([
        'success' => true,
        'status' => $responseData['status'],
        'data' => $responseData // Retorna todos os dados do pagamento se necessário
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Não foi possível obter o status do pagamento. Verifique o ID e tente novamente.',
        'response' => $responseData // Exibe a resposta completa para debug
    ]);
}
?>
