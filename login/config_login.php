<?php

session_start();

$dirino = $_SERVER["DOCUMENT_ROOT"];
$dirino = $dirino . '\z\config.php';
require $dirino;

unset($_SESSION['id_admin']);


?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

  <title>Acesso Rio Web - Login</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="../croc/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../croc/assets/css/authentication/form-2.css">
  <!-- Custom styles for this template -->
</head>

<body class="text-center form">

  <div class="form-container outer">
    <div class="form-form">
      <div class="form-form-wrap">
        <div class="form-container">
          <div class="form-content">
            <form action="./login/auth.php" method="post">
              <div class="form">
                <div id="username-field" class="field-wrapper input">
                  <img class="mb-4" src="/img/LogoSegmix_login.png" alt="" width="231" height="61">
                  <select id="username" name="login" class="form-control" name="tipovisitante">
                    <option value="">Escolha o usuário...</option>

                    <?php
                    $sqlUsuarios = "SELECT LOGIN, NOME FROM OPERADOR_SISTEMA WHERE USOLINEAR='1'";
                    $stmtUsuarios = $dbConn->prepare($sqlUsuarios);
                    $stmtUsuarios->execute();

                    $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_OBJ);
                    foreach ($usuarios as $usuario) {
                      $login = utf8_encode($usuario->NOME);
                      $nome = utf8_encode($usuario->NOME);
                      ?>
                      <option value="<?php echo $login ?>"> <?php echo $nome ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
                <div id="password-field" class="field-wrapper input mb-2">
                  <input id="password" name="senha" type="password" class="form-control" placeholder="senha"
                    autocomplete="off">
                </div>
                <div class="d-sm-flex justify-content-between">
                  <div class="field-wrapper">
                    <button type="submit" class="btn btn-primary" value="">entrar</button>
                    <a href="http://www.segmix.com.br" style="text-decoration: none" target="blanc">
                      <p class="mt-5 mb-3 text-muted">&copy; SEGMIX.com.br</p>
                    </a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>