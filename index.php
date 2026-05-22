<?php
    session_start();
    
    $estaLogado = $_SESSION["logado"] ?? false;

    if(!$estaLogado){
        header("Location: login.php");
    }    
    
    $usuario = $_SESSION["usuario"] ?? null;

    $pageTitle = 'CarroJá';
    include "componentes/head.php";
    include "componentes/header.php";

?>