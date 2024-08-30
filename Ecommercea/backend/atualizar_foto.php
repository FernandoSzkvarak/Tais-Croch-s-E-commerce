<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/pag_login.php");
    exit();
}

// Verifica se o formulário foi enviado e se o arquivo foi carregado corretamente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
    include 'db.php';

    $user_id = $_SESSION['user_id'];

    // Diretório onde a imagem será salva
    $uploadDir = '../frontend/img/';
    $uploadFile = $uploadDir . basename($_FILES['foto_perfil']['name']);
    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

    // Verifica se o arquivo é uma imagem
    $check = getimagesize($_FILES['foto_perfil']['tmp_name']);
    if ($check === false) {
        echo "O arquivo selecionado não é uma imagem.";
        exit();
    }

    // Permite apenas alguns formatos de imagem
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
        exit();
    }

    // Move o arquivo para o diretório de upload
    if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $uploadFile)) {
        // Atualiza o caminho da foto de perfil no banco de dados
        $sql = "UPDATE usuarios SET foto_perfil = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("si", $_FILES['foto_perfil']['name'], $user_id);
            if ($stmt->execute()) {
                // Redireciona de volta para a página de perfil
                header("Location: ../frontend/ver_perfil.php");
                exit();
            } else {
                echo "Erro ao atualizar o banco de dados: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Erro na preparação da consulta SQL: " . $conn->error;
        }
    } else {
        echo "Desculpe, houve um erro ao enviar seu arquivo.";
    }

    $conn->close();
} else {
    echo "Nenhuma imagem foi enviada ou houve um erro no envio.";
}
?>
