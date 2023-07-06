<!DOCTYPE html>

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
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" id="sidebarToggle" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" id="themeSwitchBtn" href="#" role="button">
                        <i class="fas fa-adjust"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="./dist/img/LogoMini.png" alt="" id="segmixImg" class="img-fluid">
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p><?php echo $_SESSION['nome_admin'];?></p>
                            </a>
                        </li>
                       <!--- <li class="nav-item">
                            <a href="Dashboard/starter.php" class="nav-link" carrega="relatorioDash.php">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        ---> </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" carrega="relatorioDash.php">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Gráficos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="Dashboard/tabelas.php" class="nav-link" carrega="tabelas.php">
                                <i class="nav-icon fas fa-table"></i>
                                <p>Tabelas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../z/viregfull.php" class="nav-link" redireciona="../z/viregfull.php">
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>Papa-Fila</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="configuracao" class="nav-link" carrega="configuracao_dash.php">
                                <i class="nav-icon fas fa-gear"></i>
                                <p>Configuração</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./login/logout.php" class="nav-link" redireciona="./login/logout.php">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="sidebar-footer">
    <span>v0.2</span>
</div>

        </aside>

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
            // Função para verificar a classe do body e atualizar a barra lateral
            function toggleSidebar(sentido = null) {
                var bodyClass = $('body').attr('class');
                if (sentido == 'fechar') {
                    $('body').addClass('sidebar-collapse sidebar-closed');
                    $('body').removeClass('sidebar-open');
                    return;
                }
                if ($(window).width() <= 767) {
                    if (bodyClass.indexOf('sidebar-open') == -1) {
                        $('body').removeClass('sidebar-collapse sidebar-closed'); // Remover classes
                        $('body').addClass('sidebar-open');
                    } else if (bodyClass.indexOf('sidebar-open') !== -1) {
                        $('body').addClass('sidebar-collapse sidebar-closed'); // Remover classes
                        $('body').removeClass('sidebar-open');
                    }
                    return;
                } else if (bodyClass && (bodyClass.indexOf('sidebar-collapse') !== -1 || bodyClass.indexOf(
                        'sidebar-closed') !== -1)) {
                    $('body').removeClass('sidebar-collapse sidebar-closed');
                    $('body').addClass('sidebar-open');
                } else {
                    $('body').addClass('sidebar-collapse sidebar-closed');
                    $('body').removeClass('sidebar-open');
                }
            }

            // Função para carregar o conteúdo via requisição AJAX
            function carregarConteudo(url) {
                $("#conteudo").html(`
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
      <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  `);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(result) {
                        $("#conteudo").empty();
                        $("#conteudo").append(result);
                        toggleSidebar('fechar');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $("#conteudo").html("Erro (" + jqXHR.status + "): " + errorThrown);
                    },
                    complete: function() {
                        $("#conteudo .d-flex.justify-content-center.align-items-center").remove();
                    }
                });
            }

            // Função para marcar o item ativo na barra lateral e carregar o conteúdo correspondente
            function marcarItemAtivo() {
                var activeItem = localStorage.getItem(
                    'activeItem'); // Obtém o item ativo do armazenamento local
                if (activeItem) {
                    $('.sidebar .nav-link').removeClass('active'); // Remove a classe "active" de todos os itens
                    var item = $(".nav-link[carrega='" + activeItem + "']");
                    $(item).addClass('active'); // Adiciona a classe "active" ao item armazenado

                    // Obtém o atributo "carrega" do item marcado
                    var carrega = activeItem;
                    if (carrega) {
                        carregarConteudo(carrega); // Carrega o conteúdo correspondente ao item marcado
                    }
                }
            }
            marcarItemAtivo()

            // Manipule o evento de clique no elemento sidebarToggle
            $('#sidebarToggle').on('click', function(e) {
                e.preventDefault();
                toggleSidebar();
            });

            // Manipule o evento de clique nos itens da barra lateral
            $(document).on('click', '.sidebar .nav-link', function(e) {
                e.preventDefault(); // Evita o redirecionamento padrão

                // Remova a classe "active" de todos os itens da barra lateral
                $('.sidebar .nav-link').removeClass('active');

                // Verifique se o item possui o atributo "carrega"
                var carrega = $(this).attr('carrega');
                if (carrega) {

                    // Adicione a classe "active" ao item clicado
                    $(this).addClass('active');
                    // Armazena o item ativo no armazenamento local
                    var activeItem = $(this).attr('carrega');
                    localStorage.setItem('activeItem', activeItem);
                    carregarConteudo(
                        carrega); // Chama a função para carregar o conteúdo via requisição AJAX
                }
                var redireciona = $(this).attr('redireciona');
                if (redireciona) {
                    window.location.href = redireciona;
                }

            });

            // Verifique a classe do body ao carregar a página e atualize a barra lateral
            toggleSidebar();

            // Fechar a barra lateral ao tocar em outra parte da tela
            $(document).on('click', function(e) {
                var target = $(e.target);

                // Verifique se o elemento clicado não está dentro da barra lateral
                // Fechar a barra lateral ao tocar fora dela
                if (!target.closest('#sidebarToggle').length && !target.closest('.sidebar').length) {
                    $('body').removeClass('sidebar-open'); // Fechar a barra lateral
                    $('body').addClass('sidebar-collapse sidebar-closed');
                }
            });

        });
        </script>



        </html>