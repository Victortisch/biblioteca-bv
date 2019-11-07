<?php
include 'conex.php';
$link=Conectarse();

$pres_codigo = $_GET['pres_codigo'];
echo date("Y-m-d");

   mysql_query('UPDATE prestamos SET pres_fecha_d = now() WHERE pres_codigo='.$pres_codigo.'',$link);

header("Location:prestados.php");		
?>