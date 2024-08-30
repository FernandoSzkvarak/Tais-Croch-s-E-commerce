<?php

include 'db.php';

function log_debug($message) {
    file_put_contents('debug.log', date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
}

log_debug("Início do script process_clientes.php");

$response = array("success" => false, "message" => "");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    log_debug("Ação recebida: $action");

    switch ($action) {
        case 'editar':
            $id = $_POST['id'] ?? null;
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $telefone = $_POST['telefone'] ?? '';
            $cpf = $_POST['cpf'] ?? '';

            if ($id) {
                $query = "UPDATE usuarios SET nome_usuario = ?, email = ?, telefone = ?, cpf = ? WHERE id_usuario = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssssi", $nome, $email, $telefone, $cpf, $id);

                if ($stmt->execute()) {
                    log_debug("Cliente $id editado com sucesso.");
                    $response["success"] = true;
                } else {
                    log_debug("Erro ao editar cliente $id: " . $stmt->error);
                    $response["message"] = "Erro ao editar cliente.";
                }
                $stmt->close();
            } else {
                log_debug("ID do cliente não fornecido.");
                $response["message"] = "ID do cliente não fornecido.";
            }
            break;

        case 'remover':
            $id = $_POST['id'] ?? null;

            if ($id) {
                $query = "DELETE FROM usuarios WHERE id_usuario = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $id);

                if ($stmt->execute()) {
                    log_debug("Cliente $id removido com sucesso.");
                    $response["success"] = true;
                } else {
                    log_debug("Erro ao remover cliente $id: " . $stmt->error);
                    $response["message"] = "Erro ao remover cliente.";
                }
                $stmt->close();
            } else {
                log_debug("ID do cliente não fornecido para remoção.");
                $response["message"] = "ID do cliente não fornecido para remoção.";
            }
            break;

        case 'tornar_admin':
            $id = $_POST['id'] ?? null;

            if ($id) {
                $query = "UPDATE usuarios SET is_admin = 1 WHERE id_usuario = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $id);

                if ($stmt->execute()) {
                    log_debug("Usuário $id promovido a admin com sucesso.");
                    $response["success"] = true;
                } else {
                    log_debug("Erro ao promover usuário $id: " . $stmt->error);
                    $response["message"] = "Erro ao promover usuário.";
                }
                $stmt->close();
            } else {
                log_debug("ID do usuário não fornecido para promoção.");
                $response["message"] = "ID do usuário não fornecido para promoção.";
            }
            break;

        default:
            log_debug("Ação inválida ou não fornecida.");
            $response["message"] = "Ação inválida ou não fornecida.";
            break;
    }
} else {
    log_debug("Requisição inválida: Método não permitido.");
    $response["message"] = "Método de requisição inválido.";
}

$conn->close();
echo json_encode($response);

log_debug("Finalizando script process_clientes.php");

?>
