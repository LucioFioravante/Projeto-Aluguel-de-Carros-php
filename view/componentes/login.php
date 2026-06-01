<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/estilos/header.css">
    <link rel="stylesheet" href="view/estilos/login.css">
    <title>CarroJá | Login</title>
</head>
<body>

<?php include_once __DIR__ . '/header.php'; ?>

<main class="auth-page auth-login">
    <section class="auth-card">
        <div class="auth-topo">
            <p class="auth-etiqueta">Acesso</p>
            <h1>Fazer Login</h1>
            <p class="auth-subtitulo">Entre com sua conta para navegar e reservar veículos.</p>
        </div>

        <form method="post" class="auth-form">
            <label class="auth-campo">
                <span>Usuário</span>
                <input type="text" name="nome" placeholder="Digite seu usuário" required>
            </label>

            <label class="auth-campo">
                <span>Senha</span>
                <input type="password" name="senha" placeholder="Digite sua senha" required>
            </label>

            <button type="submit" class="auth-botao">Entrar</button>
        </form>

        <div class="auth-links">
            <p>Não possui conta? <a href="?p=cadastrar">Criar cadastro</a></p>
            <p>Esqueceu sua senha? <a href="?p=recuperar-senha">Recuperar acesso</a></p>
        </div>
    </section>
</main>

</body>
</html>

