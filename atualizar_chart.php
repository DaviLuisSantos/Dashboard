<?php
include '../z/config.php';
require_once 'ComponentesVisualizacao.php';
require_once 'querys-dash.php';

$querysComponentes = mudarDias(30, $resultados);

// Receber o ID do componente e as configurações atuais do gráfico
$componenteId = $_POST['id'];

foreach($querysComponentes as $unico){
  if($unico->nome===$componenteId){
    $chartClass = $unico;
    break;
  }
}
if ($chartClass->tipo == 'BOX') {
  $stmt = $dbConn->prepare($chartClass->query);
  $stmt->execute();
  $resultado = $stmt->fetch(PDO::FETCH_OBJ);
} else {
  $stmt = $dbConn->prepare($chartClass->query);
  $stmt->execute();
  $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
  $labels = array();
  $data = array();

  foreach ($resultado as $registro) {
    array_push($labels, $registro->LABELS . " - " . $registro->DATA);
    array_push($data, $registro->DATA);
  }
  $chartAtu = new Chart($chartClass->nome, $chartClass->descricao, $chartClass->tipo, $labels, $data, $chartClass->cor,$chartClass->tempo_refresh);
  $chartHtml = $chartAtu->render();
}

echo  $chartHtml;
?>
