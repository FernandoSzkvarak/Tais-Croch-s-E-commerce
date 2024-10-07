<?php
function criarPagamento($idClienteAsaas, $valor, $data_vencimento, $descricao, $billingType = 'BOLETO', $externalReference) {
    $url = 'https://sandbox.asaas.com/api/v3/subscriptions'; // Endpoint da API de assinaturas do Asaas
    $data = [
        'customer' => $idClienteAsaas,
        'cycle' => 'MONTHLY', // Ciclo mensal de pagamento
        'billingType' => $billingType, // Tipo de pagamento, pode ser BOLETO, CREDIT_CARD, etc.
        'nextDueDate' => $data_vencimento, // Data de vencimento do primeiro pagamento
        'value' => $valor, // Valor da assinatura mensal
        'description' => $descricao, // Descrição da cobrança
        'externalReference' => $externalReference // Referência externa para identificar a cobrança no sistema
    ];

    // Substitua pelo seu token de acesso real do Asaas
    $accessToken = 'SEU_TOKEN_DE_ACESSO'; // IMPORTANTE: Defina o token corretamente

    // Inicializando a requisição CURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'content-type: application/json',
        "access_token: $accessToken"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Enviar os dados no corpo da requisição

    // Executar a requisição e obter a resposta
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        // Se houver algum erro na requisição, retornamos o erro
        $error = curl_error($ch);
        curl_close($ch);
        return ['error' => $error];
    } else {
        // Obter o código de status HTTP da resposta
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Decodificar a resposta JSON
        $responseData = json_decode($response, true);

        // Verificar se a resposta foi decodificada corretamente como JSON
        if (json_last_error() === JSON_ERROR_NONE) {
            // Se a resposta for 200 (sucesso) e contiver o ID da assinatura
            if ($status_code == 200 && isset($responseData['id'])) {
                // Retorna o ID da assinatura criada
                return ['id' => $responseData['id']];
            } else {
                // Retorna um erro detalhado se houver falha na criação do pagamento
                return ['error' => 'Falha ao criar pagamento. Detalhes: ' . json_encode($responseData)];
            }
        } else {
            // Erro ao decodificar a resposta JSON
            return ['error' => 'Erro ao decodificar a resposta JSON.'];
        }
    }
}

// Exemplo de uso
$idClienteAsaas = 'ID_DO_CLIENTE'; // ID do cliente no Asaas (obtido previamente)
$valor = 222.00; // Valor da assinatura
$data_vencimento = '2024-10-04'; // Data de vencimento da assinatura
$descricao = 'Assinatura mensal de produtos'; // Descrição da cobrança
$billingType = 'BOLETO'; // Tipo de cobrança
$externalReference = 'Ref_12345'; // Referência externa

// Chamar a função para criar o pagamento
$resultado = criarPagamento($idClienteAsaas, $valor, $data_vencimento, $descricao, $billingType, $externalReference);

// Exibir o resultado
if (isset($resultado['id'])) {
    echo 'Assinatura criada com sucesso! ID da assinatura: ' . $resultado['id'];
} else {
    echo 'Erro: ' . $resultado['error'];
}
?>
