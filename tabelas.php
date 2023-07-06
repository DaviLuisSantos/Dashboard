<?php
include '../z/config.php';
require_once 'ComponentesVisualizacao.php';
require_once 'querys-dash.php';
include './login/session.php';

$codUsuario = $_SESSION['id_admin'];
$nomeUsuario = $_SESSION['nome_admin'];

$pastaResult = __DIR__ . "/resultados/";

if (!file_exists($pastaResult)) {
  mkdir($pastaResult, 0777, true);
  // A pasta foi criada com sucesso
} else {
  // A pasta já existe
}

$filename = __DIR__ . "/resultados/" . $codUsuario . "-" . $nomeUsuario . "/resultados_" . date('Y-m-d') . "_" . $dias . "dias.html";
$compPasta = __DIR__ . "/resultados/" . $codUsuario . "-" . $nomeUsuario;

if (!file_exists($compPasta)) {
    mkdir($compPasta, 0777, true);
    // A pasta foi criada com sucesso
} else {
    // A pasta já existe
}
$compHtml = __DIR__ . "/resultados/" . $codUsuario . "-" . $nomeUsuario . "/resultados_" . date('Y-m-d') . "_";

$querysComponentes = $resultados;
?>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="./dist/css/adminlte.min.css">
<script src="./plugins/datatables/jquery.dataTables.min.js"></script>
<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="./plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="./plugins/jszip/jszip.min.js"></script>
<script src="./plugins/pdfmake/pdfmake.min.js"></script>
<script src="./plugins/pdfmake/vfs_fonts.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.print.min.js"></script>

<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>

<div class="container-fluid" id="containerBtn">
    <div class="row" id="dashboard">
        <?php
      foreach ($querysComponentes as $index) {
        if ($index->tipo == 'table') {
          $chartHtml = '';
          if (file_exists($compHtml . $index->nome . '.html')) {
            $html = file_get_contents($compHtml . $index->nome . '.html');
            $chartHtml = $html;
          } else {
            $stmt = $dbConn->prepare($index->query);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
            $chart = new Table($index->cor, $resultado, $index->descricao, $index->nome, $index->tempo_refresh);
            $chartHtml = $chart->render();
          }
          echo '<div class="col-lg-6" id="Chart-' . $index->nome . '">' . $chartHtml . '</div>';
          file_put_contents($compHtml . $index->nome . '.html', $chartHtml);
        }
      }
      ?>
    </div>

</div>

<!-- Importar jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="./plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>

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
        data: {
            id: id
        },
        dataType: 'html',
        success: function(result) {
            // Atualizar o conteúdo do componente CHART com as informações atualizadas
            $('#Chart-' + id).html(result);

            // Atualizar o conteúdo do arquivo HTML, se necessário
            var filename = 'resultados/<?php echo $codUsuario.'-'.$nomeUsuario?>/resultados_' +
                getCurrentDate() + '_' + id + '.html';
            $.post('salvar_html.php', {
                filename: filename,
                html: result
            });
        },
        error: function() {
            console.log('Erro ao atualizar o componente CHART ' + id);
        }
    });
}
</script>
