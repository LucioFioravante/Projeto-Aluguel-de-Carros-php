<?php 

     //      new mysqli('host', 'usuario', 'senha', 'nome banco');
    $banco = new mysqli('localhost:3306', 'root', '', 'aluguel-carros');

    function addTarefa($tarefa, $idUsuario){
        global $banco;
        $banco->query("INSERT INTO tarefas (id, idUsuario, nome) VALUES (null, '$idUsuario', '$tarefa');");
    }

    function fazerLogin($usuario, $senha){

        global $banco;
        $resp = $banco->query("SELECT * FROM usuarios WHERE nome='$usuario';");

        if($resp->num_rows > 0){
            $usu = $resp->fetch_object();
            if(password_verify($senha, $usu->senha)){
                    session_start();
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['id'] = $usu->id;
                    return true;
                } else {
                    echo "Erro - Senha";
                    return false;
            } 
        } else {
           return false;
        }
    }

?>