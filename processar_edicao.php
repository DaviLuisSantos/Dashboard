<?php
include '../z/config.php';
require_once 'querys-dash.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se os campos obrigatórios estão presentes
    if (isset($_POST['grafico_id'], $_POST['titulo'], $_POST['descricao'], $_POST['cor'], $_POST['ordem_exib'], $_POST['tempo_refresh'], $_POST['type'], $_POST['query'])) {
        $grafico_id = $_POST['grafico_id'];
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $cor = $_POST['cor'];
        $ordem_exib = $_POST['ordem_exib'];
        $tempo_refresh = $_POST['tempo_refresh'];
        $type = $_POST['type'];
        $query = $_POST['query'];

        // Aqui você deve adicionar a lógica para atualizar os dados do gráfico no banco de dados, utilizando a variável $grafico_id como referência

        // Exemplo de atualização no banco de dados utilizando PDO
        $sql = "UPDATE PF_QUERY SET NOME = :titulo, DESCRICAO = :descricao, COR = :cor, ORDEM_EXIB = :ordem_exib, TEMPO_REFRESH = :tempo_refresh, ID_MOD_DASHBOARD = :type, SQL_QUERY = :query WHERE ID = :grafico_id";
        
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':cor', $cor);
        $stmt->bindParam(':ordem_exib', $ordem_exib);
        $stmt->bindParam(':tempo_refresh', $tempo_refresh);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':query', $query);
        $stmt->bindParam(':grafico_id', $grafico_id);
        
        if ($stmt->execute()) {
            echo "Gráfico atualizado com sucesso.";
            header("Location: starter.php");
exit();

            // Redirecionar para a página de configuração ou exibir uma mensagem de sucesso
        } else {
            echo "Erro ao atualizar o gráfico: " . $stmt->errorInfo()[2];
        }
    } else {
        echo "Campos obrigatórios não estão preenchidos.";
    }
} else {
    echo "Método inválido.";
}
