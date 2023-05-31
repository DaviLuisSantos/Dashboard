<?php
include '../../../z/config.php';

require_once 'ComponentesVisualizacao.php';

require_once 'querys-dash.php';

echo json_encode($resultados);




// Instanciando a classe Chart com os parâmetros necessários
$chart = new Chart('line', ['Janeiro', 'Fevereiro', 'Março','Abril','Maio'], [250, 230, 150,300,400]);

?>
