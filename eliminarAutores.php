<?php
include 'conex.php';
$link=Conectarse();

$auto_codigo = $_GET['auto_codigo'];

    mysql_query ('DELETE FROM autores WHERE auto_codigo='.$auto_codigo.'', $link);

header("Location:autores.php");		
?>