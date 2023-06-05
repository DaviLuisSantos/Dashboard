<?php
include '../z/config.php';

require_once 'ComponentesVisualizacao.php';

$sql = "SELECT ID,NOME, DESCRICAO, COR, ORDEM_EXIB, ID_MOD_DASHBOARD,TEMPO_REFRESH, CAST(SQL_QUERY AS VARCHAR(3200) CHARACTER SET UTF8) AS QUERY FROM PF_QUERY";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$registros = $stmt->fetchAll(PDO::FETCH_OBJ);

// Função de comparação para ordenar os registros por ordem_exib
function comparar_por_ordem_exib($registro1, $registro2) {
  return $registro1->ORDEM_EXIB - $registro2->ORDEM_EXIB;
}

usort($registros, 'comparar_por_ordem_exib');

// Array para armazenar os resultados da query
$resultados = array();

foreach ($registros as $registro) {
  // Cria um objeto stdClass com os dados do registro
  $obj = new stdClass();
  $obj->id = $registro->ID;
  $obj->nome = $registro->NOME;
  $obj->descricao = $registro->DESCRICAO;
  $obj->cor = $registro->COR;
  $obj->ordem_exib = $registro->ORDEM_EXIB;
  $obj->tempo_refresh = $registro->TEMPO_REFRESH;
  $obj->id_mod_dashboard = $registro->ID_MOD_DASHBOARD;
  $obj->query = $registro->QUERY;
  $sql = "SELECT * FROM PF_MOD_DASHBOARD WHERE TIPO_MOD_DASHBOARD = $obj->id_mod_dashboard";
  $stmt = $dbConn->prepare($sql);
  $stmt->execute();
  $TIPO_mod = $stmt->fetch(PDO::FETCH_OBJ);
  switch ($TIPO_mod->NOME) {
  case 'PIZZA':
    $obj->tipo='pie';
    break;
    case 'LABEL':
      $obj->tipo='BOX';
      break;
      case 'BARRA':
        $obj->tipo='bar';
        break;
        case 'LINHA':
          $obj->tipo='line';
          break;
  }
  
  $resultados[] = $obj;
}

$sql = "SELECT * FROM PF_MOD_DASHBOARD";
$stmt2 = $dbConn->prepare($sql);
$stmt2->execute();
$registros = $stmt2->fetchAll(PDO::FETCH_OBJ);
$graficos = array();

foreach ($registros as $registro) {
  $objt = new stdClass();
  $objt->id = $registro->ID;
  $objt->nome = $registro->NOME;
  $objt->descricao = $registro->DESCRICAO;
  $objt->cor = $registro->TIPO_MOD_DASHBOARD;

  $graficos[] = $objt;
}


function mudarDias($dias, $resultados){
  foreach ($resultados as $resultado) {
    $query = str_replace(':DIAS', $dias, $resultado->query);
    $resultado->query = $query;
  };
  return $resultados;
}
function getGraf($graficos){
return $graficos;
}

function tipoGrafico($dbConn){
  $sql = "SELECT NOME, TIPO_MOD_DASHBOARD, FROM PF_MOD_DASHBOARD";
  $stmt = $dbConn->prepare($sql);
  $stmt->execute();
  $registros = $stmt->fetchAll(PDO::FETCH_OBJ);
}

?>
