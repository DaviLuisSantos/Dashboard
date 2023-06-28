<?php
include '../z/config.php';
// echo json_encode($donutData);
include './login/session.php';

$id_admin = $_SESSION['id_admin'];
$tp_admin = $_SESSION['tp_admin'];
$nome_adm=$_SESSION['nome_admin'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <!-- Adicione os links do Bootstrap CSS -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
    <link rel="stylesheet" href="./dist/css/starter.css">
    <!-- Adicione a meta tag para tornar o site responsivo -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Botão para abrir e fechar a sidebar -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <!-- Botão de mudança de tema -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" id="themeSwitchBtn" href="#" role="button">
                        <i class="fas fa-adjust"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Barra lateral -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <!-- Logotipo -->
            <a href="#" class="brand-link">
                <img src="./dist/img/LogoMini.png" alt="" id="segmixImg" class="img-fluid">
                <!--- <span class="brand-text font-weight-light">Dashboard</span> --->
            </a>

            <!-- Itens da barra lateral -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p><?php echo $nome_adm?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="Dashboard/starter.php" class="nav-link" carrega="relatorioDash.php">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" >
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Gráficos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" carrega="tabelas.php">
                                <i class="nav-icon fas fa-table"></i>
                                <p>Tabelas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="papa-fila" class="nav-link" redireciona="../z/viregfull.php">
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>Papa-Fila</p>
                            </a>
                        </li>
                        <?php

$id_admin = $_SESSION['id_admin'];
$tp_admin = $_SESSION['tp_admin'];

// Verifica se o usuário está logado
if (isset($id_admin) && isset($tp_admin)) {
    // Se o usuário estiver logado, exibe o botão de log out
    echo '<li class="nav-item">
    <a href="logout" class="nav-link" redireciona="./login/logout.php">
      <i class="nav-icon fas fa-sign-out-alt"></i>
      <p>Logout</p>
    </a>
  </li>';
    
}
?>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Conteúdo principal -->
        <div class="content-wrapper">
            <?php include 'cabecalho.php'; ?>
        </div>

        <!-- Adicione os links do Bootstrap JS -->
        <script src="./plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="./dist/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Carregar o tema salvo no armazenamento local (se existir)
            var savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.body.classList.add(savedTheme);
                document.getElementById('themeSwitchBtn').classList.toggle('active', savedTheme === 'dark');
            }

            // Lidar com a mudança de tema
            document.getElementById('themeSwitchBtn').addEventListener('click', function() {
                document.body.classList.toggle('dark');
                var isDarkTheme = document.body.classList.contains('dark');
                localStorage.setItem('theme', isDarkTheme ? 'dark' : 'light');
                this.classList.toggle('active', isDarkTheme);
            });
        });
        $(document).ready(function() {
  // Função para carregar conteúdo via requisição AJAX
  function carregarConteudo(url) {
    $.ajax({
      url: url,
      type: 'GET',
      success: function(result) {
        // Remover todos os elementos filhos de #conteudo
        $("#conteudo").empty();

        // Adicionar o novo conteúdo, incluindo as tags <script>
        $("#conteudo").append(result);

        toggleSidebar(); // Chamar a função para verificar a classe do body e atualizar a barra lateral
      },
      error: function(jqXHR, textStatus, errorThrown) {
        // Exibir mensagem de erro com mais informações
        $("#conteudo").html("Erro (" + jqXHR.status + "): " + errorThrown);
      },
      complete: function() {
        // Remover o feedback visual
        $("#conteudo .d-flex.justify-content-center.align-items-center").remove();
      }
    });
  }

  // Função para verificar a classe do body e atualizar a barra lateral
  function toggleSidebar() {
    var bodyClass = $('body').attr('class');
    if (bodyClass && (bodyClass.indexOf('sidebar-collapse') !== -1 || bodyClass.indexOf('sidebar-closed') !== -1)) {
      $('body').removeClass('sidebar-collapse sidebar-closed');
    } else {
      $('body').addClass('sidebar-collapse');
    }
  }

  // Manipule o evento de clique nos itens da barra lateral
  $(document).on('click', '.sidebar .nav-link', function(e) {
    // Remova a classe "active" de todos os itens da barra lateral
    $('.sidebar .nav-link').removeClass('active');

    // Adicione a classe "active" ao item clicado
    $(this).addClass('active');

    // Verifique se o item possui o atributo "carrega"
    var carrega = $(this).attr('carrega');
    if (carrega) {
      e.preventDefault(); // Evita o redirecionamento padrão
      carregarConteudo(carrega); // Chama a função para carregar o conteúdo via requisição AJAX
    }

    // Verifique se o item possui o atributo "redireciona"
    var redireciona = $(this).attr('redireciona');
    if (redireciona) {
      window.location.href = redireciona;
    }

    // Verifique a largura da janela para dispositivos móveis
    if ($(window).width() <= 767) {
      $('body').removeClass('sidebar-open'); // Fechar a barra lateral em dispositivos móveis
    }
  });

  // Verifique a classe do body ao carregar a página e atualize a barra lateral
  toggleSidebar();
});


        </script>

</html>