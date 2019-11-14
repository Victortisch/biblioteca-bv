<?php
include 'conex.php';
$link=Conectarse();
$carr_codigo = $_POST['id_carrera'];
$carr_descripcion = utf8_decode($_POST['carr_descripcion']);
$facultades_facu_codigo  = $_POST['facultades'];
//$ciudad = mb_strtoupper($ciudad);

if($_POST['modificar']){
    mysql_query('UPDATE carreras SET carr_descripcion="'.$carr_descripcion.'", facultades_facu_codigo='.$facultades_facu_codigo.' WHERE carr_codigo='.$carr_codigo.'', $link);
}
else{
    mysql_query("INSERT INTO carreras (carr_codigo,carr_descripcion,facultades_facu_codigo) VALUES (".$carr_codigo.",'".$carr_descripcion."',".$facultades_facu_codigo.")");
}

header("Location:carrera.php");		
?>