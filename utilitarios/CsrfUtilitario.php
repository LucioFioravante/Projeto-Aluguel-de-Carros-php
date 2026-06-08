<?php

    class CsrfUtilitario {
        public static function gerarCsrf() {
            if (empty($_SESSION["csrf_token"])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            return $_SESSION["csrf_token"];
        }

        public static function validarCsrf($token) {

            if(is_null($token) || empty($token) || !hash_equals($_SESSION["csrf_token"], $token)) {
                http_response_code(403);
                die('Requisição inválida: token CSRF ausente ou incorreto.');
            }

            $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
        }
    }

?>