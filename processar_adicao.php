<?php
// Obtém o ID mais alto na tabela de gráficos existentes
$query = "SELECT MAX(id) AS max_id FROM tabela_graficos";
$resultado = mysqli_query($conexao, $query);
$row = mysqli_fetch_assoc($resultado);
$proximo_id = $row['max_id'] + 1;

// Obtém os dados do formulário
$titulo = $_POST['titulo'];
// Obtenha outros campos do formulário, se houver

// Insere o novo gráfico na tabela
$query = "INSERT INTO PF_QUERY (id, titulo) VALUES ('$proximo_id', '$titulo')";
// Execute a query para inserir os dados na tabela

// Redireciona de volta para a página de configuração
header("Location: pagina-de-configuracao.php");
exit();
?>
