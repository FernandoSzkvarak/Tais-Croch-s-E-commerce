<?php
session_start();
require_once '../backend/db.php';

$userId = $_SESSION['user_id'];
$uploadDir = '../uploads/'; // Diretório onde as fotos serão armazenadas
$defaultProfilePic = 'usuario.png'; // Nome da imagem padrão

// Verifica se um arquivo foi enviado
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
    $fileTmpPath = $_FILES['foto_perfil']['tmp_name'];
    $fileName = $_FILES['foto_perfil']['name'];
    $fileSize = $_FILES['foto_perfil']['size'];
    $fileType = $_FILES['foto_perfil']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Verifica a extensão do arquivo
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $dest_path = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Atualiza o caminho da foto de perfil no banco de dados
            $stmt = $conn->prepare("UPDATE usuarios SET foto_perfil = ? WHERE id_usuario = ?");
            $stmt->bind_param('si', $newFileName, $userId);
            if ($stmt->execute()) {
                $_SESSION['message'] = "Perfil atualizado com sucesso!";
            } else {
                $_SESSION['message'] = "Erro ao atualizar perfil no banco de dados.";
            }
        } else {
            $_SESSION['message'] = "Erro ao mover o arquivo para o diretório de upload.";
        }
    } else {
        $_SESSION['message'] = "Tipo de arquivo não permitido.";
    }
} else {
    $_SESSION['message'] = "Nenhuma imagem enviada.";
}

header("Location: ver_perfil.php");
exit();
?>
