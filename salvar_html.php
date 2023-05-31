<?php
$filename = $_POST['filename'];
$html = $_POST['html'];

// Salve o novo conteúdo no arquivo HTML
file_put_contents($filename, $html);
?>
