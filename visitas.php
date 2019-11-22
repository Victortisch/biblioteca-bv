<!DOCTYPE html>
<html lang="es">
  <head>
    <title>Biblioteca Bella Vista</title>
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
    $results=mysql_query("select * from visitas ORDER BY vita_id DESC", $link);

    while($row = mysql_fetch_array($results)) {

        $add = array("0" => utf8_encode($row["vita_fecha"]),
        "1" => utf8_encode($row["vita_nombre"]),
        "2" => $row["vita_motivo"]);
        $encode[]=$add;
    }

    $consulta = mysql_query('SELECT MAX(vita_id) as max from visitas', $link);
     while($ruw = mysql_fetch_array($consulta)) {
    $vita_id=$ruw['max']+1;
    }
    ?>

    <script>
    var dataSet = <?php echo json_encode($encode);?>;
      $(document).ready(function() {
        var table = $('#example').DataTable({
          "ordering": false,
          data: dataSet,
          columns: [
            { title: "Fecha"},
            { title: "Nombre" },
            { title: "Motivo" }
          ]
        });

        $('#nuevo_autor').on('click', function() {
          $('#formAutor input[name="vita_id"]').val("<?php echo $vita_id ?>");
          $('#formAutor input[name="vita_nombre"]').val('');
          $('#formAutor input[name="vita_motivo"]').val('');
        });
      });
    </script>
    <?php mysql_close($link);?>
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
            <h2 style="margin-top:10px">Visitas <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal" id="nuevo_autor">Agregar</button></h2>
        </div>

      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Nueva Visita <span id="load" style="display:none"> <img src="img/loading.gif"> Cargando...</span></h4>
            </div>
            <div class="modal-body">
              <form id="formAutor" method="post" action="procesarVisitas.php">
                <div class="form-group">
                  <input type="hidden" class="form-control" id="vita_id" name="vita_id" value="<?php echo $vita_id?>">
                </div>
                <div class="form-group">
                    <label for="vita_fecha">Fecha</label>
                    <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="vita_fecha" name="vita_fecha" readonly>
                  </div>
                <div class="form-group">
                  <label for="vita_nombre">Nombre</label>
                  <input type="text" class="form-control" id="vita_nombre" name="vita_nombre" placeholder="Nombre" required value="">
                </div>
                <div class="form-group">
                  <label for="vita_motivo">Motivo</label>
                  <input type="text" class="form-control" id="vita_motivo" name="vita_motivo" placeholder="Motivo" required value="">
                </div>
                <div id="errorMessage">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <table id="example" class="display" width="100%"></table>
      </div>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
