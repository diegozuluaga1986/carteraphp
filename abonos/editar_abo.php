<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
  $contador=$_GET['id'];
  $consul="select * from detalle_movimientos where contador='$contador';";
  $res=mysql_query($consul,$conex);
  $fila=mysql_fetch_array($res);
?>
<html>
  <head><title></title>
    <link href="../resultados.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="../estilo.css" />   
    <script type="text/javascript" src="../bootstrap2/js/bootstrap.js"></script>
  </head>
  <body>  
<br><br>
<center><H2>Modificar Abono</H2></center>
<?php
  if ($contador!="") {
    echo"<center>";  
      echo"<form name='Insertar' method='post' Action='actualiza_abono.php'>";
      echo"<table>";
      echo"<tr><td>Fecha abono:</td>";
      echo"<td><input type='text' name='fec' size='15' value=".$fila['fecha_m']." readonly> </tr>";
      echo"<tr><td class='td_fecha'>CONTADOR</td>";
      echo"<td class='td_fecha'> <input type='text' name='conta' size='15' value=".$contador." readonly></td></tr>";  //contador invisible en navegador    
      echo"<tr><td class='td_fecha'>No prestamo</td>";
      echo"<td class='td_fecha'> <input type='text' name='np' size='15' value=".$fila['num_prestamo']." readonly></td></tr>";  //num_prestamo invisible en navegador 
      echo"<tr><td>Abono:</td><td><input type='text' name='abono' size='9' value=".$fila['monto_abono']."></td>";
      echo"</table><br><br>";
      echo"<input type='submit' class='btn btn-info' value='Modificar'>";
      echo"</form>";
    echo"</center>"; 
  }
  mysql_close($conex);

?>