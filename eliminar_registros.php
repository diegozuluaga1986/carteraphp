<?php
  session_start();
  include("conexion.php");
  $cartera=$_SESSION['cartera'];
  $conex=conectarse("cartera");
  $contador=$_POST['cont'];
  $np=$_POST['np'];
  $p=$_POST['p'];
  $registros=count($contador);
  $x=0;
  $prestamos=count($p);
  $z=0;

?>
<html>
  <head>
    <title>Registro abonos</title>
    <link href="resultados.css" rel="stylesheet" type="text/css">
    <link href="bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
    <script type="text/javascript" src="bootstrap2/js/bootstrap.js"></script>
  </head>
  <body>
<?php
	do
	{
		$eliminar="delete from detalle_movimientos where detalle_movimientos.contador='$contador[$x]';";
		$r_eli=mysql_query($eliminar,$conex);
    $actualizar="update prestamos set estado='1', fin_pres='NULL' where num_prestamo='$np[$x]';";
    $r_actual=mysql_query($actualizar,$conex);
		$x=$x+1;

	}while($x<$registros);

  do
  {
    $anular="delete from prestamos where prestamos.num_prestamo='$p[$z]';";
    $r_anular=mysql_query($anular,$conex);
    $z=$z+1;
  }while($z<$prestamos);
	if($r_eli)
  	{
	    echo "<script>";
	    echo "window.alert('¡¡¡ LOS REGISTROS HAN SIDO BORRADOS....¡¡¡¡');";
	    echo "document.location='corregir_fatal_error.php';";
	    echo "</script>";
	}    
?>
