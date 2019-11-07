<?php
include 'conex.php';
$link=Conectarse();
$gene_codigo = $_GET['gene_codigo'];

    mysql_query('DELETE from generos WHERE gene_codigo='.$gene_codigo.'', $link);

header("Location:generos.php");		
?>