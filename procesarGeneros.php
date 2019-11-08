<?php
include 'conex.php';
$link=Conectarse();


$gene_codigo = $_POST['id_genero'];
$gene_descripcion = utf8_decode ($_POST['gene_descripcion']);

//$ciudad = mb_strtoupper($ciudad);

if($_POST['modificar']){
    mysql_query('UPDATE generos SET gene_descripcion="'.$gene_descripcion.'" 
    	WHERE gene_codigo='.$gene_codigo.'', $link);
}
else{
    mysql_query("INSERT INTO generos (gene_codigo, gene_descripcion)
     	VALUES (".$gene_codigo.",'".$gene_descripcion."')",$link);
}

header("Location:generos.php");	
mysql_set_charset('utf8');
?>