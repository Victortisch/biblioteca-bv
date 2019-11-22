<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Biblioteca UNAE</title>
    <meta http-equiv='Content-Type' content='text/html'; charset='UTF-8'/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
    <link rel="icon" href="img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/table_style.css">
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

    <?php
    include 'conex.php';
    $link=Conectarse();
    $encode=array();
    global $selectLibros;
    global $selectUsuarios;
    global $id_prestamo;

    $results=mysql_query("select p.pres_codigo,
      p.pres_fecha_s,
      p.pres_plazo,
      p.pres_fecha_d,
      u.usua_nombre,
      l.libr_nombre from prestamos p, usuarios u, libros l
      where p.usuarios_usua_documento = u.usua_documento and p.libros_libr_codigo = l.libr_codigo",$link);

    while ($row = mysql_fetch_array($results)) {
        $accion = '<i class="fa fa-edit"> Editar </i></a><a href="eliminarPrestamos.php?pres_codigo='.$row['pres_codigo'].'">
        <i class="fa fa-trash"> Eliminar</i></a>';

        $add = array("0" => $row["pres_codigo"],
          "1" => $row["pres_fecha_s"],
          "2" => $row["pres_plazo"],
          "3" => $row["pres_fecha_d"],
          "4" => utf8_encode($row["usua_nombre"]),
          "5" => utf8_encode($row["libr_nombre"]),
          "6" => $accion);
          if (is_null($add[3])){
            $add[3] = "Pendiente";
          }

        $encode[]=$add;
    }

    $usuarios =mysql_query('SELECT usua_documento, usua_nombre FROM usuarios',$link);
    while ($row1 = mysql_fetch_array($usuarios)) {
    $selectUsuarios.="<option value='".$row1['usua_documento']."'>".utf8_encode($row1['usua_nombre'])."</option>";
    }

    $libros = mysql_query('SELECT libr_codigo, libr_nombre FROM libros',$link);
    while ($row2 = mysql_fetch_array($libros)) {
    $selectLibros.="<option value='".$row2['libr_codigo']."'>".utf8_encode($row2['libr_nombre'])."</option>";
    }

    $consulta =mysql_query('SELECT MAX(pres_codigo) as max from prestamos',$link);
    while ($ruw = mysql_fetch_array($consulta)) {
    $id_prestamo=$ruw['max']+1;
    }
    ?>

    <script>
    var dataSet = <?php echo json_encode($encode);?>;
      $(document).ready(function() {
        var table = $('#example').DataTable({
            data: dataSet,
            columns: [
                { title: "Código" },
                { title: "Fecha de salida" },
                { title: "Plazo" },
                { title: "Fecha de devolución" },
                { title: "Usuario" },
                { title: "Libro" }
            ]
        } );
    } );
    </script>
    <?php mysql_close($link); ?>
  </head>

  <body>
    <div class="container">
      <nav class="navbar navbar-default">
        <div class="container-fluid"><button type="button" class="btn btn-danger pull-right" onclick="window.location.href='visitas.php'" style="margin-top: 8px; width: 100px">Visitas</button>
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Biblioteca</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Biblioteca</a>
          </div>

          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="inicio.php">Inicio</a></li>
              <li class="dropdown">
                <a href="prestamos.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Prestamos <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="prestamos.php">Historial</a></li>
                <li><a href="prestados.php">Prestados</a></li>
                <li><a href="devueltos.php">Devueltos</a></li>
              </ul>
            </li>

              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Libros <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="libros.php">Libros</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="autores.php">Autores</a></li>
                <li><a href="generos.php">Generos</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="tipos_libros.php">Tipos de Libros</a></li>
                <li><a href="origenes_libros.php">Origenes de Libros</a></li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Usuarios <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="facultades.php">Instituciones</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="usuarios.php">Usuarios</a></li>
            </ul>
          </li>
          </div>
        </div>
      </nav>
        <div class="jumbotron" style="padding-top:2px;padding-bottom:2px;padding-left:15px;padding-right:15px;margin-top:5px;margin-bottom:15px">
            <h2 style="margin-top:10px">Préstamos</h2>
        </div>

      <table id="example" class="display" width="100%"></table>
    </div>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
