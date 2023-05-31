<?php
include '../z/config.php';


//echo json_encode($donutData);


?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | Segmix</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
      <div class="card-body table-responsive pad">
        <p class="mt-3 mb-1">Intervalo de Tempo</p>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          <label class="btn bg-olive active">
            <input type="radio" name="options" id="option_b1" autocomplete="off" value="1" checked> 1 dia
          </label>
          <label class="btn bg-olive">
            <input type="radio" name="options" id="option_b2" autocomplete="off" value="7"> 7 dias
          </label>
          <label class="btn bg-olive">
            <input type="radio" name="options" id="option_b3" autocomplete="off" value="30"> 30 dias
          </label>
          <label class="btn bg-olive">
            <input type="radio" name="options" id="option_b4" autocomplete="off" value="60"> 60 dias
          </label>
          <label class="btn bg-olive">
            <input type="radio" name="options" id="option_b5" autocomplete="off" value="90"> 90 dias
          </label>
        </div>
      </div>

      <div class="content" id="conteudo">

      </div>
      <!-- /.content -->
    </div>

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    // Função que atualiza os resultados com os dados obtidos do servidor
    function atualizarResultados(dias) {
  // Exibir feedback visual para o usuário
  $("#conteudo").html(`
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
      <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  `);

  // Fazer uma solicitação ajax para obter os dados atualizados
  $.ajax({
    url: "relatorioVisita.php",
    type: "POST",
    data: { dias: dias },
    dataType: "html", // Especificar o tipo de dados esperado
    success: function (result) {
      // Verificar se o resultado é válido antes de atualizar o conteúdo
      if (result.trim().length > 0) {
        $("#conteudo").html(result);
      } else {
        $("#conteudo").html("Nenhum resultado encontrado.");
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // Exibir mensagem de erro com mais informações
      $("#conteudo").html("Erro (" + jqXHR.status + "): " + errorThrown);
    },
    complete: function () {
      // Remover o feedback visual
      $("#conteudo .d-flex.justify-content-center.align-items-center").remove();
    }
  });
}




    $(document).ready(function () {
      // Selecionar o valor padrão do input
      var dias = $("input[name='options']:checked").val();

      // Chamar a função para carregar o conteúdo do div "conteudo" assim que a página é carregada
      atualizarResultados(dias);

      // Adicionar um event listener para escutar quando o usuário seleciona um novo valor para o input
      $("input[name='options']").change(function () {
        // Obter o valor selecionado pelo usuário
        var dias = $(this).val();

        // Chamar a função para atualizar o conteúdo do div "conteudo" com o novo valor selecionado pelo usuário
        atualizarResultados(dias);

        // Marcar o input selecionado como checked
        $("input[name='options']").prop("checked", false);
        $(this).prop("checked", true);
      });
    });

    $(document).ready(function() {
  $('a.nav-link').click(function(e) {
    e.preventDefault();
    var file = $(this).data('file');
    $('#conteudo').load(file);
  });
});




    $(function () {
      /* ChartJS
       * -------
       * Here we will create a few charts using ChartJS
       */

      /*
     //--------------
     //- AREA CHART -
     //--------------

     // Get context with jQuery - using jQuery's .get() method.
     var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

     var areaChartData = {
       labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
       datasets: [
         {
           label               : 'Digital Goods',
           backgroundColor     : 'rgba(60,141,188,0.9)',
           borderColor         : 'rgba(60,141,188,0.8)',
           pointRadius          : false,
           pointColor          : '#3b8bba',
           pointStrokeColor    : 'rgba(60,141,188,1)',
           pointHighlightFill  : '#fff',
           pointHighlightStroke: 'rgba(60,141,188,1)',
           data                : [28, 48, 40, 19, 86, 27, 90]
         },
         {
           label               : 'Electronics',
           backgroundColor     : 'rgba(210, 214, 222, 1)',
           borderColor         : 'rgba(210, 214, 222, 1)',
           pointRadius         : false,
           pointColor          : 'rgba(210, 214, 222, 1)',
           pointStrokeColor    : '#c1c7d1',
           pointHighlightFill  : '#fff',
           pointHighlightStroke: 'rgba(220,220,220,1)',
           data                : [65, 59, 80, 81, 56, 55, 40]
         },
       ]
     }

     var areaChartOptions = {
       maintainAspectRatio : false,
       responsive : true,
       legend: {
         display: false
       },
       scales: {
         xAxes: [{
           gridLines : {
             display : false,
           }
         }],
         yAxes: [{
           gridLines : {
             display : false,
           }
         }]
       }
     }

     // This will get the first returned node in the jQuery collection.
     new Chart(areaChartCanvas, {
       type: 'line',
       data: areaChartData,
       options: areaChartOptions
     })

     //-------------
     //- LINE CHART -
     //--------------
     var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
     var lineChartOptions = $.extend(true, {}, areaChartOptions)
     var lineChartData = $.extend(true, {}, areaChartData)
     lineChartData.datasets[0].fill = false;
     lineChartData.datasets[1].fill = false;
     lineChartOptions.datasetFill = false

     var lineChart = new Chart(lineChartCanvas, {
       type: 'line',
       data: lineChartData,
       options: lineChartOptions
     })
     */

      //-------------
      //- DONUT CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
      var donutData = <?php echo json_encode($donutData); ?>;
      var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      new Chart(donutChartCanvas, {
        type: 'pie',
        data: donutData,
        options: donutOptions
      })
      /*
          //-------------
          //- PIE CHART -
          //-------------
          // Get context with jQuery - using jQuery's .get() method.
          var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
          var pieData        = donutData;
          var pieOptions     = {
            maintainAspectRatio : false,
            responsive : true,
          }
          //Create pie or douhnut chart
          // You can switch between pie and douhnut using the method below.
          new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
          })

          */

      /*
          //---------------------
          //- STACKED BAR CHART -
          //---------------------
          var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
          var stackedBarChartData = $.extend(true, {}, barChartData)

          var stackedBarChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            scales: {
              xAxes: [{
                stacked: true,
              }],
              yAxes: [{
                stacked: true
              }]
            }
          }

          new Chart(stackedBarChartCanvas, {
            type: 'bar',
            data: stackedBarChartData,
            options: stackedBarChartOptions
          })
          */
    })
  </script>
</body>

</html>
