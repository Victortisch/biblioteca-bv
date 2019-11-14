<?php
include 'conex.php';
$link=Conectarse();

$pagina = $_POST['pagina'];
$pres_codigo = $_POST['id_prestamo'];
$pres_fecha_s= $_POST['pres_fecha_s'];
$pres_plazo= $_POST['pres_plazo'];

$usuarios_usua_documento= $_POST['usuarios'];
$libros_libr_codigo= $_POST['libros'];

//$ciudad = mb_strtoupper($ciudad);

if($_POST['modificar']){
    mysql_query('UPDATE prestamos SET 
    	pres_fecha_s="'.$pres_fecha_s.'", 
    	pres_plazo='.$pres_plazo.', 
		usuarios_usua_documento='.$usuarios_usua_documento.',
		libros_libr_codigo='.$libros_libr_codigo.'
    	WHERE pres_codigo='.$pres_codigo.'',$link);
}
else{
  mysql_query("INSERT INTO prestamos (pres_codigo, pres_fecha_s, pres_plazo, usuarios_usua_documento, libros_libr_codigo) VALUES (".$pres_codigo.",'".$pres_fecha_s."',".$pres_plazo.",".$usuarios_usua_documento.",".$libros_libr_codigo.")",$link);
    
  // Diminuir la cantidad de ejemplares disponibles del libro prestado
  $cons = mysql_query("SELECT ejemplares_disp AS n FROM libros where libr_codigo = ".$libros_libr_codigo, $link);
  $ejemplares_disp = mysql_fetch_object($cons) ->  n;
  
  mysql_query("UPDATE libros SET ejemplares_disp=".($ejemplares_disp-1)." WHERE libr_codigo=$libros_libr_codigo", $link);
}

header("Location:".$pagina."");		
?>