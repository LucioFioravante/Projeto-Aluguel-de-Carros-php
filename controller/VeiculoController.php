<?php

    require_once __DIR__ . "/../model/VeiculoModel.php";

    class VeiculoController {
        public static function catalogo($pdo) {

            $veiculos = VeiculoModel::listarVeiculos($pdo);

            $token = CsrfUtilitario::gerarCsrf();

            $categorias = VeiculoModel::listarCategorias($pdo);
            include_once __DIR__ . "/../view/veiculos.php";
        }
    }

?>