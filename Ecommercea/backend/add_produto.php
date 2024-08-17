<?php
include 'db.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitização e Validação de Inputs
    $name = trim($_POST['nome-produto'] ?? '');
    $price = str_replace(',', '.', $_POST['preco-produto'] ?? '');
    $stock = $_POST['estoque-produto'] ?? '';
    $description = trim($_POST['descricao-produto'] ?? '');
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
    } elseif (empty($image)) {
        $response['message'] = "A imagem do produto não pode ser vazia.";
    } else {
        // Configuração do diretório de upload
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

            // Inserção no banco de dados
            $sql = "INSERT INTO produtos (nome_produto, preco, estoque, imagem, descricao) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                $response['message'] = "Erro na preparação do statement: " . $conn->error;
            } else {
                $stmt->bind_param("sdiss", $name, $price, $stock, $relative_path, $description);
                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = "Produto adicionado com sucesso!";
                } else {
                    $response['message'] = "Erro ao adicionar produto: " . $stmt->error;
                }
                $stmt->close();
            }
        } else {
            $response['message'] = "Erro ao fazer upload da imagem.";
        }
    }
    $conn->close();
    echo json_encode($response);
}
?>
