<?php
include 'db.php';

$response = ['success' => false, 'message' => ''];

// Verifica se todos os campos necessários foram enviados
if (isset($_POST['id']) && isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['telefone']) && isset($_POST['cpf'])) {
    $id = $_POST['id'];
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $cpf = trim($_POST['cpf']);

    // Valida os campos (aqui você pode adicionar mais validações conforme necessário)
    if (empty($nome) || empty($email) || empty($telefone) || empty($cpf)) {
        $response['message'] = 'Por favor, preencha todos os campos.';
    } else {
        // Atualiza os dados do cliente no banco de dados
        $stmt = $conn->prepare("UPDATE usuarios SET nome_usuario = ?, email = ?, telefone = ?, cpf = ? WHERE id_usuario = ?");
        $stmt->bind_param('ssssi', $nome, $email, $telefone, $cpf, $id);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Cliente atualizado com sucesso!';
        } else {
            $response['message'] = 'Erro ao atualizar cliente. Tente novamente.';
        }

        $stmt->close();
    }
} else {
    $response['message'] = 'Dados incompletos.';
}

echo json_encode($response);
$conn->close();
