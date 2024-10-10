<?php
// Configuração de CORS para permitir requisições de qualquer origem
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Recebe a URL da API do Asaas
$asaasApiUrl = 'https://sandbox.asaas.com/api/v3/'; // URL do ambiente de testes do Asaas

// Define a chave de API do Asaas
$asaasApiKey = '$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDA0OTI4NzY6OiRhYWNoX2I0YjA5MDYzLTM1ZjMtNDkzNy1hNmEzLWFkYWRlMWIzYmVlOQ==';

// Verifica se existe uma requisição com um método HTTP suportado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o endpoint específico da API a partir do caminho de requisição
    $endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : 'payments';

    // Recupera os dados recebidos na requisição
    $requestBody = file_get_contents('php://input');

    // Inicia uma nova sessão CURL para fazer a requisição para a API Asaas
    $ch = curl_init($asaasApiUrl . $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'access_token: ' . $asaasApiKey
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);

    // Executa a requisição e obtém a resposta
    $response = curl_exec($ch);

    // Captura o código de status HTTP da resposta
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Envia a resposta da API Asaas de volta para o cliente com o código de status HTTP adequado
    http_response_code($httpCode);
    header('Content-Type: application/json');
    echo $response;
} else {
    // Resposta para métodos HTTP não permitidos
    http_response_code(405); // Método não permitido
    echo json_encode(['error' => 'Método HTTP não suportado. Use POST.']);
}
?>
