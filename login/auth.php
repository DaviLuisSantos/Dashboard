<?php

$dirini = $_SERVER["DOCUMENT_ROOT"];
$dirini = $dirini . '\z\config.php';
require $dirini;

session_start();

$login = $_POST["login"];
$senha = $_POST['senha'];

$query = $dbConn->prepare("SELECT IDOPERADOR, NOME, USOLINEAR,USOADMTOTAL  FROM OPERADOR_SISTEMA WHERE NOME= :login AND SENHA= :senha");
$query->bindValue(':login', utf8_decode($login));
$query->bindValue(':senha', utf8_decode($senha));
$query->execute();

//retornamos todos os registros (fetchAll) em forma de uma lista de Objetos (FECH_OBJ)
$registros = $query->fetchAll(PDO::FETCH_OBJ);

$verifica_admin = $query->rowCount();

//percorremos a lista retornando item por item e imprimindo a propriedade que desejamos (neste caso: NOME)
foreach ($registros as $r) {
    $id_admin = $r->IDOPERADOR;
    $nome_admin = $r->NOME;
    $ehlinear = $r->USOLINEAR;
    $ehadmin = $r->USOADMTOTAL;
}

if ($verifica_admin > 0) {
    $_SESSION['id_admin'] = $id_admin;
    $_SESSION['nome_admin'] = $nome_admin;
    $_SESSION['tp_admin'] = 1;
    $_SESSION['LINEAR'] = $ehlinear;
    $_SESSION['ADMTOTAL'] = $ehadmin;


    // echo '<script> window.location="main.php"; </script>'; //página principal após o login...
    echo '<script> window.location="../starter.php"; </script>'; //página principal após o login...

    exit;
} else {
    echo '<script> alert(\'Dados incorretos, tente novamente.\');  window.location="./login.php"; </script>';
}

?>