<?php
include 'conex.php';
$link=Conectarse();
$libr_codigo = $_GET['libr_codigo'];

    mysql_query('DELETE FROM libros WHERE libr_codigo='.$libr_codigo.'',$link);

header("Location:libros.php");		
?>