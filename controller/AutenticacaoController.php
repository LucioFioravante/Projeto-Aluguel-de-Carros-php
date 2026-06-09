<?php 

    class AutenticacaoController {

        public static function fazerLogin() {
            include __DIR__ . '/../model/UsuarioModel.php';
            include __DIR__ . '/../funcoes.php';

            $mensagemErro = null;
        
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $usuario = trim($_POST['nome'] ?? '');
                $senha = $_POST['senha'] ?? '';
                
                if(validaCamposLogin($usuario, $senha)){
                    $mensagemErro = 'Preencha todos os campos.';
                } else {
                    if(fazerLogin($usuario, $senha)){
                        session_start();
                        $_SESSION['usuario'] = $usuario;
                        header('location: ?p=home');
                        exit;
                    } else {
                        $mensagemErro = 'Usuário ou senha inválidos.';
                    }
                }
            }
            include __DIR__ . '/../view/login.php';
        }


        public static function fazerCadastro() {
            include __DIR__ . '/../model/UsuarioModel.php';
            include __DIR__ . '/../funcoes.php';

            $mensagemErro = null;
            $mensagemSucesso = null;
        
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $usuario = trim($_POST['nome'] ?? '');
                $cpf = trim($_POST['cpf'] ?? '');
                $dataNascimento = trim($_POST['dataNascimento'] ?? '');
                $mail = trim($_POST['mail'] ?? '');
                $telefone = trim($_POST['telefone'] ?? '');
                $senha = $_POST['senha'] ?? '';
                
                if(validaCamposCadastro($usuario, $cpf, $dataNascimento, $mail, $telefone, $senha)){
                    global $errosCadastro;
            
                    if(!empty($errosCadastro)){
                        $mensagemErro = implode(' | ', $errosCadastro);
                    } else {
                        $mensagemErro = 'Preencha todos os campos.';
                    }
                } else {
                    if(addUsuario($usuario, $cpf, $dataNascimento, $mail, $telefone, password_hash($senha, PASSWORD_DEFAULT))){
                        $mensagemSucesso = 'Cadastro realizado com sucesso. Faça login para continuar.';
                    } else {
                        $mensagemErro = 'Não foi possível concluir o cadastro.';
                    }
                }
            }
            include __DIR__ . '/../view/cadastro.php';
        }


        public static function recuperarSenha() {
            include __DIR__ . '/../model/UsuarioModel.php';
            include __DIR__ . '/../funcoes.php';

            $mensagemErro = null;
            $mensagemSucesso = null;
        
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $cpf = trim($_POST['cpf'] ?? '');
                $dataNascimento = trim($_POST['dataNascimento'] ?? '');
                $novaSenha = $_POST['novaSenha'] ?? '';
                
                if(validaCamposRecuperarSenha($cpf, $dataNascimento, $novaSenha)){
                    $mensagemErro = 'Preencha todos os campos.';
                } else {
                    if(recuperarSenha($cpf, $dataNascimento, $novaSenha)){
                        $mensagemSucesso = 'Nova senha cadastrada com sucesso.';
                    } else {
                        $mensagemErro = 'CPF ou data de nascimento incorretos.';
                    }
                }
            }
            include __DIR__ . '/../view/recuperarSenha.php';
        }


        public static function logout() {

            unset($_SESSION["logado"]);

            session_destroy();
            header("Location: ?p=fazer-login");
            exit();
        }
        
    }

?>