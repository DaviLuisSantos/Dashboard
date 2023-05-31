<?php
include '../z/config.php';
require_once 'ComponentesVisualizacao.php';
require_once 'querys-dash.php';


$dias = 1;
$dias = $_POST["dias"];
$filename = __DIR__ . "./resultados/resultados_" . date('Y-m-d') . "_" . $dias . "dias.html";
$compHtml=__DIR__ . "./resultados/resultados_" . date('Y-n-d') . "_";



$querysComponentes = mudarDias($dias, $resultados);
if (file_exists($filename)) {
  // Se o arquivo existir, basta lê-lo e mostrá-lo ao usuário
  $html = file_get_contents($filename);
  echo $html;
} else {
  // Se o arquivo não existir, gerar o HTML e salvá-lo em um arquivo
  ob_start(); // Iniciar o buffer de saída
  ?>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <div class="container-fluid">
    <div class="row">
      <?php
      foreach ($querysComponentes as $index) {
        if ($index->tipo == 'BOX') {
          $stmt = $dbConn->prepare($index->query);
          $stmt->execute();
          $resultado = $stmt->fetch(PDO::FETCH_OBJ);
          $box = new Box($index->cor, $resultado->TOTAL, $index->descricao);
          $boxHtml = $box->render();
          echo $boxHtml;
        } else {
          if (file_exists($compHtml.$index->nome.'.html')){
            $html = file_get_contents($compHtml.$index->nome.'.html');
            echo $html;
          }
          else{
          $stmt = $dbConn->prepare($index->query);
          $stmt->execute();
          $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
          $labels = array();
          $data = array();

          foreach ($resultado as $registro) {
            array_push($labels, $registro->LABELS . " - " . $registro->DATA);
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
  <button type="button" class="btn btn-block bg-gradient-success btn-lg" id="gerarRelatorioBtn">Relatorio
    Completo</button>


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


    $(function () {


      document.getElementById("gerarRelatorioBtn").addEventListener("click", function () {
        // Obtém o valor da variável com a chave do relatório
        var chaveRelatorio = "<?php echo $dias ?>";
        // Redireciona o usuário para a página de destino com a chave como parâmetro de consulta na URL
        window.open("relatorioCompleto.php?chave=" + chaveRelatorio, "_blank");
      });

      //-------------
      //- DONUT CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
      var donutData = <?php echo json_encode($donutData); ?>;
      var donutOptions = {
        maintainAspectRatio: true,
        responsive: true,

      };
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      new Chart(donutChartCanvas, {
        type: 'pie',
        data: donutData,
        options: donutOptions
      })
      //-------------
      //- BAR CHART -
      //-------------
      var barChartCanvas = $('#barChart').get(0).getContext('2d')

      var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
      }

      new Chart(barChartCanvas, {
        type: 'bar',
        data: <?php echo json_encode($chartData) ?>,
        options: <?php echo json_encode($chartOptions) ?>
      })
      //-------------
      //- LINE CHART -
      //--------------
      var lineChartCanvas = $('#lineChart').get(0).getContext('2d')

      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: <?php echo json_encode($lineChartData) ?>,
        options: <?php echo json_encode($lineChartOptions) ?>
      })

      var facialLineChartCanvas = $('#facialLineChart').get(0).getContext('2d');

      var facialLineChart = new Chart(facialLineChartCanvas, {
        type: 'line',
        data: <?php echo json_encode($facialLineChartData) ?>,
        options: <?php echo json_encode($facialLineChartOptions) ?>
      });
    });
  </script>
  <?php
  $html = ob_get_clean(); // Obter o conteúdo do buffer de saída e limpar o buffer
  file_put_contents($filename, $html); // Salvar o HTML em um arquivo
  echo $html; // Exibir o HTML para o usuário
}
?>
