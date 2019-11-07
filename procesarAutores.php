<?php
include 'conex.php';
$link=Conectarse();
$auto_codigo = $_POST['id_autor'];
$auto_nombre = utf8_decode($_POST['auto_nombre']);
$auto_apellido = utf8_decode($_POST['auto_apellido']);
//$ciudad = utf8_decode($_POST['ciudad']);
//$ciudad = mb_strtoupper($ciudad);

if($_POST['modificar']){
    mysql_query('UPDATE autores SET auto_nombre="'.$auto_nombre.'", auto_apellido="'.$auto_apellido.'" WHERE auto_codigo='.$auto_codigo.'', $link);
}
else{
    mysql_query("INSERT INTO autores (auto_codigo,auto_nombre,auto_apellido) VALUES (".$auto_codigo.",'".$auto_nombre."','".$auto_apellido."')", $link);
}


header("Location:autores.php");		
?>