<?php
include 'conex.php';
$link=Conectarse();
$pres_codigo = $_GET['pres_codigo'];
mysql_query('DELETE FROM prestamos WHERE pres_codigo='.$pres_codigo.'',$link);
header("Location:prestamos.php");
?>
