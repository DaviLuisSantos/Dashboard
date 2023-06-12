
<?php
session_start();

$id_admin = $_SESSION['id_admin'];
$tp_admin = $_SESSION['tp_admin'];

// Verifica se o usuário está logado
if (isset($id_admin) && isset($tp_admin)) {
    // Se o usuário estiver logado, exibe o botão de log out
    echo '<button id="logOutBtn" class="btn btn-primary">Log Out</button>';
    
}
?>


  
    <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | Segmix</title>

  <!-- Importar Bootstrap CSS -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="./dist/css/bootstrap/bootstrap.min.css">

  <!-- Importar estilos personalizados -->
  <link rel="stylesheet" href="./dist/css/starter.css">
  <link rel="stylesheet" href="./dist/css/fonts.googleapis.com_css_family.css">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <!-- Importar AdminLTE style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

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
    #segmixImg{
      cursor: pointer;
    }
  </style>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/chart.js/Chart.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>
</head>

  
    <!-- Importar Bootstrap CSS -->
    <link rel="stylesheet" href="./dist/css/bootstrap/bootstrap.min.css"><!-- cabecalho.php -->
    <div class="wrapper">
      <div class="theme-switch-container">
        <label class="theme-switch-toggle">
          <input type="checkbox" id="themeSwitch">
          <span class="theme-switch-slider"></span>
        </label>
      </div>
      <div class="card-body table-responsive pad">
        <div>
          <img src="./dist/img/LogoSegmix_login.png" alt="" id="segmixImg">
        </div>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
        </div>
      </div>
  </div>
  
  
  <!-- Incluir o jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  
  <!-- Incluir o Bootstrap JS -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <script>
    $(document).ready(function () {
      $('#segmixImg').click(function () {
        window.location.href = '../z/viregfull.php'; // Substitua pela página de configuração correta
      });
    });
    // Lógica do tema aqui
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
         // document.body.classList.remove('light');
          document.body.classList.add('dark');
          localStorage.setItem('theme', 'dark');
        } else {
          document.body.classList.remove('dark');
          localStorage.setItem('theme', 'light');
        }
      });
      $('#logOutBtn').click(function () {
            window.location.href = './login/logout.php';
        });
  </script>

  


