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

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="./dist/css/fonts.googleapis.com_css_family.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  
  <script src="plugins/jquery/jquery.min.js"></script>
  
  <!-- Importar Bootstrap CSS -->
  <link rel="stylesheet" href="./dist/css/bootstrap.min.css">
  
  <!-- Seu estilo personalizado -->
  <style>
    body.dark {
      background-color: #161626;
      color: #ffffff;
    }
    
    .theme-switch-container {
      position: fixed;
      top: 20px;
      right: 20px;
    }
    
    .theme-switch-toggle {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }
    
    .theme-switch-toggle input {
      opacity: 0;
      width: 0;
      height: 0;
    }
    
    .theme-switch-slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    .theme-switch-slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: #fff;
      -webkit-transition: .4s;
      transition: .4s;
    }
    
    input:checked + .theme-switch-slider {
      background-color: #2196F3;
    }
    
    input:focus + .theme-switch-slider {
      box-shadow: 0 0 1px #2196F3;
    }
    
    input:checked + .theme-switch-slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }
  </style>
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
        <h1 class="mt-3 mb-1">Dashboard Segmix</h1>
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

document.addEventListener("DOMContentLoaded", function() {
      // Carregar o tema salvo no armazenamento local (se existir)
      var savedTheme = localStorage.getItem('theme');
      if (savedTheme) {
        document.body.classList.add(savedTheme);
        document.getElementById('themeSwitch').checked = (savedTheme === 'dark');
      }
      
      // Lidar com a mudança de tema
      document.getElementById('themeSwitch').addEventListener('change', function() {
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
      document.getElementById('themeSwitch').addEventListener('change', function() {
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
