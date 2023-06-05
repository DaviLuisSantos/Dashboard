
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

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




  <!-- Importar Bootstrap CSS -->
  <link rel="stylesheet" href="./dist/css/bootstrap.min.css"><!-- cabecalho.php -->
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
</div>

<!-- Incluir o jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>

<!-- Incluir o Bootstrap JS -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
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
</script>
