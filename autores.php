<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv='Content-Type' content='text/html'; charset='UTF-8'/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="img/favicon.ico">

    <title>Biblioteca UNAE</title>
    <!-- Table CSS -->
    <link rel="stylesheet" type="text/css" href="css/table_style.css">
    <!-- Bootstrap core CSS -->
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
    <?php
    
    include 'conex.php';  

     $link=Conectarse();

    $encode=array();
    global $selectDepartamento;
    global $id_autor;

    $results=mysql_query("select * from Autores", $link);

    //$results = $bd->query('SELECT ciudades.id_ciudad, departamentos.departamento, ciudades.ciudad FROM ciudades, departamentos where ciudades.id_departamento=departamentos.id_departamento and ciudades.deleted<>1');
    while($row = mysql_fetch_array($results)) {

        $accion = '<a href="#" class="edit" data-toggle="modal" data-target="#myModal" id='.$row['auto_codigo'].'><i class="fa fa-edit"> Editar </i></a><a href="eliminarAutores.php?auto_codigo='.$row['auto_codigo'].'"> <i class="fa fa-trash"> Eliminar</i></a>';
        $add = array("0" => $row["auto_codigo"],
          "1" => utf8_encode($row["auto_nombre"]),
          "2" => utf8_encode($row["auto_apellido"]),
          "3" => $accion,"id_autor" => $row["auto_codigo"],
          "auto_nombre" => $row["auto_nombre"],
          "auto_apellido" => $row['auto_apellido'],
          "3" => $accion);
        
        $encode[]=$add;
    }

    //$departamentos = $bd->query('SELECT id_departamento, departamento FROM departamentos');
   // while ($raw = $departamentos->fetchArray()) {
    //$selectDepartamento.="<option value='".$raw['id_departamento']."'>".$raw['departamento']."</option>";
    //
  //}

    $consulta = mysql_query('SELECT MAX(auto_codigo) as max from Autores', $link);
     while($ruw = mysql_fetch_array($consulta)) {
    $id_autor=$ruw['max']+1;
    }
    ?>
    <script>
    var dataSet = <?php echo json_encode($encode);?>;
      $(document).ready(function() {
        var table = $('#example').DataTable({
          //"iDisplayLength": 50,
            data: dataSet,
            columns: [
                { title: "Codigo" },
                { title: "Nombre" },
                { title: "Apellido" },
                { title: "Operaciones" }

            ]
        } );
        $('#example tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        $('#formAutor input[name="id_autor"]').val(data[0]);
        $('#formAutor input[name="auto_nombre"]').val(data[1]);
        $('#formAutor input[name="auto_apellido"]').val(data[2]);
        $('#formAutor input[name="modificar"]').val(true);
        var dep=data[1];
        $("#departamento option").each(function() { this.selected = (this.text == dep); });
        
    } );
    } );
    </script>
  </head>

  <body class="dt-example">

    <div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
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
                <a href="prestamos.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Prestamos<span class="caret"></span></a>
                   
              <ul class="dropdown-menu">
                 <li><a href="prestamos.php">Historial</a></li>

                <li><a href="prestados.php">Prestados</a></li>
                <li><a href="devueltos.php">Devueltos</a></li>
              </ul>
            </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Libros<span class="caret"></span></a>
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
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Facultades<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="facultades.php">Facultades</a></li>
                  <li><a href="carrera.php">Carreras</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="usuarios.php">Usuarios</a></li>
            </ul>
          </li>
          
            
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
        <div class="jumbotron" style="padding-top:2px;padding-bottom:2px;padding-left:15px;padding-right:15px;margin-top:5px;margin-bottom:15px">
            <h2 style="margin-top:10px">Autores <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">
  Agregar
</button></h2>
        </div>
        <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Autor <span id="load" style="display:none"> <img src="img/loading.gif"> Cargando...</span></h4>
      </div>
      <div class="modal-body">
        <form id="formAutor" method="post" action="procesarAutores.php">
          <div class="form-group">
            <label for="id_autor">Código Autor</label>
            <input type="text" class="form-control" id="id_autor" name="id_autor" placeholder="Código Autor" value="<?php echo $id_autor?>" readonly>
          </div>
          <div class="form-group">
            <label for="auto_nombre">Nombre</label>
            <input type="text" class="form-control" id="auto_nombre" name="auto_nombre" placeholder="Nombre" required value="" style="text-transform: Capitalize">
            <input type="hidden" class="form-control" id="modificar" name="modificar" required value="">
          </div>
          <div class="form-group">
            <label for="auto_apellido">Apellido</label>
            <input type="text" class="form-control" id="auto_apellido" name="auto_apellido" placeholder="Apellido" required value="" style="text-transform: Capitalize">
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
     <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
