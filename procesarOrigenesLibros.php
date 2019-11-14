<?php
include 'conex.php';
$link=Conectarse();
$orli_codigo = $_POST['id_origen_libro'];
$orli_descripcion = utf8_decode($_POST['orli_descripcion']);
//$ciudad = mb_strtoupper($ciudad);
if($_POST['modificar']){
    mysql_query('UPDATE origenes_libros SET orli_descripcion="'.$orli_descripcion.'" WHERE orli_codigo='.$orli_codigo.'', $link);
}
else{
    mysql_query("INSERT INTO origenes_libros (orli_codigo,orli_descripcion) VALUES (".$orli_codigo.",'".$orli_descripcion."')", $link);
}
header("Location:origenes_libros.php");		
?>