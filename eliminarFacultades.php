<?php
include 'conex.php';
$link=Conectarse();

$facu_codigo = $_GET['facu_codigo'];

    mysql_query('DELETE FROM facultades WHERE facu_codigo='.$facu_codigo.'',$link);

header("Location:facultades.php");		
?>