<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/estilos/header.css">
    <link rel="stylesheet" href="view/estilos/veiculos.css">
    <title>Catálogo de Veículos</title>
</head>
<body>

<?php
    include_once __DIR__ . "/componentes/header.php";
?>

<div class="resultados-bar">
    <p class="total">
        <span id="contador"><?=count($veiculos)?></span>
        veículo<span id="plural-s"><?=count($veiculos) !== 1 ? 's' : ''?></span>
        encontrado<span id="plural-s2"><?=count($veiculos) !== 1 ? 's' : ''?></span>
    </p>

    <select class="select-ordem" id="select-ordem">
        <option value="">Ordenar por: Recomendado</option>
        <option value="menor">Menor preço</option>
        <option value="maior">Maior preço</option>
    </select>
</div>

<div class="catalogo-layout">

    <aside class="filtros">
        <h2>Filtros</h2>
        <div class="filtro-grupo">
            <h3>Tipo</h3>
            <div class="filtro-chips" id="chips-tipo">
                <button class="chip ativo" data-filtro="tipo" data-valor="">Todos</button>
                <button class="chip" data-filtro="tipo" data-valor="carro">Carros</button>
                <button class="chip" data-filtro="tipo" data-valor="moto">Motos</button>
            </div>
        </div>

        <div class="filtro-grupo">
            <h3>Categoria</h3>
            <div class="filtro-chips" id="chips-categoria">
                <?php foreach ($categorias as $cat):?>
                    <button class="chip" data-filtro="categoria" data-valor="<?=$cat->categoria?>">
                        <?=$cat->categoria?>
                    </button>
                <?php endforeach?>
            </div>
        </div>
    </aside>

    <main>
        <?php if (empty($veiculos)):?>
            <div class="vazio">
                <p>Nenhum veículo encontrado.</p>
                <p>Tente um filtro diferente ou volte mais tarde.</p>
            </div>
        <?php else:?>

            <div class="veiculos-lista" id="veiculos-lista">
                <?php foreach ($veiculos as $veiculo):
                    $marca = htmlspecialchars($veiculo->marca);
                    $modelo = htmlspecialchars($veiculo->modelo);
                    $ano = htmlspecialchars($veiculo->ano);
                    $cor = htmlspecialchars($veiculo->cor);
                    $tipo = htmlspecialchars($veiculo->tipo);
                    $categoria = htmlspecialchars($veiculo->categoria);
                    $imagem = htmlspecialchars($veiculo->imagem);
                    $quilometros = number_format($veiculo->quilometragem, 0, ',', '.');
                    $preco = number_format($veiculo->preco_diaria, 2, ',', '.');
                    $disponivel = $veiculo->disponivel;
                ?>
                    <article class="card-veiculo"
                        data-tipo="<?=$tipo?>"
                        data-categoria="<?=$categoria?>"
                        data-preco="<?=$veiculo->preco_diaria?>">

                        <div class="card-imagem">
                            <img src="imagens/<?=$imagem?>" alt="<?=$marca?> <?=$modelo?>">
                            <span class="badge-tipo"><?=ucfirst($tipo)?></span>
                        </div>

                        <div class="card-corpo">
                            <h2 class="card-titulo"><?=$marca?> <?=$modelo?></h2>

                            <div class="card-atributos">
                                <span class="attr">&#128198; <?=$ano?></span>
                                <span class="attr">&#127912; <?=$cor?></span>
                                <span class="attr">&#128205; <?=$quilometros?> km</span>
                            </div>

                            <ul class="card-checks">
                                <li>Seguro básico incluído</li>
                                <li>Proteção contra terceiros</li>
                                <li>Suporte 24h</li>
                            </ul>
                        </div>

                        <div class="card-acao">
                            <?php if ($disponivel):?>
                                <span class="card-status-disponivel">Disponível</span>
                            <?php else:?>
                                <span class="card-status-indisponivel">Indisponível</span>
                            <?php endif?>

                            <div class="card-acao-bottom">
                                <div class="card-preco-wrap">
                                    <p class="card-preco-label">Preço por dia</p>
                                    <p class="card-preco">R$ <?=$preco?></p>
                                    <p class="card-preco-info">Cancelamento grátis</p>
                                </div>

                                <?php if ($disponivel):?>
                                    <form method="post" action="?p=alugar">
                                        <input type="hidden" name="csrf_token" value= "<?=$token?>">
                                        <input type="hidden" name="id_veiculo" value="<?=$veiculo->id?>">
                                        <button type="submit" class="btn-alugar">Alugar agora</button>
                                    </form>
                                <?php else:?>
                                    <button class="btn-alugar" disabled style="opacity:0.4; cursor:not-allowed;">
                                        Indisponível
                                    </button>
                                <?php endif?>
                            </div>
                        </div>
                    </article>
                <?php endforeach?>
            </div>

            <div class="vazio" id="msg-vazio" style="display:none;">
                <p>Nenhum veículo encontrado.</p>
                <p>Tente um filtro diferente.</p>
            </div>
        <?php endif?>
    </main>
</div>

<script>
    window.addEventListener('pageshow', function (e) {
        if (e.persisted) {
            window.location.reload();
        }
    });

(function () {
    const lista = document.getElementById('veiculos-lista');
    const msgVazio = document.getElementById('msg-vazio');
    const contador = document.getElementById('contador');
    const pluralS = document.getElementById('plural-s');
    const pluralS2 = document.getElementById('plural-s2');
    const selectOrdem = document.getElementById('select-ordem');

    const filtros = { tipo: '', categoria: '' };

    const todosCards = [...lista.querySelectorAll('.card-veiculo')];

    document.querySelectorAll('.chip').forEach(chip => {
        chip.addEventListener('click', () => {
            const campo = chip.dataset.filtro;
            const valor = chip.dataset.valor;

            filtros[campo] = filtros[campo] === valor ? '' : valor;

            chip.closest('.filtro-chips')
                .querySelectorAll('.chip')
                .forEach(c => c.classList.toggle('ativo', c.dataset.valor === filtros[campo]));

            aplicar();
        });
    });

    selectOrdem.addEventListener('change', aplicar);

    function aplicar() {

        const visiveis = todosCards.filter(card => {
            const tipoOk = !filtros.tipo || card.dataset.tipo === filtros.tipo;
            const categoriaOk = !filtros.categoria || card.dataset.categoria === filtros.categoria;
            return tipoOk && categoriaOk;
        });

        const ordem = selectOrdem.value;
        if (ordem) {
            visiveis.sort((a, b) => {
                const pa = parseFloat(a.dataset.preco);
                const pb = parseFloat(b.dataset.preco);
                return ordem === 'menor' ? pa - pb : pb - pa;
            });
        }

        todosCards.forEach(card => card.style.display = 'none');
        visiveis.forEach(card => {
            card.style.display = '';
            lista.appendChild(card);
        });

        const total = visiveis.length;
        contador.textContent = total;
        const sufixo = total !== 1 ? 's' : '';
        pluralS.textContent = sufixo;
        pluralS2.textContent = sufixo;

        lista.style.display = total ? '' : 'none';
        msgVazio.style.display = total ? 'none' : '';
    }
})();
</script>

</body>
</html>