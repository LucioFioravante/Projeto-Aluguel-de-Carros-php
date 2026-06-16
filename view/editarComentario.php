<link rel="stylesheet" href="view/estilos/inicio.css?v=<?= time() ?>">

<div class="blog-container" style="margin-top: 60px;">
    <h2>Editar Comentário</h2>
    <p style="margin-bottom: 20px; color: var(--cinza-med);">
        Você está editando o comentário de <strong><?= htmlspecialchars($comentario['nome']) ?></strong>.
    </p>

    <form action="?p=editar-comentario&id=<?= $comentario['id'] ?>" method="POST" class="form-comentario">
        <div class="form-group">
            <textarea name="mensagem" required rows="5"><?= htmlspecialchars($comentario['mensagem']) ?></textarea>
        </div>
        <div style="display: flex; gap: 15px;">
            <button type="submit" class="btn-login">Salvar Alterações</button>
            <a href="?p=inicio" class="btn-login" style="background-color: var(--cinza-med); color: white; text-align: center;">Cancelar</a>
        </div>
    </form>
</div>