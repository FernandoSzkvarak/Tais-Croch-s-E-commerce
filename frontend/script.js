document.addEventListener('DOMContentLoaded', function () {
    // Função para abrir/fechar o pop-up de suporte
    document.getElementById('support-button').addEventListener('click', toggleSupportPopup);

    // Função para enviar o formulário de suporte
    document.getElementById('support-form').addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(event.target);

        fetch('../backend/s_email.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Email enviado com sucesso!');
            } else {
                showToast(`Erro: ${data.message}`, true);
            }
            document.getElementById('support-form').reset();
            toggleSupportPopup();
        })
        .catch(error => {
            console.error('Erro ao enviar o email:', error);
            showToast('Ocorreu um erro ao enviar sua mensagem. Por favor, tente novamente.', true);
        });
    });

    // Função para exibir a notificação
    function showToast(message, isError = false) {
        const toastContainer = document.getElementById('toast-container');
        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center text-bg-${isError ? 'danger' : 'success'} border-0`;
        toastEl.setAttribute('role', 'alert');
        toastEl.setAttribute('aria-live', 'assertive');
        toastEl.setAttribute('aria-atomic', 'true');

        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;

        toastContainer.appendChild(toastEl);

        const toast = new bootstrap.Toast(toastEl);
        toast.show();

        // Remover o toast após ele ser fechado
        toastEl.addEventListener('hidden.bs.toast', () => {
            toastEl.remove();
        });
    }

    // Função para abrir/fechar o pop-up de suporte
    function toggleSupportPopup() {
        const popup = document.getElementById('support-popup');
        if (popup.style.display === 'block') {
            popup.style.display = 'none';
        } else {
            popup.style.display = 'block';
        }
    }

    // Função para abrir/fechar o carrinho
    document.getElementById('cart-button').addEventListener('click', function() {
        const cartSidebar = document.getElementById('cart-sidebar');
        const cartOverlay = document.getElementById('cart-overlay');
        if (cartSidebar.classList.contains('open')) {
            cartSidebar.classList.remove('open');
            cartOverlay.classList.remove('open');
        } else {
            cartSidebar.classList.add('open');
            cartOverlay.classList.add('open');
        }
    });
});
