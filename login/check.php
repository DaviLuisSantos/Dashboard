<?php

$dirino = $_SERVER["DOCUMENT_ROOT"];
$dirino = $dirino . '\z\config.php';
require $dirino;

session_start();

$id_admin = $_SESSION['id_admin'];
$tp_admin = $_SESSION['tp_admin'];

if ($id_admin != NULL) {
	if ($tp_admin == 1) {
		$resultado_adm = $dbConn->query("SELECT NOME, LOGIN FROM OPERADOR_SISTEMA WHERE IDOPERADOR='$id_admin'");
		$resultado_adm->execute();

		//retornamos todos os registros (fetchAll) em forma de uma lista de Objetos (FECH_OBJ)
		$registros = $resultado_adm->fetchAll(PDO::FETCH_OBJ);

		//percorremos a lista retornando item por item e imprimindo a propriedade que desejamos (neste caso: NOME)
		foreach ($registros as $r) {
			$nome_admin = utf8_encode($r->NOME);
			$email_admin = utf8_encode($r->LOGIN);
		}


	}
} else {
	header("location: ../login.php");
	exit;
}

?>