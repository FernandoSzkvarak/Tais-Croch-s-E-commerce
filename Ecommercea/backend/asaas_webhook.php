<?php
// Inclua o arquivo de conexão ao banco de dados
include 'db.php';

// Obter o conteúdo da requisição POST enviada pelo Asaas
$payload = file_get_contents('php://input');

// Verificar se a requisição POST contém dados
if (!$payload) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Nenhum dado recebido.']);
    exit;
}

// Decodificar o JSON recebido
$data = json_decode($payload, true);

// Verifique se os dados recebidos são válidos
if (json_last_error() !== JSON_ERROR_NONE || !isset($data['event'], $data['payment'])) {
    http_response_code(400); // Retorna erro se os dados não forem válidos
    echo json_encode(['success' => false, 'message' => 'Dados inválidos ou formato JSON incorreto.']);
    exit;
}

// Pega os dados principais
$eventType = $data['event']; // Tipo de evento (e.g. payment_received)
$paymentId = $data['payment']['id'] ?? null; // ID do pagamento
$status = $data['payment']['status'] ?? null; // Status do pagamento (e.g. RECEIVED)
$value = $data['payment']['value'] ?? 0; // Valor do pagamento

// Verificar se os dados essenciais estão presentes
if (!$paymentId || !$status) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Dados de pagamento incompletos.']);
    exit;
}

// Função para registrar logs de erros ou eventos
function logWebhookEvent($message) {
    $logFile = 'asaas_webhook.log';
    file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
}

// Você pode implementar diferentes ações com base no tipo de evento
switch ($eventType) {
    case 'PAYMENT_RECEIVED':
        // O pagamento foi recebido
        $sql = "UPDATE pedidos SET status_pagamento = 'PAGO', valor_pago = ? WHERE id_pagamento_asaas = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ds", $value, $paymentId);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Pagamento atualizado com sucesso.']);
            logWebhookEvent("Pagamento recebido e atualizado com sucesso para ID de pagamento: $paymentId");
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o status do pagamento no banco de dados.']);
            logWebhookEvent("Erro ao atualizar pagamento: " . $conn->error);
        }
        break;

    case 'PAYMENT_OVERDUE':
        // Pagamento em atraso
        $sql = "UPDATE pedidos SET status_pagamento = 'ATRASADO' WHERE id_pagamento_asaas = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $paymentId);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Status de pagamento atrasado atualizado.']);
            logWebhookEvent("Status de pagamento atualizado para 'ATRASADO' para ID de pagamento: $paymentId");
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o status de atraso no banco de dados.']);
            logWebhookEvent("Erro ao atualizar pagamento em atraso: " . $conn->error);
        }
        break;

    case 'PAYMENT_CONFIRMED':
        // Pagamento confirmado
        $sql = "UPDATE pedidos SET status_pagamento = 'CONFIRMADO' WHERE id_pagamento_asaas = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $paymentId);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Status de pagamento confirmado atualizado.']);
            logWebhookEvent("Status de pagamento confirmado para ID de pagamento: $paymentId");
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o status no banco de dados.']);
            logWebhookEvent("Erro ao atualizar status confirmado: " . $conn->error);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Evento não tratado.']);
        logWebhookEvent("Evento não tratado recebido: $eventType");
        break;
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
