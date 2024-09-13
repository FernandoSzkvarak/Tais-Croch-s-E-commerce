<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se os campos obrigatórios foram enviados
    if (empty($_POST['email']) || empty($_POST['id']) || empty($_POST['role'])) {
        echo "Campos obrigatórios não enviados.";
        exit();
    }

    // Coleta os dados enviados pelo POST
    $email = trim($_POST['email']);
    $id = intval($_POST['id']);
    $role = intval($_POST['role']); // 1 para administrador, 2 para colaborador

    // Verifica se o usuário existe no banco de dados
    $sql = "SELECT id_usuario FROM usuarios WHERE email = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Erro na preparação da consulta: " . $conn->error;
        exit();
    }

    $stmt->bind_param("si", $email, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se o usuário foi encontrado, atualiza o campo 'is_admin'
        $sql_update = "UPDATE usuarios SET is_admin = ? WHERE id_usuario = ?";
        $stmt_update = $conn->prepare($sql_update);

        if ($stmt_update === false) {
            echo "Erro na preparação da consulta de atualização: " . $conn->error;
            exit();
        }

        $stmt_update->bind_param("ii", $role, $id);

        if ($stmt_update->execute()) {
            echo "Usuário promovido com sucesso!";
        } else {
            echo "Erro ao promover o usuário: " . $stmt_update->error;
        }

        $stmt_update->close();
    } else {
        // Caso o usuário não seja encontrado
        echo "Usuário não encontrado.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
