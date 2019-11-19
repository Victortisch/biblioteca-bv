<?php
include 'conex.php';
$link=Conectarse();
$usua_documento = $_POST['usua_documento'];
$usua_nombre = utf8_decode($_POST['usua_nombre']);
$usua_apellido = utf8_decode($_POST['usua_apellido']);
$usua_nacimiento = $_POST['usua_nacimiento'];
$usua_contac = $_POST['usua_contac'];
$carreras_carr_codigo = $_POST['carreras'];
if($_POST['modificar']){
    mysql_query('UPDATE usuarios SET usua_nombre="'.$usua_nombre.'",usua_apellido="'.$usua_apellido.'",usua_nacimiento="'.$usua_nacimiento.'",usua_contac="'.$usua_contac.'",carreras_carr_codigo='.$carreras_carr_codigo.' WHERE usua_documento='.$usua_documento.'',$link);
}
else{
    mysql_query("INSERT INTO usuarios (usua_documento,usua_nombre,usua_apellido,usua_nacimiento,usua_contac,carreras_carr_codigo) VALUES (".$usua_documento.",'".$usua_nombre."','".$usua_apellido."','".$usua_nacimiento."','".$usua_contac."',".$carreras_carr_codigo.")",$link);
   }
header("Location:usuarios.php");
?>
