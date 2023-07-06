<?php
include '../z/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $grafico_id = $_POST['grafico_id'];

    $query = "DELETE FROM PF_QUERY WHERE ID = $grafico_id";
    $stmt = $dbConn->prepare($query);
    $success= $stmt->execute();

    // Verifica se a exclusão foi bem-sucedida
    if ($success) {
        // Gráfico excluido com sucesso
        echo '<script>alert("Gráfico excluido");</script>';
    } else {
        // Erro ao excluir o gráfico
        $error = $stmt2->errorInfo();
        echo '<script>alert("Erro ao excluir o gráfico: ' . $error[2] . '");</script>';
    }


    // Redireciona de volta para a página de configuração
    echo '<script>window.location.href = "starter.php";</script>';
    exit();
} else {
    // Se o formulário não foi enviado, redirecione para a página de configuração
    header("Location: davizaun.php");
    exit();
}
?>