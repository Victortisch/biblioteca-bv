<?php
include 'conex.php';
$link=Conectarse();
$vita_id = $_POST['vita_id'];
$vita_nombre = utf8_decode($_POST['vita_nombre']);
$vita_motivo = utf8_decode($_POST['vita_motivo']);
if($_POST['modificar']){
    mysql_query('UPDATE visitas SET vita_nombre="'.$vita_nombre.'", vita_motivo="'.$vita_motivo.'" WHERE vita_id='.$vita_id.'', $link);
}
else{
    mysql_query("INSERT INTO visitas (vita_id,vita_nombre,vita_motivo) VALUES (".$vita_id.",'".$vita_nombre."','".$vita_motivo."')", $link);
}
header("Location:visitas.php");
?>
