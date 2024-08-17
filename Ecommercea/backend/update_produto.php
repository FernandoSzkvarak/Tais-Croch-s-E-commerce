<?php
include 'db.php';

$response = ['success' => false, 'message' => ''];

// Exibe todos os erros PHP para depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product-id'];
    $name = trim($_POST['nome-produto']);
    $price = str_replace(',', '.', $_POST['preco-produto']);
    $stock = $_POST['estoque-produto'];
    $description = trim($_POST['descricao-produto']);
    $image = $_FILES['imagem-produto']['name'] ?? '';

    // Validação dos campos
    if (empty($name)) {
        $response['message'] = "O nome do produto não pode ser vazio.";
    } elseif (empty($price) || !is_numeric($price) || $price < 0) {
        $response['message'] = "O preço do produto não pode ser vazio ou negativo.";
    } elseif (empty($stock) || !is_numeric($stock) || $stock < 0) {
        $response['message'] = "O estoque do produto não pode ser vazio ou negativo.";
    } elseif (empty($description)) {
        $response['message'] = "A descrição do produto não pode ser vazia.";
    } else {
        // Atualização do produto sem alterar a imagem
        $sql = "UPDATE produtos SET nome_produto = ?, preco = ?, estoque = ?, descricao = ? WHERE id_produto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdiss", $name, $price, $stock, $description, $product_id);

        if (!$stmt) {
            $response['message'] = "Erro na preparação do statement: " . $conn->error;
        } else {
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Produto atualizado com sucesso!";
            } else {
                $response['message'] = "Erro ao atualizar produto: " . $stmt->error;
            }
            $stmt->close();
        }

        // Se uma nova imagem foi carregada, atualize a imagem também
        if (!empty($image)) {
            $target_dir = "uploads/";
            $image = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $image); // Evita nomes duplicados e remove caracteres inválidos
            $target_file = $target_dir . basename($image);

            // Criação do diretório, se não existir
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // Verifica o tipo de imagem
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (!in_array($imageFileType, $validExtensions)) {
                $response['message'] = "Somente arquivos JPG, JPEG, PNG e GIF são permitidos.";
            } elseif ($_FILES['imagem-produto']['size'] > 5000000) { // Limite de 5MB
                $response['message'] = "O tamanho da imagem não pode exceder 5MB.";
            } elseif (move_uploaded_file($_FILES['imagem-produto']['tmp_name'], $target_file)) {
                // Caminho relativo para salvar no banco de dados
                $relative_path = $target_dir . basename($image);

                // Atualização do caminho da imagem no banco de dados
                $sql = "UPDATE produtos SET imagem = ? WHERE id_produto = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $relative_path, $product_id);

                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] .= " e a imagem foi atualizada.";
                } else {
                    $response['message'] = "Erro ao atualizar a imagem: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $response['message'] = "Erro ao fazer upload da imagem.";
            }
        }
    }
}

$conn->close();
echo json_encode($response);
?>
