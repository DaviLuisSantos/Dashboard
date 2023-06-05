<?php
include '../z/config.php';


//echo json_encode($donutData);


?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | Segmix</title>

  <script src="plugins/jquery/jquery.min.js"></script>
  <link rel="stylesheet" href="./dist/css/starter.css">

  <link rel="stylesheet" href="./dist/css/fonts.googleapis.com_css_family.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/chart.js/Chart.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>


  <!-- Importar Bootstrap CSS -->
  <link rel="stylesheet" href="./dist/css/bootstrap.min.css">

</head>

<body>
  <div class="wrapper">
    <div class="theme-switch-container">
      <label class="theme-switch-toggle">
        <input type="checkbox" id="themeSwitch">
        <span class="theme-switch-slider"></span>
      </label>
    </div>
    <div class="card-body table-responsive pad">
      <div>
        <img src="./dist/img/LogoSegmix_login.png" alt="">
      </div>
      <div class="btn-group btn-group-toggle" data-toggle="buttons">
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
        url: "relatorioVisita.php",
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
   /* setInterval(function () {
      atualizarResultados();
    }, 60000);
*/


    $(document).ready(function () {
      atualizarResultados();
      $('a.nav-link').click(function (e) {
        e.preventDefault();
        var file = $(this).data('file');
        $('#conteudo').load(file);
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      // Carregar o tema salvo no armazenamento local (se existir)
      var savedTheme = localStorage.getItem('theme');
      if (savedTheme) {
        document.body.classList.add(savedTheme);
        document.getElementById('themeSwitch').checked = (savedTheme === 'dark');
      }

      // Lidar com a mudança de tema
      document.getElementById('themeSwitch').addEventListener('change', function () {
        if (this.checked) {
          document.body.classList.add('dark');
          localStorage.setItem('theme', 'dark');
        } else {
          document.body.classList.remove('dark');
          localStorage.setItem('theme', 'light');
        }
      });
    });
    // Carregar o tema salvo no armazenamento local (se existir)
    var savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
      document.body.classList.add(savedTheme);
      document.getElementById('themeSwitch').checked = (savedTheme === 'dark');
    }

    // Lidar com a mudança de tema
    document.getElementById('themeSwitch').addEventListener('change', function () {
      if (this.checked) {
        document.body.classList.add('dark');
        localStorage.setItem('theme', 'dark');
      } else {
        document.body.classList.remove('dark');
        localStorage.setItem('theme', 'light');
      }
    });
  </script>
</body>

</html>