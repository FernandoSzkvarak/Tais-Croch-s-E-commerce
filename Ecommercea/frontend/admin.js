document.addEventListener('DOMContentLoaded', function() {
    fetchProducts();

    document.getElementById('add-product-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(e.target);
        const price = parseFloat(formData.get('preco-produto').replace(',', '.'));
        const stock = parseInt(formData.get('estoque-produto'));

        if (!formData.get('nome-produto').trim()) {
            Swal.fire('Erro', 'O nome do produto não pode ser vazio.', 'error');
            return;
        }

        if (isNaN(price) || price < 0) {
            Swal.fire('Erro', 'O preço não pode ser negativo.', 'error');
            return;
        }

        if (isNaN(stock) || stock < 0) {
            Swal.fire('Erro', 'O estoque não pode ser negativo.', 'error');
            return;
        }

        if (!formData.get('descricao-produto').trim()) {
            Swal.fire('Erro', 'A descrição do produto não pode ser vazia.', 'error');
            return;
        }

        Swal.fire({
            title: 'Adicionar Produto',
            text: 'Tem certeza que deseja adicionar este produto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, adicionar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('../backend/add_produto.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire('Sucesso', data.message, 'success').then(() => {
                        fetchProducts();
                        $('#addProductModal').modal('hide');
                    });
                })
                .catch(error => {
                    console.error('Erro ao adicionar produto:', error);
                    Swal.fire('Erro', 'Erro ao adicionar produto.', 'error');
                });
            }
        });
    });

    document.getElementById('edit-product-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(e.target);
        const price = parseFloat(formData.get('preco-produto').replace(',', '.'));
        const stock = parseInt(formData.get('estoque-produto'));

        if (!formData.get('nome-produto').trim()) {
            Swal.fire('Erro', 'O nome do produto não pode ser vazio.', 'error');
            return;
        }

        if (isNaN(price) || price < 0) {
            Swal.fire('Erro', 'O preço não pode ser negativo.', 'error');
            return;
        }

        if (isNaN(stock) || stock < 0) {
            Swal.fire('Erro', 'O estoque não pode ser negativo.', 'error');
            return;
        }

        if (!formData.get('descricao-produto').trim()) {
            Swal.fire('Erro', 'A descrição do produto não pode ser vazia.', 'error');
            return;
        }

        Swal.fire({
            title: 'Atualizar Produto',
            text: 'Tem certeza que deseja atualizar este produto?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, atualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                formData.set('product-id', document.getElementById('edit-product-id').value);

                fetch('../backend/update_produto.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire('Sucesso', data.message, 'success').then(() => {
                        fetchProducts();
                        $('#editProductModal').modal('hide');
                    });
                })
                .catch(error => {
                    console.error('Erro ao atualizar produto:', error);
                    Swal.fire('Erro', 'Erro ao atualizar produto.', 'error');
                });
            }
        });
    });

    function fetchProducts() {
        fetch('../backend/list_produtos.php')
        .then(response => response.json())
        .then(data => {
            const productTable = document.getElementById('product-table-body');
            productTable.innerHTML = '';

            data.forEach(product => {
                const row = document.createElement('tr');
                row.id = `product-${product.id_produto}`;
                row.innerHTML = `
                    <td>${product.id_produto}</td>
                    <td>${product.nome_produto}</td>
                    <td>${product.descricao}</td>
                    <td><img src="../backend/${product.imagem}" alt="${product.nome_produto}" style="width: 50px; height: 50px;"></td>
                    <td>R$${product.preco}</td>
                    <td>${product.estoque}</td>
                    <td>
                        <button class="edit-button btn btn-warning btn-sm" data-id="${product.id_produto}">Editar</button>
                        <button class="remove-button btn btn-danger btn-sm" data-id="${product.id_produto}">Remover</button>
                    </td>
                `;
                productTable.appendChild(row);
            });

            document.querySelectorAll('.edit-button').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    openEditModal(id);
                });
            });

            document.querySelectorAll('.remove-button').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    confirmRemoveProduct(id);
                });
            });
        })
        .catch(error => console.error('Erro ao buscar produtos:', error));
    }

    function openEditModal(id) {
        fetch(`../backend/get_produto.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById('edit-product-id').value = data.id_produto;
                document.getElementById('edit-nome-produto').value = data.nome_produto;
                document.getElementById('edit-descricao-produto').value = data.descricao;
                document.getElementById('edit-preco-produto').value = data.preco.replace('.', ','); // Converte ponto para vírgula
                document.getElementById('edit-estoque-produto').value = data.estoque;
                $('#editProductModal').modal('show');
            }
        })
        .catch(error => console.error('Erro ao buscar produto:', error));
    }

    function confirmRemoveProduct(id) {
        Swal.fire({
            title: 'Remover Produto',
            text: 'Tem certeza que deseja remover este produto? Esta ação não pode ser desfeita.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, remover',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                removeProduct(id);
            }
        });
    }

    function removeProduct(id) {
        const formData = new FormData();
        formData.append('product-id', id);

        fetch('../backend/remove_produto.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire('Sucesso', data.message, 'success').then(() => {
                document.getElementById(`product-${id}`).remove();
            });
        })
        .catch(error => {
            console.error('Erro ao remover produto:', error);
            Swal.fire('Erro', 'Erro ao remover produto.', 'error');
        });
    }
});
