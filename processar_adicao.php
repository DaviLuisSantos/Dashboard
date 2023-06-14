<?php
include '../z/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtém os dados do formulário
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $cor = $_POST['cor'];
    $ordem_exib = $_POST['ordem_exib'];
    $tempo_refresh = $_POST['tempo_refresh'];
    $type = $_POST['type'];
    $query = $_POST['query'];

    // Insere o novo gráfico na tabela
    $query2 = "INSERT INTO PF_QUERY ( NOME, DESCRICAO, COR, ORDEM_EXIB, ID_MOD_DASHBOARD, TEMPO_REFRESH, SQL_QUERY) 
VALUES ( :NOME, :DESCRICAO, :COR, :ORDEM_EXIB, :ID_MOD_DASHBOARD, :TEMPO_REFRESH, :SQL_QUERY)";
    $stmt2 = $dbConn->prepare($query2);
    if ($stmt2 === false) {
        $error = $dbConn->errorInfo();
        echo '<script>alert("Erro ao preparar a consulta: ' . $error[2] . '");</script>';
        exit();
    }
    

    $stmt2->bindParam(':NOME', $descricao);
    $stmt2->bindParam(':DESCRICAO', $titulo);
    $stmt2->bindParam(':COR', $cor);
    $stmt2->bindParam(':ORDEM_EXIB', $ordem_exib);
    $stmt2->bindParam(':ID_MOD_DASHBOARD', $type);
    $stmt2->bindParam(':TEMPO_REFRESH', $tempo_refresh);
    $stmt2->bindParam(':SQL_QUERY', $query);
    $success = $stmt2->execute();


    // Verifica se a inserção foi bem-sucedida
    if ($success) {
        // Gráfico criado com sucesso
        echo '<script>alert("Gráfico criado");</script>';
    } else {
        // Erro ao criar o gráfico
        $error = $stmt2->errorInfo();
        echo '<script>alert("Erro ao criar o gráfico: ' . $error[2] . '");</script>';
    }


    // Redireciona de volta para a página de configuração
    echo '<script>window.location.href = "configuracao_dash.php";</script>';
    exit();
} else {
    // Se o formulário não foi enviado, redirecione para a página de configuração
    header("Location: davizaun.php");
    exit();
}
?>