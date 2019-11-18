<?php
include 'conex.php';
$link= Conectarse();
$tili_codigo = $_GET['tili_codigo'];
mysql_query('DELETE FROM tipos_libros WHERE tili_codigo='.$tili_codigo.'',$link);
header("Location:tipos_libros.php");
?>
