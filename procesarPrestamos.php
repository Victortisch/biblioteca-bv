<?php
include 'conex.php';
$link=Conectarse();

$pagina = $_POST['pagina'];
$pres_codigo = $_POST['id_prestamo'];
$pres_fecha_s= $_POST['pres_fecha_s'];
$pres_plazo= $_POST['pres_plazo'];

$usuarios_usua_documento= $_POST['usuarios'];
$libros_libr_codigo= $_POST['libros'];
$usuarios_usua_contac= $_POST['usuarios'];

//$ciudad = mb_strtoupper($ciudad);

if($_POST['modificar']){
    mysql_query('UPDATE prestamos SET 
    	pres_fecha_s="'.$pres_fecha_s.'", 
    	pres_plazo='.$pres_plazo.', 
		usuarios_usua_documento='.$usuarios_usua_documento.',
		libros_libr_codigo='.$libros_libr_codigo.',
		usuarios_usua_contac='.$usuarios_usua_contac.'
    	WHERE pres_codigo='.$pres_codigo.'',$link);
}
else{
     mysql_query("INSERT INTO prestamos (pres_codigo,pres_fecha_s,pres_plazo,usuarios_usua_documento,libros_libr_codigo,usuarios_usua_contac) 
     	 VALUES (".$pres_codigo.",'".$pres_fecha_s."',".$pres_plazo.",".$usuarios_usua_documento.",".$libros_libr_codigo.",".$usuarios_usua_contac.")",$link);
}


header("Location:".$pagina."");		
?>