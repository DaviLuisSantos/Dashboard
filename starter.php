<?php
include '../z/config.php';
// echo json_encode($donutData);
include './login/session.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
<body>
<?php include 'barra_lateral.php'; ?>
<section class="content">
  <div class="container-fluid"id="conteudo">
</div>
</section>
</div>
  <!-- /.content -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="./plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="./plugins/chart.js/Chart.min.js"></script>

  <!-- Importar AdminLTE script -->
  <script src="./dist/js/adminlte.min.js"></script>

  <script>
    // Função que atualiza os resultados com os dados obtidos do servidor
    function atualizarResultados() {
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
        url: "relatorioDash.php",
        type: "GET",
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
      atualizarResultados();
    /*  $('a.nav-link').click(function (e) {
        e.preventDefault();
        var file = $(this).data('file');
        $('#conteudo').load(file);
      });
      */
    });

  </script>
</body>

</html>