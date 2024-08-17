// Função para exibir mensagens de status
function displayMessage(status, message) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${status}`;
    messageDiv.textContent = message;
    document.body.appendChild(messageDiv);
    setTimeout(() => {
        messageDiv.remove();
    }, 3000);
}

// Adiciona um produto
document.getElementById('add-product-form')?.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);

    const response = await fetch('../backend/add_produto.php', {
        method: 'POST',
        body: formData
    });

    const result = await response.json();
    displayMessage(result.success ? 'success' : 'error', result.message);
    if (result.success) {
        location.reload(); // Recarrega a página para atualizar a lista de produtos
    }
});

// Remove um produto
document.querySelectorAll('.remove-product').forEach(button => {
    button.addEventListener('click', async (event) => {
        event.preventDefault();

        if (confirm('Tem certeza que deseja remover este produto?')) {
            const productId = button.getAttribute('data-id');

            const response = await fetch('../backend/remove_produto.php', {
                method: 'POST',
                body: new URLSearchParams({ id_produto: productId })
            });

            const result = await response.json();
            displayMessage(result.success ? 'success' : 'error', result.message);
            if (result.success) {
                location.reload(); // Recarrega a página para atualizar a lista de produtos
            }
        }
    });
});

// Edita um produto
document.querySelectorAll('.edit-product').forEach(button => {
    button.addEventListener('click', async (event) => {
        event.preventDefault();

        const productId = button.getAttribute('data-id');

        // Aqui você pode abrir um modal para edição e preencher os campos com os dados do produto

        const formData = new FormData(document.getElementById('edit-product-form'));
        formData.append('id_produto', productId);

        const response = await fetch('../backend/update_produto.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        displayMessage(result.success ? 'success' : 'error', result.message);
        if (result.success) {
            location.reload(); // Recarrega a página para atualizar a lista de produtos
        }
    });
});
