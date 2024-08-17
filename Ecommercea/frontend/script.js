// Função para abrir/fechar o pop-up de suporte
function toggleSupportPopup() {
    const popup = document.getElementById('support-popup');
    popup.style.display = (popup.style.display === 'block') ? 'none' : 'block';
}

// Função para exibir uma notificação de sucesso usando SweetAlert2
function showSuccessNotification() {
    Swal.fire({
        icon: 'success',
        title: 'Email enviado com sucesso!',
        showConfirmButton: false,
        timer: 3000,
        toast: true,
        position: 'top-right'
    }).then(() => {
        // Fecha o modal após a notificação de sucesso desaparecer
        toggleSupportPopup();
    });
}

// Função para enviar o formulário de suporte
function submitSupportForm(event) {
    event.preventDefault();

    const submitButton = document.querySelector('#support-form button[type="submit"]');
    submitButton.disabled = true; // Desabilitar o botão de envio
    submitButton.innerHTML = 'Enviando...'; // Indicador de carregamento

    const formData = new FormData(document.getElementById('support-form'));

    fetch('../backend/s_email.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Exibir notificação de sucesso
            showSuccessNotification();
        } else {
            // Exibir notificação de erro, mas não fechar o modal
            Swal.fire({
                icon: 'error',
                title: 'Erro ao enviar o email!',
                text: 'Ocorreu um erro ao enviar sua mensagem. Por favor, tente novamente.',
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                position: 'top-right'
            });
        }
    })
    .catch(error => {
        console.error('Erro ao enviar o email:', error);
        Swal.fire({
            icon: 'error',
            title: 'Erro ao enviar o email!',
            text: 'Ocorreu um erro ao enviar sua mensagem. Por favor, tente novamente.',
            showConfirmButton: false,
            timer: 3000,
            toast: true,
            position: 'top-right'
        });
    })
    .finally(() => {
        submitButton.disabled = false; // Reabilitar o botão de envio
        submitButton.innerHTML = 'Enviar'; // Restaurar o texto do botão
        document.getElementById('support-form').reset();
    });
}

// Inicialização dos eventos após o DOM estar completamente carregado
document.addEventListener('DOMContentLoaded', function () {
    const supportForm = document.getElementById('support-form');
    const supportButton = document.getElementById('support-button');
    const cartIcon = document.getElementById('cart-icon');

    if (supportForm) {
        supportForm.addEventListener('submit', submitSupportForm);
    }
    if (supportButton) {
        supportButton.addEventListener('click', toggleSupportPopup);
    }
    if (cartIcon) {
        cartIcon.addEventListener('click', toggleCart);
    }
});
