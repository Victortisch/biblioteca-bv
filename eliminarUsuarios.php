<?php
include 'conex.php';
$link=Conectarse();

$usua_documento = $_GET['usua_documento'];

    mysql_query('DELETE FROM usuarios WHERE usua_documento='.$usua_documento.'',$link);

header("Location:usuarios.php");		
?>