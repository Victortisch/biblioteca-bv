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
    date_default_timezone_set('America/Asuncion');
    $link=Conectarse();

    $encode=array();
    global $selectGeneros;
    global $selectAutores;
    global $selectTiposLibros;
    global $selectOrigenesLibros;
    global $selectUsuarios;
    global $selectLibros;
    global $id_libro;
    global $id_prestamo;
 
    $results=mysql_query("select l.libr_codigo,l.libr_nombre,g.gene_descripcion,CONCAT(a.auto_nombre, ' ', a.auto_apellido) As auto_nombre ,t.tili_descripcion,o.orli_descripcion from libros l, generos g, autores a, tipos_libros t, origenes_libros o where l.generos_gene_codigo = g.gene_codigo and l.autores_auto_codigo = a.auto_codigo and l.tipos_libros_tili_codigo = t.tili_codigo and l.origenes_libros_orli_codigo = o.orli_codigo",$link);
   
    //$results = $bd->query('SELECT ciudades.id_ciudad, departamentos.departamento, ciudades.ciudad FROM ciudades, departamentos where ciudades.id_departamento=departamentos.id_departamento and ciudades.deleted<>1');
    while($row = mysql_fetch_array($results)) { 

        $prestado=mysql_query("SELECT l.libr_codigo FROM libros l, prestamos p WHERE l.libr_codigo = ".$row['libr_codigo']." AND p.libros_libr_codigo = l.libr_codigo AND pres_fecha_d is null ORDER BY libr_codigo DESC LIMIT 1",$link);

        $accion = '<a href="#" class="edit" data-toggle="modal" data-target="#myModal" id='.$row['libr_codigo'].'><i class="fa fa-edit"> Editar </i></a><a href="eliminarLibros.php?libr_codigo='.$row['libr_codigo'].'"> <i class="fa fa-trash"> Eliminar</i></a>';
        if (mysql_num_rows($prestado)==0) {$prestar = '<a href="#" class="edit" data-toggle="modal" data-target="#prestamo" id='.$row['libr_codigo'].'><i class="fa fa-book"> Prestar</i></a>';}
        else {
          $prestar = '<i class="fa fa-ban"> Prestado';
        }
        $add = array("0" => $row["libr_codigo"],
          "1" => utf8_encode($row["libr_nombre"]),
          "2" => utf8_encode($row["gene_descripcion"]),
          "3" => utf8_encode($row["auto_nombre"]),
          "4" =>utf8_encode( $row["tili_descripcion"]),
          "5" =>utf8_encode($row["orli_descripcion"]),
          "6" => $accion,
          "7" => $prestar,"id_libro" => $row["libr_codigo"],
          "libr_nombre" => $row["libr_nombre"],
          "generos" => $row['gene_descripcion'],
          "autores" => $row['auto_nombre'],
          "tipos_libros" => $row['tili_descripcion']
          ,"origenes_libros" => $row['orli_descripcion'],
          "6" => $accion,"7" => $prestar);
        
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
    while ($raw = mysql_fetch_array($consulta)) {
    $id_prestamo=$raw['max']+1;
    }
    //aqui esta la ventana modal de agregar

    $generos = mysql_query('SELECT gene_codigo, gene_descripcion FROM generos',$link);
    while($row10 = mysql_fetch_array($generos)) { 
    $selectGeneros.="<option value='".$row10['gene_codigo']."'>".utf8_encode($row10['gene_descripcion'])."</option>";
    }

    $autores = mysql_query("SELECT auto_codigo,CONCAT(auto_nombre, ' ', auto_apellido) As auto_nombre FROM autores",$link);
    while($row1 = mysql_fetch_array($autores)) { 
    $selectAutores.="<option value='".$row1['auto_codigo']."'>".utf8_encode($row1['auto_nombre'])."</option>";
    }
    $tipos_libros = mysql_query('SELECT tili_codigo, tili_descripcion FROM tipos_libros',$link);
    while($row2 = mysql_fetch_array($tipos_libros)) { 
    $selectTiposLibros.="<option value='".$row2['tili_codigo']."'>".utf8_encode($row2['tili_descripcion'])."</option>";
    }
    $origenes_libros = mysql_query('SELECT orli_codigo, orli_descripcion FROM origenes_libros',$link);
    while($row3 = mysql_fetch_array($origenes_libros)) { 
    $selectOrigenesLibros.="<option value='".$row3['orli_codigo']."'>".utf8_encode($row3['orli_descripcion'])."</option>";
    }

    $consulta = mysql_query('SELECT MAX(libr_codigo) as max from libros',$link);
    while($ruw = mysql_fetch_array($consulta)) { 
    $id_libro=$ruw['max']+1;
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
                { title: "Libro" },
                { title: "Genero" },
                { title: "Autor" },
                { title: "Tipo" },
                { title: "Origen" },
                { title: "Operaciones" },
                { title: "Prestamos" }
            ]
        } );
        $('#example tbody').on('click', 'tr', function () {
          var data = table.row( this ).data();
          $('#formLibro input[name="id_libro"]').val(data[0]);
          $('#formLibro input[name="libr_nombre"]').val(data[1]);
          $('#formLibro input[name="modificar"]').val(true);
          var gen=data[2];
   
          $("#generos option").each(function() { this.selected = (this.text == gen); });
          var aut=data[3];
          $("#autores option").each(function() { this.selected = (this.text == aut); });
          var til=data[4];
          $("#tipos_libros option").each(function() { this.selected = (this.text == til); });
          var orl=data[5];
          $("#origenes_libros option").each(function() { this.selected = (this.text == orl); });
          var lib=data[1];
          console.log(lib);
          $("#libros option").each(function() { this.selected = (this.text == lib); });
        });

        //Cambiar valores del formulario para poder agregar un nuevo libro
        $('#nuevo_libro').on('click', function() {
          $('#formLibro input[name="id_libro"]').val("<?php echo $id_libro ?>");
          $('#formLibro input[name="libr_nombre"]').val('');
          $('#formLibro select').each(function () { this.selectedIndex = 0; })
          $('#formLibro input[name="modificar"]').val(false);
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
            <h2 style="margin-top:10px">Libros <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">
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
        <h4 class="modal-title" id="myModalLabel">Nuevo Libro <span id="load" style="display:none"> <img src="img/loading.gif"> Cargando...</span></h4>
      </div>
      <div class="modal-body">
        <form id="formLibro" method="post" action="procesarLibros.php">
          <div class="form-group">
            <label for="id_libro">Código Libro</label>
            <input type="text" class="form-control" id="id_libro" name="id_libro" placeholder="Código Libro" value="<?php echo $id_libro?>" readonly>
          </div>
          <div class="form-group">
            <label for="libr_nombre">Libro</label>
            <input type="text" class="form-control" id="libr_nombre" name="libr_nombre" placeholder="Libro" required value="" style="text-transform:null">
            <input type="hidden" class="form-control" id="modificar" name="modificar" required value="">
          </div>
          <div class="form-group">
            <label for="generos">Generos</label>
                <select class="form-control" name="generos" id="generos" required>
                  <option value="">Seleccionar</option>
                    <?php
                    echo $selectGeneros;
                    ?>
                </select>
          </div>
          <div class="form-group">
            <label for="autores">Autores</label>
                <select class="form-control" name="autores" id="autores" required>
                  <option value="">Seleccionar</option>
                    <?php
                    echo $selectAutores;
                    ?>
                </select>
          </div>
          <div class="form-group">
            <label for="tipos_libros">Tipos de Libros</label>
                <select class="form-control" name="tipos_libros" id="tipos_libros" required>
                  <option value="">Seleccionar</option>
                    <?php
                    echo $selectTiposLibros;
                    ?>
                </select>
          </div>
          <div class="form-group">
            <label for="origenes_libros">Origen de Libro</label>
                <select class="form-control" name="origenes_libros" id="origenes_libros" required>
                  <option value="">Seleccionar</option>
                    <?php
                    echo $selectOrigenesLibros;
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
<div class="modal fade" id="prestamo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Prestamo <span id="load" style="display:none"> <img src="img/loading.gif"> Cargando...</span></h4>
      </div>
      <div class="modal-body">
        <form id="formPrestamos" method="post" action="procesarPrestamos.php">

          <div class="form-group">
            <label for="id_prestamo">Código Préstamo</label>
            <input type="text" class="form-control" id="id_prestamo" name="id_prestamo" placeholder="Código" value="<?php echo $id_prestamo?>" readonly>
          </div>
          <div class="form-group">
            <label for="usuarios">Usuarios</label>
                <select class="form-control" name="usuarios" id="usuarios" required>
                  <option value="">Seleccionar</option>
                    <?php
                    echo $selectUsuarios;
                    ?>
                </select>
          </div>
          <div class="form-group">
            <label for="libros">Libros</label>
                <select class="form-control" name="libros" id="libros" required>
                  <option value="">Seleccionar</option>
                    <?php
                    echo $selectLibros;
                    ?>
                </select>
          </div>
          <div class="form-group">
            <label for="pres_fecha_s">Fecha de salida</label>
            <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="pres_fecha_s" name="pres_fecha_s" placeholder="Fecha de Salida" required style="text-transform:null">
            <input type="hidden" class="form-control" id="pagina" name="pagina" required value="libros.php">
          </div>
          <div class="form-group">
            <label for="pres_plazo">Plazo</label>
            <input type="text" class="form-control" id="pres_plazo" name="pres_plazo" placeholder="Plazo" required value="7" style="text-transform:null">
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
    <footer class="navbar-default navbar-fixed-bottom">
      <div class="container-fluid">
        <span style='text-align:center'>Winning!</span>
      </div>
    </footer>
     <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
