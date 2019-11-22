<?php
include 'conex.php';
$link=Conectarse();
$vita_id = $_POST['vita_id'];
$vita_nombre = utf8_decode($_POST['vita_nombre']);
$vita_fecha = $_POST['vita_fecha'];
$vita_motivo = utf8_decode($_POST['vita_motivo']);
mysql_query("INSERT INTO visitas (vita_id,vita_nombre,vita_fecha,vita_motivo) VALUES (".$vita_id.",'".$vita_nombre."','".$vita_fecha."','".$vita_motivo."')",$link);
header("Location:visitas.php");
?>
