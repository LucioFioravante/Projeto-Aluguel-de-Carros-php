<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/estilos/header.css">
    <link rel="stylesheet" href="view/estilos/formularioAluguel.css">
    <title>Alugar Veículo</title>
</head>
<body>

<?php
    include_once __DIR__ . "/componentes/header.php";

    $marca      = htmlspecialchars($veiculo->marca);
    $modelo     = htmlspecialchars($veiculo->modelo);
    $ano        = htmlspecialchars($veiculo->ano);
    $cor        = htmlspecialchars($veiculo->cor);
    $tipo       = htmlspecialchars($veiculo->tipo);
    $categoria  = htmlspecialchars($veiculo->categoria);
    $imagem     = htmlspecialchars($veiculo->imagem);
    $quilometros = number_format($veiculo->quilometragem, 0, ',', '.');
    $preco      = number_format($veiculo->preco_diaria, 2, ',', '.');
    $precoBruto = $veiculo->preco_diaria;
?>

<div class="pagina-aluguel">

    <div class="breadcrumb">
        <a href="?p=veiculos">&#8592; Voltar ao catálogo</a>
    </div>

    <h1 class="pagina-titulo">Confirme seu aluguel</h1>

    <div class="aluguel-layout">
        <div class="card-resumo">
            <div class="card-resumo-imagem">
                <img src="imagens/<?= $imagem ?>" alt="<?= $marca ?> <?= $modelo ?>">
                <span class="badge-tipo"><?= ucfirst($tipo) ?></span>
            </div>

            <div class="card-resumo-corpo">
                <h2 class="card-resumo-titulo"><?= $marca ?> <?= $modelo ?></h2>

                <div class="card-atributos">
                    <span class="attr">&#128198; <?= $ano ?></span>
                    <span class="attr">&#127912; <?= $cor ?></span>
                    <span class="attr">&#128205; <?= $quilometros ?> km</span>
                    <span class="attr">&#127959; <?= ucfirst($categoria) ?></span>
                </div>

                <div class="card-resumo-preco">
                    <p class="preco-label">Preço por dia</p>
                    <p class="preco-valor">R$ <?= $preco ?></p>
                </div>

                <ul class="card-checks">
                    <li>Seguro básico incluído</li>
                    <li>Proteção contra terceiros</li>
                    <li>Suporte 24h</li>
                    <li>Cancelamento grátis</li>
                </ul>
            </div>
        </div>
        <div class="form-aluguel-wrap">
            <h2 class="form-titulo">Escolha o período</h2>

            <?php if (!empty($erro)): ?>
                <div class="erro-mensagem">
                    <?= htmlspecialchars($erro) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="?p=confirmar-aluguel" class="form-aluguel">
                <input type="hidden" name="csrf_token" value="<?= $token ?>">
                <input type="hidden" name="id_veiculo" value="<?=$veiculo->id?>">
                <div class="campo-grupo">
                    <label for="data_inicio">Data de retirada</label>
                    <input type="date" id="data_inicio" name="data_inicio" required>
                </div>

                <div class="campo-grupo">
                    <label for="data_fim">Data de devolução</label>
                    <input type="date" id="data_fim" name="data_fim" required>
                </div>

                <div class="resumo-total" id="resumo-total" style="display:none;">
                    <div class="resumo-linha">
                        <span id="resumo-dias-label">0 dias × R$ <?= $preco ?></span>
                        <span id="resumo-subtotal">R$ 0,00</span>
                    </div>
                    <div class="resumo-linha resumo-total-final">
                        <span>Total</span>
                        <span id="resumo-total-valor">R$ 0,00</span>
                    </div>
                    <input type="hidden" name="total" id="input-total" value="0">
                </div>

                <button type="submit" class="btn-confirmar">
                    Confirmar aluguel
                </button>
            </form>
        </div>

    </div>
</div>

<script>
(function () {
    const precoDiaria  = <?= $precoBruto ?>;
    const inputInicio  = document.getElementById('data_inicio');
    const inputFim     = document.getElementById('data_fim');
    const resumoBox    = document.getElementById('resumo-total');
    const diasLabel    = document.getElementById('resumo-dias-label');
    const subtotal     = document.getElementById('resumo-subtotal');
    const totalValor   = document.getElementById('resumo-total-valor');

    const fmt = v => v.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    function exibirResumo() {
        if (!inputInicio.value || !inputFim.value) {
            resumoBox.style.display = 'none';
            return;
        }

        const dias  = Math.ceil((new Date(inputFim.value) - new Date(inputInicio.value)) / (1000 * 60 * 60 * 24));
        const total = dias * precoDiaria;

        diasLabel.textContent  = `${dias} dia${dias > 1 ? 's' : ''} × R$ ${fmt(precoDiaria)}`;
        subtotal.textContent   = `R$ ${fmt(total)}`;
        totalValor.textContent = `R$ ${fmt(total)}`;

        resumoBox.style.display = '';
    }

    inputInicio.addEventListener('blur', exibirResumo);
    inputFim.addEventListener('blur', exibirResumo);
})();
</script>

</body>
</html>