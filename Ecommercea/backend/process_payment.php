<?php
// Definir o cabeçalho para JSON
header('Content-Type: application/json');

include 'config.php'; // Inclua o arquivo de configuração com a chave da API Asaas
include 'db.php'; // Inclua o arquivo de conexão ao banco de dados

// Receber dados da requisição POST
$data = json_decode(file_get_contents('php://input'), true);

// Verificar se os dados necessários foram fornecidos
if (!$data || !isset($data['id_produto']) || !isset($data['valor'])) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    exit();
}

$id_produto = $data['id_produto'];
$valor = $data['valor'];

// Consultar o produto no banco de dados
$sqlProduto = "SELECT nome_produto FROM produtos WHERE id_produto = ?";
$stmtProduto = $conn->prepare($sqlProduto);
$stmtProduto->bind_param('i', $id_produto);
$stmtProduto->execute();
$stmtProduto->bind_result($nome_produto);
$stmtProduto->fetch();
$stmtProduto->close();

// Verificar se o produto foi encontrado
if (!$nome_produto) {
    echo json_encode(['success' => false, 'message' => 'Produto não encontrado.']);
    exit();
}

// Dados do cliente (supondo que o cliente já esteja logado e tenha um ID de usuário na sessão)
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
    exit();
}

$id_usuario = $_SESSION['user_id'];

// Consultar o usuário no banco de dados
$sqlUsuario = "SELECT email, nome_usuario FROM usuarios WHERE id_usuario = ?";
$stmtUsuario = $conn->prepare($sqlUsuario);
$stmtUsuario->bind_param('i', $id_usuario);
$stmtUsuario->execute();
$stmtUsuario->bind_result($email, $nome_usuario);
$stmtUsuario->fetch();
$stmtUsuario->close();

// Verificar se o usuário foi encontrado
if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Usuário não encontrado.']);
    exit();
}

// Preparar os dados do cliente para a API Asaas
$customerData = array(
    'name' => $nome_usuario, // Nome do cliente
    'email' => $email, // Email do cliente
);

// Verificar se o cliente já existe ou criar um novo cliente na API Asaas
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, ASAAS_API_URL . '/customers');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'access_token: ' . ASAAS_API_KEY
));
$customerResponse = curl_exec($ch);
curl_close($ch);

$customer = json_decode($customerResponse, true);

// Verificar se o cliente foi criado ou recuperado corretamente
if (!isset($customer['id'])) {
    echo json_encode(['success' => false, 'message' => 'Erro ao criar ou recuperar cliente.']);
    exit();
}

// Dados da cobrança
$paymentData = array(
    'customer' => $customer['id'], 
    'billingType' => 'BOLETO', 
    'dueDate' => date('Y-m-d', strtotime('+3 days')), 
    'value' => $valor, // Valor do pagamento
    'description' => 'Compra de ' . $nome_produto, 
    'externalReference' => 'Pedido_' . $id_produto, 
    'fine' => array(
        'value' => 1 
    ),
    'interest' => array(
        'value' => 0.03 // Juros de 3% ao mês
    )
);

// Criar o pagamento via API Asaas
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, ASAAS_API_URL . '/payments');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'access_token: ' . ASAAS_API_KEY
));
$result = curl_exec($ch);
curl_close($ch);

$response = json_decode($result, true);

// Verificar se a cobrança foi criada corretamente
if (isset($response['id'])) {
    // Cobrança criada com sucesso, retornar a URL do boleto
    echo json_encode(['success' => true, 'payment_url' => $response['invoiceUrl']]);
} else {
    // Exibir a mensagem de erro retornada pela API Asaas
    $errorMessage = isset($response['errors'][0]['description']) ? $response['errors'][0]['description'] : 'Erro desconhecido.';
    echo json_encode(['success' => false, 'message' => 'Erro ao criar cobrança: ' . $errorMessage]);
}
?>
