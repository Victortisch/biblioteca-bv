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

    while($row = mysql_fetch_array($results)) {
      $prestado = mysql_query("SELECT ejemplares_disp AS n FROM libros where libr_codigo = ".$row["libr_codigo"],$link);
      $ejemplares_disp = mysql_fetch_object($prestado) ->  n;
      $accion = '<a href="#" class="edit" data-toggle="modal" data-target="#myModal" id='.$row['libr_codigo'].'><i class="fa fa-edit"> Editar </i></a>';
        if ($ejemplares_disp > 0) {
          $prestar = '<a href="#" class="edit" data-toggle="modal" data-target="#prestamo" id='.$row['libr_codigo'].'><i class="fa fa-book"> Prestar</i></a>';
        }
        else {
          $prestar = '<i class="fa fa-ban"> Prestado';
        }

        $add = array(
          "0" => $row["libr_codigo"],
          "1" => utf8_encode($row["libr_nombre"]),
          "2" => utf8_encode($row["gene_descripcion"]),
          "3" => utf8_encode($row["auto_nombre"]),
          "4" => utf8_encode($row["tili_descripcion"]),
          "5" => utf8_encode($row["orli_descripcion"]),
          "6" => $ejemplares_disp,
          "7" => $accion,
          "8" => $prestar
        );
        $encode[]=$add;
    }

    $usuarios =mysql_query('SELECT usua_documento, usua_nombre FROM usuarios',$link);
    while ($row1 = mysql_fetch_array($usuarios)) {
    $selectUsuarios.="<option value='".$row1['usua_documento']."'>".utf8_encode($row1['usua_nombre'])."</option>";
    }

    // Obtener la cantidad de libros pendientes de cada usuario
    $cons = mysql_query("
      SELECT usuarios_usua_documento AS doc, count(*) AS cant
      FROM prestamos WHERE pres_fecha_d IS NULL
      GROUP BY usuarios_usua_documento");

    $pendientes = array();
    while ($rwa = mysql_fetch_array($cons)) {
      $user = array(
        "doc" => $rwa["doc"],
        "cant" => $rwa["cant"]
      );
      $pendientes[] = $user;
    }

    $libros = mysql_query('SELECT libr_codigo, libr_nombre FROM libros',$link);
    while ($row2 = mysql_fetch_array($libros)) {
    $selectLibros.="<option value='".$row2['libr_codigo']."'>".utf8_encode($row2['libr_nombre'])."</option>";
    }

    $consulta =mysql_query('SELECT MAX(pres_codigo) as max from prestamos',$link);
    while ($raw = mysql_fetch_array($consulta)) {
    $id_prestamo=$raw['max']+1;
    }

    $generos = mysql_query('SELECT gene_codigo, gene_descripcion FROM generos',$link);
    while($row10 = mysql_fetch_array($generos)) {
    $selectGeneros.="<option value='".$row10['gene_codigo']."'>".utf8_encode($row10['gene_descripcion'])."</option>";
    }

    $autores = mysql_query("SELECT auto_codigo,CONCAT(auto_nombre, ' ', auto_apellido) As auto_nombrecomp FROM autores",$link);
    while($row1 = mysql_fetch_array($autores)) {
    $selectAutores.="<option value='".$row1['auto_codigo']."'>".utf8_encode($row1['auto_nombrecomp'])."</option>";
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
      var pendientes = <?php echo json_encode($pendientes); ?>;
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
                { title: "Ejemplares" },
                { title: "Operaciones" },
                { title: "Prestamos" }
            ]
        } );
        $('#example tbody').on('click', 'tr', function () {
          var data = table.row( this ).data();
          $('#formLibro input[name="id_libro"]').val(data[0]);
          $('#formLibro input[name="libr_nombre"]').val(data[1]);
          $('#formLibro input[name="modificar"]').val(1);

          var gen=data[2];
          $("#generos option").each(function() { this.selected = (this.text == gen); });

          var aut=data[3];
          $("#autores option").each(function() { this.selected = (this.text == aut); });

          var til=data[4];
          $("#tipos_libros option").each(function() { this.selected = (this.text == til); });

          var orl=data[5];
          $("#origenes_libros option").each(function() { this.selected = (this.text == orl); });

          $('#formLibro input[name="ejemp"]').val(data[6]);

          var lib=data[1];
          $("#libros option").each(function() { this.selected = (this.text == lib); });
        });

        //Cambiar valores del formulario para poder agregar un nuevo libro
        $('#nuevo_libro').on('click', function() {
          $('#formLibro input[name="id_libro"]').val("<?php echo $id_libro ?>");
          $('#formLibro input[name="libr_nombre"]').val('');
          $('#formLibro select').each(function () { this.selectedIndex = 0; })
          $('#formLibro input[name="modificar"]').val(0);
        });

        // Comprobar que el usuario que solicita un libro no tenga libros pendientes que devolver
        $('#nuevo_prestamo').click(function(ev) {
          let docu = $('#usuarios').val();
          pendientes.forEach((user) => {
            if (user.doc === docu) {
              let msg = (user.cant == 1) ? '1 libro' : user.cant+' libros'
              $('#mensaje_confirmar').text(`Este usuario aún debe ${msg}, continuar de todas formas?`);
              $('#prestamo').modal('hide');
              $('#modalConfirmar').modal('show');
              ev.preventDefault();
            }
          });
        });

        // Continuar con el préstamo en caso de éste sea confirmado
        $('#confirmar').click(function() {
          $('#formPrestamos').submit();
        });
      });
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
            <h2 style="margin-top:10px">Libros <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal" id=nuevo_libro>Agregar</button></h2>
        </div>

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
                    <label for="libr_nombre">Título</label>
                    <input type="text" class="form-control" id="libr_nombre" name="libr_nombre" placeholder="Título" required value="">
                    <input type="hidden" class="form-control" id="modificar" name="modificar" required value="">
                  </div>
                  <div class="form-group">
                    <label for="ejemp">Ejemplares Disponibles</label>
                    <input type="number" class="form-control" id="ejemp" name="ejemp" min="1" required>
                    <input type="hidden" name="id_libro" placeholder="Código Libro" value="<?php echo $id_libro?>">
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
                    <input type="date" value="<?php echo date('Y-m-d'); ?>" class="form-control" id="pres_fecha_s" name="pres_fecha_s" placeholder="Fecha de Salida" required>
                    <input type="hidden" class="form-control" id="pagina" name="pagina" required value="libros.php">
                  </div>
                  <div class="form-group">
                    <label for="pres_plazo">Plazo</label>
                    <input type="text" class="form-control" id="pres_plazo" name="pres_plazo" placeholder="Plazo" required value="7">
                  </div>
                  <div id="errorMessage">
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="nuevo_prestamo" class="btn btn-primary">Guardar</button>
              </div>
              </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirmación<span id="load" style="display:none"> <img src="img/loading.gif"> Cargando...</span></h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <p id="mensaje_confirmar"></p>
                </div>
                <div id="errorMessage">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button id="confirmar" class="btn btn-primary">Aceptar</button>
              </div>
            </div>
          </div>
        </div>

      <table id="example" class="display cell-border" width="100%"></table>
    </div>
    <footer class="navbar-default navbar-fixed-bottom">
      <div class="container-fluid">
        <span style='text-align:center'>Winning!</span>
      </div>
    </footer>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
