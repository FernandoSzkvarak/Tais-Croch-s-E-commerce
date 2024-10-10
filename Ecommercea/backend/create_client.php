<?php
function criarClienteAsaas($nome, $email, $cpfCnpj, $telefone) {
    $url = 'https://sandbox.asaas.com/api/v3/customers';
    $data = [
        'name' => $nome,
        'email' => $email,
        'cpfCnpj' => $cpfCnpj,
        'phone' => $telefone,
        'mobilePhone' => $telefone,
        'notificationDisabled' => false
    ];

    // Seu token de acesso à API Asaas
    $accessToken = '$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDA0OTI4NzY6OiRhYWNoX2I0YjA5MDYzLTM1ZjMtNDkzNy1hNmEzLWFkYWRlMWIzYmVlOQ==';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'content-type: application/json',
        "access_token: $accessToken"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        return ['error' => $error];
    } else {
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $responseData = json_decode($response, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            if ($status_code == 200 && isset($responseData['id'])) {
                return ['id' => $responseData['id']];
            } else {
                return ['error' => 'Falha ao criar cliente. Detalhes: ' . json_encode($responseData)];
            }
        } else {
            return ['error' => 'Erro ao decodificar a resposta JSON.'];
        }
    }
}
?>
