<?php
class ComentarioModel {
    
    public static function listarTodos($pdo) {
        $sql = "SELECT * FROM comentarios_blog ORDER BY data_criacao DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function salvar($pdo, $nome, $mensagem) {
        $sql = "INSERT INTO comentarios_blog (nome, mensagem) VALUES (:nome, :mensagem)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':mensagem', $mensagem);
        return $stmt->execute();
    }


    // Método para buscar os dados de 1 comentário específico (Read by ID)
    public static function buscarPorId($pdo, $id) {
        $sql = "SELECT * FROM comentarios_blog WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método UPDATE
    public static function atualizar($pdo, $id, $mensagem) {
        $sql = "UPDATE comentarios_blog SET mensagem = :mensagem WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Método DELETE
    public static function deletar($pdo, $id) {
        $sql = "DELETE FROM comentarios_blog WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>