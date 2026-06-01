<?php 

    session_start();

    // var_dump($_GET);
    $url = $_GET['p'] ?? null;

    require "./banco.php";    
    require "./controller/LoginController.php";
    require "./controller/CadastroController.php";
    require "./controller/RecuperarSenhaController.php";
    require "./controller/LogoutController.php";
    require "./controller/AluguelController.php";
    require "./controller/ContatoController.php";
    require "./controller/VeiculoController.php";
    require_once __DIR__ . "/utilitarios/CsrfUtilitario.php";

    include "./view/componentes/header.php";

    if($url == 'fazer-login'){
        LoginController::fazerLogin();
    }
    else if($url == 'cadastrar'){
        CadastroController::fazerCadastro();
    }
    else if($url == 'recuperar-senha'){
        RecuperarSenhaController::recuperarSenha();
    }
    else if($url == "veiculos") {
        VeiculoController::catalogo($pdo);
    }
    else if($url == 'logout'){
        LogoutController::logout();
    }
    else {
        echo "Página não encontrada";
    }

?>
