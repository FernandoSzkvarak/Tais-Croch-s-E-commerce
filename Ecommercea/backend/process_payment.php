<?php
// Inclua o arquivo de proxy que contém a função criarPagamento
include 'proxy.php';
header('Content-Type: application/json');

// Decodifique o JSON recebido
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

// Pegue os dados do request e valide as chaves corretamente
$idClienteAsaas = $data['idCliente'] ?? null;
$valor = $data['valor'] ?? null;
$data_vencimento = $data['dataVencimento'] ?? null;
$descricao = $data['descricao'] ?? null;
$billingType = $data['tipoPagamento'] ?? 'BOLETO';
$externalReference = $data['externalReference'] ?? null;

// Verifique se todos os campos obrigatórios estão presentes
if (!$idClienteAsaas || !$valor || !$data_vencimento || !$descricao || !$externalReference) {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos para processar o pagamento.']);
    exit;
}

// Chame a função para criar o pagamento usando a proxy
$resultadoPagamento = criarPagamento($idClienteAsaas, $valor, $data_vencimento, $descricao, $billingType, $externalReference);

// Verifique o resultado da função e retorne a resposta apropriada
if (isset($resultadoPagamento['id'])) {
    echo json_encode(['success' => true, 'idPagamento' => $resultadoPagamento['id']]);
} else {
    echo json_encode(['success' => false, 'message' => $resultadoPagamento['error'] ?? 'Erro desconhecido']);
}
?>
