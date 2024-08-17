<footer class="bg-dark text-light text-center p-3 mt-auto">
    © 2024 Loja de Produtos de Crochê
</footer>

<!-- Suporte Button -->
<button type="button" class="btn btn-success support-button" data-toggle="modal" data-target="#supportModal">
    <i class="fa fa-comments"></i>
</button>

<!-- Suporte Modal -->
<div class="modal fade" id="supportModal" tabindex="-1" role="dialog" aria-labelledby="supportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supportModalLabel">Suporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="support-form">
                    <div class="form-group">
                        <label for="support-name">Nome</label>
                        <input type="text" class="form-control" id="support-name" name="support-name" required>
                    </div>
                    <div class="form-group">
                        <label for="support-email">Email</label>
                        <input type="email" class="form-control" id="support-email" name="support-email" required>
                    </div>
                    <div class="form-group">
                        <label for="support-message">Mensagem</label>
                        <textarea class="form-control" id="support-message" name="support-message" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>
