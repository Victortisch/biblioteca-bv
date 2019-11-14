<?php
include 'conex.php';
$link=Conectarse();
$orli_codigo = $_GET['orli_codigo'];

    mysql_query('DELETE FROM origenes_libros WHERE orli_codigo='.$orli_codigo.'', $link);

header("Location:origenes_libros.php");		
?>