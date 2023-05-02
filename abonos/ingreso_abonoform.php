<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
?>
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
      <title></title>
      <link href="../resultados.css" rel="stylesheet" type="text/css">    
      <link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
      <link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" media="screen" href="../estilo.css" />   
      <link rel="stylesheet" href="../funciones/jquery-ui-1.11.2/jquery-ui.css" />
      <script type="text/javascript" src="../bootstrap2/js/bootstrap.js"></script>
      <script type="text/javascript" src="../funciones/jquery-1.11.2.js"></script>
      <script type="text/javascript" src="../funciones/jquery-ui-1.11.2/jquery-ui.js"></script>
      <script type="text/javascript" src="../funciones/funciones.js"></script>
    </head>
  <body>  
  <br>
<?php
  
  $npres=$_GET['id'];
  if(!(empty($npres)))
  {
    echo"<center>";  
    echo"<h3>Ingreso de abono individual</h3>";
    echo"<form name='Insertar' method='post' Action='ingreso_abono_indep.php'>";
    echo"<table>";
    echo"<tr class='primeralinea'><td class='primeralinea'>No PRESTAMO</td>";
    echo"<td><input type='text' name='np' size='8' value=".$npres." readonly></td></tr>";
    echo"<tr><td>Fecha: </td><td class='formulario'><input type='text' name='date' id='calen' size='10'></td>
            </tr>";
    echo"<tr><td>Abono: </td><td><input type='text' name='cuota' size='8' ></td></tr>";
    echo"</table><br>";
    echo"<input type='submit' class='btn btn-info' value='Agregar'>";
    echo"</form>";
    echo"</center>";  
  }
  mysql_close($conex);
 
?>


  </body>
</html>

