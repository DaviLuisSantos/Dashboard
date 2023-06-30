<?php
include './config/config.php';
require_once 'ComponentesVisualizacao.php';

$resultado = $dbConn->query("SELECT FIRST 25
                              UNIDADEDESTINO as UNIDADE,
                              NOMEVISITANTE as NOME,
                              TIPOVISITANTE as TIPO,
                              PLACAVISITANTE as PLACA,
                              EMPRESAVISITANTE as EMPRESA,
                              PORTEIROENTRADA as OPERADOR_ENTRADA,
                              PORTEIROSAIDA as OPERADOR_SAIDA,
                              DATAHORAENTRADA as DATA_ENTRADA,
                              DATAHORASAIDA as DATA_SAIDA,
                              AUTORIZADOPOR as AUTORIZADO_POR
                            FROM VISITA_SAIU_E_SEM_CONTROLE
                            ORDER BY DATA_ENTRADA DESC ");
$dados = $resultado->fetchAll(PDO::FETCH_OBJ);

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
            $table = new Table('0000FF', $dados, 'Ultimos Visitantes', 'ultiVis');
            $chartHtml = $table->render();
            echo '<div class="col-lg" id="Chart-' . $index->nome . '">' . $chartHtml . '</div>';
      ?>
    </div>

  </div>


<!-- Page specific script -->