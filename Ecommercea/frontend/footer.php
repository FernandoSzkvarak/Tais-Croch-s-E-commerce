<?php
// Verifica se estamos na raiz ou em um subdiretório
$basePath = (basename($_SERVER['SCRIPT_NAME']) == 'index.php') ? '.' : '..';
?>

<!-- footer.php -->
<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2024 Tais Crochês. Todos os direitos reservados.</p>
    <p>
        <a href="<?php echo $basePath; ?>/sobre.php" class="text-white">Sobre Nós</a> |
        <a href="<?php echo $basePath; ?>/contato.php" class="text-white">Contato</a> |
        <a href="<?php echo $basePath; ?>/p_privacidade.php" class="text-white">Política de Privacidade</a>
    </p>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
