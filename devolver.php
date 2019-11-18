<?php
include 'conex.php';
$link=Conectarse();
$pres_codigo = $_GET['id_prestamo'];
mysql_query('UPDATE prestamos SET pres_fecha_d = now() WHERE pres_codigo='.$pres_codigo.'',$link);

// Aumentar la cantidad de ejemplares disponibles del libro devuelto
$cons = mysql_query("
	SELECT ejemplares_disp AS n, libr_codigo AS c FROM libros
	JOIN prestamos ON libros_libr_codigo = libr_codigo
	WHERE pres_codigo = $pres_codigo", $link);

$result = mysql_fetch_object($cons);
$ejemplares_disp =  $result ->  n;
$libr_codigo = $result ->  c;
mysql_query("UPDATE libros SET ejemplares_disp=".($ejemplares_disp+1)." WHERE libr_codigo=$libr_codigo", $link);
header("Location:prestados.php");
?>
