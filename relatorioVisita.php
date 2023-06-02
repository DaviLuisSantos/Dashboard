<?php
include '../z/config.php';
require_once 'ComponentesVisualizacao.php';
require_once 'querys-dash.php';


$dias = 10;
$filename = __DIR__ . "./resultados/resultados_" . date('Y-m-d') . "_" . $dias . "dias.html";
$compHtml=__DIR__ . "./resultados/resultados_" . date('Y-n-j') . "_";



$querysComponentes = mudarDias($dias, $resultados);
?>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <div class="container-fluid">
    <div class="row" id="dashboard">
      <?php
      foreach ($querysComponentes as $index) {
        
        if ($index->tipo == 'BOX') {
          if (file_exists($compHtml.$index->nome.'.html')){
            $html = file_get_contents($compHtml.$index->nome.'.html');
            echo '<div class="col-lg-4 col-6" id="Chart-' . $index->nome . '">' . $html . '</div>';
          }
          else if(!(file_exists($compHtml.$index->nome.'.html'))){
          $stmt = $dbConn->prepare($index->query);
          $stmt->execute();
          $resultado = $stmt->fetch(PDO::FETCH_OBJ);
          $box = new Box($index->cor, $resultado->TOTAL, $index->descricao,$index->nome,$index->tempo_refresh);
          $boxHtml = $box->render();
          echo '<div class="col-lg-4 col-6" id="Chart-' . $index->nome . '">' . $boxHtml . '</div>';
          }
          }
          else{
            if (file_exists($compHtml.$index->nome.'.html')){
              $html = file_get_contents($compHtml.$index->nome.'.html');
              echo '<div class="col-lg-6" id="Chart-' . $index->nome . '">' . $html . '</div>';
            }
            else if(!(file_exists($compHtml.$index->nome.'.html'))){
              $stmt = $dbConn->prepare($index->query);
              $stmt->execute();
              $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
              $labels = array();
              $data = array();
    
              foreach ($resultado as $registro) {
                array_push($labels, $registro->LABELS);
                array_push($data, $registro->DATA);
              }
              $chart = new Chart($index->nome, $index->descricao, $index->tipo, $labels, $data, $index->cor, $index->tempo_refresh);
              $chartHtml = $chart->render();
              echo '<div class="col-lg-6" id="Chart-' . $index->nome . '">' . $chartHtml . '</div>';
              }
          }
          
        }
      ?>
    </div>

    <!-- /.card-body -->
  </div>
  <!--<button type="button" class="btn btn-block bg-gradient-success btn-lg" id="gerarRelatorioBtn">Relatorio
    Completo</button>-->


  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>


  <script>

function getCurrentDate() {
  var today = new Date();
  var year = today.getFullYear();
  var month = (today.getMonth() + 1).toString().padStart(2, '0');
  var day = today.getDate().toString().padStart(2, '0');

  return year + '-' + month + '-' + day;
}

    function atualizarChart(id) {
  // Fazer uma requisição AJAX para buscar as informações atualizadas do banco de dados
  $.ajax({
    url: 'atualizar_chart.php',
    type: 'POST',
    data: { id: id },
    dataType: 'html',
    success: function (result) {
      // Atualizar o conteúdo do componente CHART com as informações atualizadas
      $('#Chart-' + id).html(result);

      // Atualizar o conteúdo do arquivo HTML, se necessário
      var filename = 'resultados/resultados_' + getCurrentDate() + '_' + id + '.html';
      $.post('salvar_html.php', { filename: filename, html: result });
    },
    error: function () {
      console.log('Erro ao atualizar o componente CHART ' + id);
    }
  });
}

function getCurrentDate() {
  var date = new Date();
  var year = date.getFullYear();
  var month = date.getMonth() + 1;
  var day = date.getDate();

  return year + '-' + month + '-' + day;
}
  </script>
    <style>
  .chart-canvas {
    min-height: 200px;
    height: 200px;
    max-height: 200px;
    width: 100%;
  }

  @media (min-width: 768px) {
    .chart-canvas {
      min-height: 350px;
      height: 350px;
      max-height: 350px;
    }
  }
</style>
  <?php
  $html = ob_get_clean(); // Obter o conteúdo do buffer de saída e limpar o buffer
  file_put_contents($filename, $html); // Salvar o HTML em um arquivo
  echo $html; // Exibir o HTML para o usuário

?>
