
<form method="post">
    Usuário: <input type="text" name="usuario"><br><br>
    Senha: <input type="text" name="senha"><br><br>
    <input type="submit" value="Entrar">
</form>


<?php 
    include "bancoDeDados/banco.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $usuario = $_POST['usuario'] ?? null;
        $senha = $_POST['senha'] ?? null;

        if(is_null($usuario) || is_null($senha)){
            echo "Erro - usuario ou senha";
        } else {
            if(fazerLogin($usuario, $senha)){
                session_start(); 
                $_SESSION['usuario'] = $usuario;
                header('location: index.php');
                exit();
            } else {
                return false;
            } 
        }
    }
?>