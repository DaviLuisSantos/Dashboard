<?php
include '../z/config.php';
require_once 'ComponentesVisualizacao.php';
require_once 'querys-dash.php';

$querysComponentes = $resultados;

$compHtml = __DIR__ . "./resultados/resultados_" . date('Y-n-j') . "_";

// Receber o ID do componente e as configurações atuais do gráfico
$componenteId = $_POST['id'];

foreach ($querysComponentes as $unico) {
  if ($unico->nome === $componenteId) {
    $chartClass = $unico;
    break;
  }
}
if ($chartClass->tipo == 'BOX') {
  $stmt = $dbConn->prepare($chartClass->query);
  $stmt->execute();
  $resultado = $stmt->fetch(PDO::FETCH_OBJ);
  $boxAtu = new Box($chartClass->cor, $resultado->TOTAL, $chartClass->descricao, $chartClass->nome, $chartClass->tempo_refresh);
  $htmlAtu = $boxAtu->render();
} else if(!($chartClass->tipo == 'table')){
  $stmt = $dbConn->prepare($chartClass->query);
  $stmt->execute();
  $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
  $labels = array();
  $data = array();

  foreach ($resultado as $registro) {
    array_push($labels, $registro->LABELS);
    array_push($data, $registro->DATA);
  }
  $chartAtu = new Chart($chartClass->nome, $chartClass->descricao, $chartClass->tipo, $labels, $data, $chartClass->cor, $chartClass->tempo_refresh);
  $htmlAtu = $chartAtu->render();
}
else if($chartClass->tipo == 'table'){
  $stmt = $dbConn->prepare($chartClass->query);
  $stmt->execute();
  $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);

  $chartAtu = new Table($chartClass->cor, $resultado, $chartClass->descricao, $chartClass->nome, $chartClass->tempo_refresh);
  $htmlAtu = $chartAtu->render();
}

echo $htmlAtu;
?>