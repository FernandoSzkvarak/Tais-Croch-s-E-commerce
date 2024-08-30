$(document).ready(function() {
    // Certifique-se de que o jQuery Mask Plugin está carregado corretamente
    if (typeof $.fn.mask === 'undefined') {
        $.getScript('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js')
            .done(function() {
                applyMasks();
            })
            .fail(function() {
                console.error("Erro ao carregar o jQuery Mask Plugin.");
            });
    } else {
        applyMasks();
    }

    // Função para aplicar as máscaras
    function applyMasks() {
        $('#edit-cpf-cliente').mask('000.000.000-00');
        $('#edit-telefone-cliente').mask('(00) 00000-0000');
    }

    // Função para abrir o modal de edição com os dados do cliente
    window.editarCliente = function(id) {
        // Fazer uma requisição AJAX para obter os dados do cliente
        $.ajax({
            url: '../../backend/get_cliente.php',
            type: 'GET',
            data: { id: id },
            success: function(data) {
                const client = JSON.parse(data);

                // Preencher os campos do modal com os dados do cliente
                $('#edit-client-id').val(client.id_usuario || '');
                $('#edit-nome-cliente').val(client.nome_usuario || '');
                $('#edit-email-cliente').val(client.email || '');
                $('#edit-telefone-cliente').val(client.telefone || '');
                $('#edit-cpf-cliente').val(client.cpf || '');

                // Abrir o modal de edição
                $('#editClientModal').modal('show');
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao carregar dados do cliente!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    };

    // Função para enviar o formulário de edição
    // Função para enviar o formulário de edição
$('#edit-client-form').on('submit', function(event) {
    event.preventDefault();

    // Fazer a requisição AJAX para atualizar o cliente
    $.ajax({
        url: '../../backend/update_cliente.php', // Agora aponta para o novo arquivo
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cliente atualizado com sucesso!',
                    showConfirmButton: false,
                    timer: 2000
                });

                // Fechar o modal após a atualização
                $('#editClientModal').modal('hide');
                // Recarregar a página para atualizar a tabela
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao atualizar cliente!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },

            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao atualizar cliente!',
                    text: 'Erro no servidor. Por favor, tente novamente mais tarde.',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        });
    });

    // Função para remover cliente com confirmação do SweetAlert
    window.removerCliente = function(id) {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Esta ação não pode ser desfeita!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, remover!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Fazer a requisição AJAX para remover o cliente
                $.ajax({
                    url: '../../backend/process_clientes.php',
                    type: 'POST',
                    data: { action: 'remover', id: id },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Cliente removido com sucesso!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao remover cliente!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            }
        });
    };

    // Função para tornar um cliente administrador
    window.tornarAdmin = function(id) {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja conceder permissões de administrador para este cliente?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, tornar Admin!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Fazer a requisição AJAX para tornar o cliente um administrador
                $.ajax({
                    url: '../../backend/process_clientes.php',
                    type: 'POST',
                    data: { action: 'tornar_admin', id: id },
                    success: function() {
                        Swal.fire(
                            'Feito!',
                            'O cliente agora é um administrador.',
                            'success'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro ao tornar cliente admin!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            }
        });
    };
});
