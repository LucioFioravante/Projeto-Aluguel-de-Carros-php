<?php

require_once __DIR__ . "/../model/ComentarioModel.php";
class InicioController {
    public static function exibirInicio($pdo) {
      // Verifica se o formulário de comentário foi enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'comentar') {
            $nome = htmlspecialchars($_POST['nome'] ?? 'Visitante');
            $mensagem = htmlspecialchars($_POST['mensagem'] ?? '');
            
            if (!empty($mensagem)) {
                ComentarioModel::salvar($pdo, $nome, $mensagem);
                
                // Recarrega a página para evitar o reenvio do formulário ao atualizar (F5)
                header("Location: ?p=inicio"); 
                exit;
            }
        }

        // Busca todos os comentários do banco
        $lista_comentarios = ComentarioModel::listarTodos($pdo);

        // Carrega a interface passando a variável $lista_comentarios
        include "./view/inicio.php";
    }
// Função para deletar o comentário
    public static function deletarComentario($pdo) {
        // Trava de segurança: Se não for admin, manda de volta para o início
        if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'admin') {
            header("Location: ?p=inicio");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            ComentarioModel::deletar($pdo, $id);
        }
        header("Location: ?p=inicio");
        exit;
    }

    // Função para editar o comentário
    public static function editarComentario($pdo) {
        if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'admin') {
            header("Location: ?p=inicio");
            exit;
        }

        $id = $_GET['id'] ?? null;

        // Se o formulário de edição foi enviado (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mensagem = htmlspecialchars($_POST['mensagem'] ?? '');
            if ($id && $mensagem) {
                ComentarioModel::atualizar($pdo, $id, $mensagem);
            }
            header("Location: ?p=inicio");
            exit;
        }

        // Se for só para carregar a tela (GET), busca os dados atuais
        $comentario = ComentarioModel::buscarPorId($pdo, $id);
        
        // Se alguém tentar digitar um ID que não existe na URL
        if (!$comentario) {
            header("Location: ?p=inicio");
            exit;
        }

        // Carrega a view de edição
        include "./view/editar-comentario.php";
    }
}
?>