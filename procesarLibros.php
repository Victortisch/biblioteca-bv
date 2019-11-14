<?php
include 'conex.php';
$link=Conectarse();
$libr_codigo = $_POST['id_libro'];
$libr_nombre = utf8_decode($_POST['libr_nombre']);
$generos_gene_codigo = $_POST['generos'];
$autores_auto_codigo = $_POST['autores'];
$tipos_libros_tili_codigo = $_POST['tipos_libros'];
$origenes_libros_orli_codigo = $_POST['origenes_libros'];
$ejemp_disp = $_POST["ejemp"];
//$ciudad = mb_strtoupper($ciudad);

if($_POST['modificar']){
    mysql_query("
    	UPDATE libros 
    	SET libr_nombre = '$libr_nombre', 
    	generos_gene_codigo = $generos_gene_codigo, 
    	autores_auto_codigo = $autores_auto_codigo,
    	tipos_libros_tili_codigo = $tipos_libros_tili_codigo,
    	origenes_libros_orli_codigo = $origenes_libros_orli_codigo,
    	ejemplares_disp = $ejemp_disp
    	WHERE libr_codigo = $libr_codigo",$link);
}
else{
    mysql_query("
    	INSERT INTO libros (
    	libr_codigo, libr_nombre, generos_gene_codigo, autores_auto_codigo, 
    	tipos_libros_tili_codigo, origenes_libros_orli_codigo, ejemplares_disp) 
    	VALUES ($libr_codigo, '$libr_nombre', $generos_gene_codigo, 
    	$autores_auto_codigo, $tipos_libros_tili_codigo, 
    	$origenes_libros_orli_codigo, $ejemp_disp)", $link);
}


header("Location:libros.php");		
?>



