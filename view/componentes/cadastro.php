<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/estilos/header.css">
    <link rel="stylesheet" href="view/estilos/cadastro.css">
    <title>CarroJá | Cadastro</title>
</head>
<body>

<?php include_once __DIR__ . '/header.php'; ?>

<main class="auth-page auth-cadastro">
    <section class="auth-card auth-card-longo">
        <div class="auth-topo">
            <p class="auth-etiqueta">Cadastro</p>
            <h1>Criar conta</h1>
            <p class="auth-subtitulo">Preencha seus dados para acessar o sistema e reservar veículos.</p>
        </div>

        <form method="post" class="auth-form auth-form-grid">
            <label class="auth-campo">
                <span>Usuário</span>
                <input type="text" name="nome" placeholder="Seu nome de usuário" required>
            </label>

            <label class="auth-campo">
                <span>E-mail</span>
                <input type="email" name="mail" placeholder="seuemail@exemplo.com" required>
            </label>

            <label class="auth-campo">
                <span>CPF</span>
                <input type="text" name="cpf" placeholder="000.000.000-00" required>
            </label>

            <label class="auth-campo">
                <span>Data de nascimento</span>
                <input type="date" name="dataNascimento" required>
            </label>

            <label class="auth-campo auth-campo-full">
                <span>Telefone</span>
                <input type="text" name="telefone" placeholder="(00) 00000-0000" required>
            </label>

            <label class="auth-campo auth-campo-full">
                <span>Senha</span>
                <input type="password" name="senha" placeholder="Crie uma senha segura" required>
            </label>

            <button type="submit" class="auth-botao auth-botao-full">Criar cadastro</button>
        </form>

        <div class="auth-links auth-links-centralizados">
            <p>Já tem uma conta? <a href="?p=fazer-login">Entrar agora</a></p>
        </div>
    </section>
</main>

</body>
</html>