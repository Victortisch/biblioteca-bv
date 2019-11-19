<?php
include 'conex.php';
$link=Conectarse();
$pres_codigo = $_GET['id_prestamo'];
mysql_query('UPDATE prestamos SET pres_fecha_d = now() WHERE pres_codigo='.$pres_codigo.'',$link);

// Aumentar la cantidad de ejemplares disponibles del libro devuelto
$cons = mysql_query("
	SELECT libr_codigo AS c FROM libros
	JOIN prestamos ON libros_libr_codigo = libr_codigo
	WHERE pres_codigo = $pres_codigo", $link);

$result = mysql_fetch_object($cons);
$libr_codigo = $result ->  c;

mysql_query("UPDATE libros SET ejemplares_disp = ejemplares_disp + 1 WHERE libr_codigo=$libr_codigo", $link);
mysql_close($link);

header("Location:prestados.php");
?>
