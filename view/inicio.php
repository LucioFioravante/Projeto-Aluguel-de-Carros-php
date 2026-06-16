<link rel="stylesheet" href="view/estilos/header.css">

<link rel="stylesheet" href="view/estilos/inicio.css?v=<?= time() ?>">

<div class="hero-container">
    <div class="hero-text">
        <h1>O carro ideal para a sua próxima jornada</h1>
        <p>A <strong>Automóvel Já</strong> oferece a melhor frota do mercado. Seja para uma viagem de negócios, um passeio no fim de semana ou uso diário, temos o veículo certo com o melhor preço e sem burocracia.</p>
        
        <a href="?p=veiculos" class="btn-login">Ver Veículos Disponíveis</a>
    </div>
    <div class="hero-image">
        <img src="imagens/automovel-ja.jpg" alt="Carro em destaque">
    </div>
</div>

<div class="blog-container">
    <h2>Deixe seu Comentário</h2>
    
    <form action="?p=inicio" method="POST" class="form-comentario">
        <input type="hidden" name="acao" value="comentar">
        
        <div class="form-group">
            <input type="text" name="nome" placeholder="Seu nome" required>
        </div>
        <div class="form-group">
            <textarea name="mensagem" placeholder="O que você achou dos nossos carros?" required rows="3"></textarea>
        </div>
        <button type="submit" class="btn-login">Enviar Comentário</button>
    </form>

    <div class="lista-comentarios">
        <h3>Comentários Recentes</h3>
        
        <?php if (!empty($lista_comentarios)): ?>
            <?php foreach ($lista_comentarios as $comentario): ?>
                <div class="comentario-card">
                    <div class="comentario-header">
                        <strong><?= htmlspecialchars($comentario['nome']) ?></strong>
                        <span class="data"><?= date('d/m/Y H:i', strtotime($comentario['data_criacao'])) ?></span>
                    </div>
                    <p><?= nl2br(htmlspecialchars($comentario['mensagem'])) ?></p>
                    
                    <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 'admin'): ?>
                        <div class="acoes-crud">
                            <a href="?p=editar-comentario&id=<?= $comentario['id'] ?>" class="btn-crud btn-edit">Editar</a>
                            <a href="?p=deletar-comentario&id=<?= $comentario['id'] ?>" class="btn-crud btn-del" onclick="return confirm('Tem certeza que deseja apagar este comentário?');">Apagar</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Seja o primeiro a comentar!</p>
        <?php endif; ?>
    </div>
</div>