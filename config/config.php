<?php
$loader = require $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';
$loader->register();
    // caminho completo E:\Dropbox\_ProgSilvio\CNG_Git\www\htdocs
    $dirini = $_SERVER["DOCUMENT_ROOT"];

    // E:\Dropbox\_ProgSilvio\CNG_Git\ (tiro www\)
    $dirini = str_replace('www\htdocs', 'www\\\\', $dirini);

    //monto o caminho configWWW.ini ...
    $dirini = $dirini . 'configWWW.ini';

    DEFINE('INI_DIR', $dirini);
    
    $ini_config = parse_ini_file($dirini, true);
    // $ini_config = parse_ini_file("E:\\Dropbox\\_ProgSilvio\\CNG_Git\\www\\configWWW.ini", true);

    //ler o end. do bancodedados.fdb
    $bd = $ini_config["BD"];
    $dbHost = $bd["host"];
    $dbName = $bd["end"];
    $dbUser="SYSDBA";      
    $dbPassword="masterkey";     
    try{
      $dbConn= new PDO("firebird:host=$dbHost;dbname=$dbName;charset=ISO8859_1",$dbUser,$dbPassword);
    }
    catch(Exception $e)
    {
      Echo "Falha na conexão " . $e->getMessage();
    }


    date_default_timezone_set("America/Sao_Paulo");
?>