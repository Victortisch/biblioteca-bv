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
    global $selectCarreras;
    global $id_usuario;

    $results=mysql_query("select u.usua_documento,u.usua_nombre,u.usua_apellido,u.usua_nacimiento,c.carr_descripcion from usuarios u, carreras c where u.carreras_carr_codigo = c.carr_codigo",$link);

    //$results = $bd->query('SELECT ciudades.id_ciudad, carreras.carrera, ciudades.ciudad FROM ciudades, carreras where ciudades.id_carrera=carreras.id_carrera and ciudades.deleted<>1');
    while ($row = mysql_fetch_array($results)) {

        $accion = '<a href="#" class="edit" data-toggle="modal" data-target="#myModal" id='.$row['usua_documento'].'><i class="fa fa-edit"> Editar </i></a><a href="eliminarUsuarios.php?usua_documento='.$row['usua_documento'].'"> <i class="fa fa-trash"> Eliminar</i></a>';
        $add = array(
          "0" => $row["usua_documento"],
          "1" => utf8_encode($row["usua_nombre"]),
          "2" => utf8_encode($row["usua_apellido"]),
          "3" => $row["usua_nacimiento"],
          "4" => $row["usua_contac"],
          "5" =>utf8_encode($row["carr_descripcion"]) ,
          "6" => $accion, //,"id_usuario",
          "usua_documento" => $row["usua_documento"],
          "usua_nombre" => $row["usua_nombre"],
          "usua_apellido" => $row['usua_apellido'],
          "usua_nacimiento" => $row['usua_nacimiento'],
          "usua_contac" => $row['usua_contac'],
          "carreras" => $row['carr_descripcion'],
          "6" => $accion
        );
        $encode[]=$add;
    }

    $carreras = mysql_query('SELECT carr_codigo, carr_descripcion FROM carreras',$link);
    while ($row1 = mysql_fetch_array($carreras)) {
    $selectCarreras.="<option value='".utf8_encode($row1['carr_codigo'])."'>".utf8_encode($row1['carr_descripcion'])."</option>";
    }

    $consulta = mysql_query('SELECT MAX(usua_documento) as max from usuarios',$link);
    while ($ruw = mysql_fetch_array($consulta)) {
    $id_usuario=$ruw['max']+1;
    }
    ?>
    <script>
    var dataSet = <?php echo json_encode($encode);?>;
      $(document).ready(function() {
        var table = $('#example').DataTable({
          //"iDisplayLength": 50,
            data: dataSet,
            columns: [
                { title: "Documento" },
                { title: "Nombre" },
                { title: "Apellido" },
                { title: "Nacimiento" },
				{ title: "Contacto" },
                { title: "Carrera" },
                { title: "Operaciones" }

            ]
        } );
        $('#example tbody').on('click', 'tr', function () {
          var data = table.row( this ).data();
          $('#formUsuarios input[name="usua_documento"]').val(data[0]);
          $('#formUsuarios input[name="usua_nombre"]').val(data[1]);
          $('#formUsuarios input[name="usua_apellido"]').val(data[2]);
          $('#formUsuarios input[name="usua_nacimiento"]').val(data[3]);
		  $('#formUsuarios input[name="usua_contac"]').val(data[4]);
          $('#formUsuarios input[name="modificar"]').val(true);
          var car=data[4];
          $("#carreras option").each(function() { this.selected = (this.text == car); });
        });

        //Cambiar valores del formulario para poder agregar un nuevo usuarie
        $('#nuevo_usua').on('click', function () {
          $('#formUsuarios input[name="usua_documento"]').val('');
          $('#formUsuarios input[name="usua_nombre"]').val('');
          $('#formUsuarios input[name="usua_apellido"]').val('');
          $('#formUsuarios input[name="usua_nacimiento"]').val('');
		  $('#formUsuarios input[name="usua_contac"]').val('');
          $('#formUsuarios input[name="modificar"]').val(0);
          $("#carreras")[0].selectedIndex = 0;
        });
        
      });
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
            <h2 style="margin-top:10px">Usuarios <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">
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
        <h4 class="modal-title" id="myModalLabel">Nuevo Usuario <span id="load" style="display:none"> <img src="img/loading.gif"> Cargando...</span></h4>
      </div>
      <div class="modal-body">
        <form id="formUsuarios" method="post" action="procesarUsuarios.php">
          <div class="form-group">
            <label for="usua_documento">Documento</label>
            <input type="text" class="form-control" id="usua_documento" name="usua_documento" placeholder="Documento" value="<?php echo $id_usuario?>" readonly>
          </div>
          <div class="form-group">
            <label for="usua_nombre">Nombre</label>
            <input type="text" class="form-control" id="usua_nombre " name="usua_nombre" placeholder="Nombre" required value="" style="text-transform:Null">
            <input type="hidden" class="form-control" id="modificar" name="modificar" required value="">
          </div>
          <div class="form-group">
            <label for="usua_apellido">Apellido</label>
            <input type="text" class="form-control" id="usua_apellido" name="usua_apellido" placeholder="Apellido" required value="" style="text-transform:Null">
            <input type="hidden" class="form-control" id="modificar" name="modificar" required value="">
          </div>
          <div class="form-group">
            <label for="usua_nacimiento">Nacimiento</label>
            <input type="date" class="form-control" id="usua_nacimiento" name="usua_nacimiento" placeholder="Nacimiento" required value="" style="text-transform:uppercase">
            <input type="hidden" class="form-control" id="modificar" name="modificar" required value="">
          </div>
          <div class="form-group">
            <label for="carreras">Carrera</label>
                <select class="form-control" name="carreras" id="carreras" required>
                  <option value="">Seleccionar</option>
                    <?php
                    echo $selectCarreras;
                    ?>
                </select>
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
