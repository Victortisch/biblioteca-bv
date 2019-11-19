<?php
include 'conex.php';
$link= Conectarse();
$tili_codigo = $_POST['id_tipo_libro'];
$tili_descripcion = utf8_decode($_POST['tili_descripcion']);
if($_POST['modificar']){
    mysql_query('UPDATE tipos_libros SET tili_codigo='.$tili_codigo.', tili_descripcion="'.$tili_descripcion.'" WHERE tili_codigo='.$tili_codigo.'',$link);
}
else{

    mysql_query("INSERT INTO tipos_libros (tili_codigo,tili_descripcion) VALUES (".$tili_codigo.",'".
    	$tili_descripcion."')");
}
header("Location:tipos_libros.php");
?>
