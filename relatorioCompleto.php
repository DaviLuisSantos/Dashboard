<?php
include '../z/config.php';

$dias = $_GET["chave"];
echo "Valor do var:" . $dias;

$resultado = $dbConn->query("SELECT
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
                            WHERE DATAHORAENTRADA >= CURRENT_TIMESTAMP - $dias");
$dados = $resultado->fetchAll(PDO::FETCH_OBJ);
$th = '';
foreach ($dados[0] as $key => $value) {
  $th .= '<th>' . $key . '</th>';
}

?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | DataTables</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>
<h1>Sucesso</h1>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Relatorio de Visitantes</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example" class="table table-bordered table-striped" style="width:100%">
              <thead>
                <tr>
                  <?= $th ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($dados as $linha): ?>
                  <tr>
                    <?php foreach ($linha as $valor): ?>
                      <td>
                        <?= $valor ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>

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
<script src="./plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example").DataTable({
      language: {
        url: './build/config/pt-BR.json',
    },
      "dom": 'Bfrtip',
      "responsive": true, "lengthChange": false, "autoWidth": true, "pageMargins": [0, 0, 0, 0],
      "orientation": "landscape",
      "buttons": ["copy",  {
        extend: 'excel',
        title: `Relatório: Dia ${getDate()}`,
        filename: `Relatorio-${getDate()}`
    },
    {
        extend: 'csv',
        title: `Relatório: Dia ${getDate()}`,
        filename: `Relatorio-${getDate()}`
    },
    {
        extend: 'pdfHtml5',
        "orientation": 'landscape',
        pageSize: 'A4',
        "exportOptions": {
          "modifier": {
            "pageWidth": '210mm',
            "pageHeight": '297mm'
          }
        },
        customize: function (doc) {
        // Definir margem superior e inferior como 10
        doc.pageMargins = [10, 10, 10, 10];

        // Diminuir o tamanho da fonte para 8pt
        doc.defaultStyle.fontSize = 8;

        // Remover o espaçamento entre as linhas
        doc.styles.tableBodyEven = { fontSize: 8, fillColor: "#fff", textColor: "#444", lineHeight: 1 };
        doc.styles.tableBodyOdd = { fontSize: 8, fillColor: "#f8f8f8", textColor: "#444", lineHeight: 1 };
      },
        "title": `Relatório: Dia ${getDate()}`,
        "filename": `Relatorio-${getDate()}`

      }, "print", "colvis",
      ]
    }).buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
  });

  function getDate() {
    let date = new Date();
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();

    return `${day < 10 ? '0' : ''}${day}-${month < 10 ? '0' : ''}${month}-${year}`;
  }
</script>
