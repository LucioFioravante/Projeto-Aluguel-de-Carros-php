<?php

    require_once __DIR__ . "/../model/AluguelModel.php";
    require_once __DIR__ . "/../model/VeiculoModel.php";

    class AluguelController {
        public static function formularioAluguel($pdo) {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                if(empty($_SESSION['usuario'])) {
                    header('Location: ?p=fazer-login');
                    exit;
                }

                $token = $_POST['csrf_token'] ?? null;

                CsrfUtilitario::validarCsrf($token);

                $id_veiculo = $_POST['id_veiculo'] ?? null;

                if(empty($id_veiculo) || is_null($id_veiculo)) {
                    header('Location: ?p=veiculos');
                    exit;
                }

                $veiculo = VeiculoModel::buscarVeiculoPorId($pdo, $id_veiculo);
                if (empty($veiculo) || is_null($veiculo) || !$veiculo->disponivel) {
                    header('Location: ?p=veiculos');
                    exit;
                }

                $erro = $_SESSION['erro_aluguel'] ?? null;
                unset($_SESSION['erro_aluguel']);
                $token = CsrfUtilitario::gerarCsrf();
                include_once __DIR__ . '/../view/formularioAluguel.php';

            } else {
                header("Location: ?p=veiculos");
                exit;
            }
        }

        public static function confirmarAluguel($pdo) {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                if(empty($_SESSION['usuario'])) {
                    header('Location: ?p=fazer-login');
                    exit;
                }

                $token = $_POST['csrf_token'] ?? null;

                CsrfUtilitario::validarCsrf($token);

                $id_veiculo = $_POST['id_veiculo'] ?? null;

                if(empty($id_veiculo) || is_null($id_veiculo)) {
                    header('Location: ?p=veiculos');
                    exit;
                }

                $veiculo = VeiculoModel::buscarVeiculoPorId($pdo, $id_veiculo);

                if(empty($veiculo) || !$veiculo->disponivel) {
                    header('Location: ?p=veiculos');
                    exit;
                }

                $data_inicio = $_POST['data_inicio'] ?? null;
                $data_fim = $_POST['data_fim'] ?? null;

                if(is_null($data_inicio) || is_null($data_fim)) {
                    header('Location: ?p=veiculos');    
                    exit;                
                }

                if($data_inicio < date('Y-m-d') || $data_fim <= $data_inicio) {
                    $erro = 'Datas inválidas. A retirada deve ser hoje ou depois, e a devolução deve ser após a retirada.';
                    $token = CsrfUtilitario::gerarCsrf();
                    include_once __DIR__ . '/../view/formularioAluguel.php';
                    return;
                }

                $dias = (int) round((strtotime($data_fim) - strtotime($data_inicio)) / 86400);
                $total = $veiculo->preco_diaria * $dias;

                $dados = [
                    'usuario_id'  => $_SESSION['id'],
                    'veiculo_id'  => $id_veiculo,
                    'data_inicio' => $data_inicio,
                    'data_fim'    => $data_fim,
                    'total'       => $total,
                    'status'      => 'pendente'
                ];

                AluguelModel::inserirAluguel($pdo, $dados);
                VeiculoModel::atualizarDisponibilidade($pdo, $id_veiculo, 0);
                header('Location: ?p=meus-Alugueis');
                exit;
                
            } else {
                header('Location: ?p=veiculos');
                exit;
            }
        }
    }

?>