<?php
include 'conex.php';
$link=Conectarse();
$carr_codigo = $_GET['carr_codigo'];

    mysql_query('DELETE FROM carreras WHERE carr_codigo='.$carr_codigo.'', $link);

header("Location:carrera.php");		
?>