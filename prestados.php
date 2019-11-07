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
    date_default_timezone_set('America/Asuncion');

    $encode=array();
    global $selectLibros;
    global $selectUsuarios;
    global $id_prestamo;

    $results=mysql_query("select p.pres_codigo,
      p.pres_fecha_s,
      p.pres_plazo,
      u.usua_nombre,
      l.libr_nombre,
      u.usua_contac from prestamos p, usuarios u, libros l 
      where p.usuarios_usua_documento = u.usua_documento
      and p.libros_libr_codigo = l.libr_codigo
      and (pres_fecha_d is NULL or pres_fecha_d = '')",$link);


    //$results = $bd->query('SELECT ciudades.id_ciudad, departamentos.departamento, ciudades.ciudad FROM ciudades, departamentos where ciudades.id_departamento=departamentos.id_departamento and ciudades.deleted<>1');
    while ($row = mysql_fetch_array($results)) {

        $accion = '<a href="#" class="edit" data-toggle="modal" data-target="#myModal" id='.$row['pres_codigo'].'>
        <i class="fa fa-edit"> Editar</i></a><a href="devolver.php?pres_codigo='.$row['pres_codigo'].'"> 
        <i class="fa fa-reply"> Devolver</i></a>';
        
        $add = array("0" => $row["pres_codigo"],
          "1" => $row["pres_fecha_s"],
          "2" => $row["pres_plazo"],
          "3" => $row["usua_nombre"],
          "4" => $row["libr_nombre"],
          "5" => $row["usua_contac"],
          "6" => $accion,"id_prestamo" => $row["pres_codigo"],
          "pres_fecha_s" => $row["pres_fecha_s"],
          "pres_plazo" => $row['pres_plazo'],
          "usuarios" => $row['usua_nombre'],
          "libros" => $row['libr_nombre'],
          "usuarios" => $row['usua_contac'],
          "6" => $accion);
        
        $encode[]=$add;
    }

    $usuarios =mysql_query('SELECT usua_documento, usua_nombre, usua_contac FROM usuarios',$link);
    while ($row1 = mysql_fetch_array($usuarios)) {
    $selectUsuarios.="<option value='".$row1['usua_documento']."'>".$row1['usua_nombre']."</option>";
    }

    $libros = mysql_query('SELECT libr_codigo, libr_nombre FROM libros',$link);
    while ($row2 = mysql_fetch_array($libros)) {
    $selectLibros.="<option value='".$row2['libr_codigo']."'>".$row2['libr_nombre']."</option>";
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
          //"iDisplayLength": 50,
            data: dataSet,
            columns: [
                { title: "Código" },
                { title: "Fecha de salida" },
                { title: "Plazo" },
                { title: "Usuario" },
                { title: "Libro" },
                { title: "Contacto" },
                { title: "Operaciones" }

            ]
        } );
        $('#example tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        $('#formPrestamos input[name="id_prestamo"]').val(data[0]);
        $('#formPrestamos input[name="pres_fecha_s"]').val(data[1]);
        $('#formPrestamos input[name="pres_plazo"]').val(data[2]);
        $('#formPrestamos input[name="modificar"]').val(true);


        var usuario=data[3];
        $("#usuarios option").each(function() { this.selected = (this.text == usuario); });
        var libro=data[4];
        $("#libros option").each(function() { this.selected = (this.text == libro); });
        var usuario=data[5];
        $("#usuarios option").each(function() { this.selected = (this.text == usuario); });

    } );
    } );
      //segunda clase
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
            <a class="navbar-brand" href="inicio.php">Biblioteca</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
            <li><a href="inicio.php">Inicio</a></li>
              <li class="dropdown">
                <a href="prestamos.php" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Prestamos<span class="caret"></span></a>
              <ul class="dropdown-menu">
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
            <h2 style="margin-top:10px">Prestados </h2>
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
