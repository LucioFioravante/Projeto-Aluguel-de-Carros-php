<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/estilos/header.css">
    <link rel="stylesheet" href="view/estilos/recuperarSenha.css">
    <title>AutomóvelJá | Recuperar senha</title>
</head>
<body>

<?php include_once __DIR__ . '/componentes/header.php'; ?>

<main class="auth-page auth-recuperar">
    <section class="auth-card">
        <div class="auth-topo">
            <p class="auth-etiqueta">Segurança</p>
            <h1>Recuperar senha</h1>
            <p class="auth-subtitulo">Confirme seus dados para criar uma nova senha de acesso.</p>
        </div>

        <?php if (!empty($mensagemErro)): ?>
            <div class="auth-alert auth-alert-erro"><?= htmlspecialchars($mensagemErro) ?></div>
        <?php endif; ?>

        <?php if (!empty($mensagemSucesso)): ?>
            <div class="auth-alert auth-alert-sucesso"><?= htmlspecialchars($mensagemSucesso) ?></div>
        <?php endif; ?>

        <form method="post" class="auth-form">
            <label class="auth-campo">
                <span>CPF</span>
                <input type="text" name="cpf" placeholder="Digite seu CPF" required>
            </label>

            <label class="auth-campo">
                <span>Data de nascimento</span>
                <input type="date" name="dataNascimento" required>
            </label>

            <label class="auth-campo">
                <span>Nova senha</span>
                <input type="password" name="novaSenha" placeholder="Digite sua nova senha" required>
            </label>

            <button type="submit" class="auth-botao">Redefinir senha</button>
        </form>

        <div class="auth-links">
            <p>Voltar para o acesso? <a href="?p=fazer-login">Entrar</a></p>
        </div>
    </section>
</main>

</body>
</html>