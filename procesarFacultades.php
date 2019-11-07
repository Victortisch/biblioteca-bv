<?php

include 'conex.php';
$link=Conectarse();
$facu_codigo = $_POST['id_facultad'];
$facu_descripcion = utf8_decode($_POST['facu_descripcion']);

//$ciudad = mb_strtoupper($ciudad);

if($_POST['modificar']){
   mysql_query('UPDATE facultades SET facu_descripcion="'.$facu_descripcion.'" WHERE facu_codigo='.$facu_codigo.'', $link);
}
else{
    mysql_query("INSERT INTO facultades (facu_codigo,facu_descripcion) VALUES (".$facu_codigo.",'".$facu_descripcion."')", $link);
}

header("Location:facultades.php");		
?>