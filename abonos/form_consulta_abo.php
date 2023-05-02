<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
  date_default_timezone_set ("America/Bogota");
  setlocale (LC_TIME,"spanish");
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
  <br>
<?php
  
  $npres=$_GET['id'];
  if(!(empty($npres)))
  {
    $consulta="select prestamos.num_prestamo, prestamos.num_cliente,";
    $consulta.=" prestamos.fecha_inicio, prestamos.monto, prestamos.num_cuotas,";
    $consulta.=" prestamos.cuota, prestamos.monto_final, prestamos.orden_ruta,";
    $consulta.=" prestamos.cod_cartera,";
    $consulta.=" clientes.nombre from";
    $consulta.=" prestamos, clientes where prestamos.num_prestamo=$npres";
    $consulta.=" and prestamos.num_cliente=clientes.num_cliente; ";
    $resultado=mysql_query($consulta,$conex);
    $matriz=mysql_fetch_array($resultado); 

    $mf=$matriz['cuota']*$matriz['num_cuotas'];

    $consulta2="select detalle_movimientos.num_prestamo, detalle_movimientos.fecha_m, ";
    $consulta2.=" detalle_movimientos.monto_abono from detalle_movimientos";
    $consulta2.=" where detalle_movimientos.num_prestamo=$npres";
    $consulta2.=" order by detalle_movimientos.contador; ";
    $resultado2=mysql_query($consulta2,$conex);
    $matriz2=mysql_fetch_array($resultado2); 

    $suma_abo="select SUM(monto_abono) from detalle_movimientos where num_prestamo=$npres;";
    $resul_sum=mysql_query($suma_abo,$conex);
    $abonado=mysql_result($resul_sum,0);
    $pendiente=$mf-$abonado;
    $abonado=number_format($abonado, 0, ",",".");
    $pendiente=number_format($pendiente, 0, ",",".");

  } 
 
  if(!(empty($resultado)))
  {
    $fi=$matriz['fecha_inicio'];
    $FechaArreglo = explode("-", date("m-d-Y", strtotime($fi)));
    $Fecha = mktime(0, 0, 0, $FechaArreglo[0], $FechaArreglo[1], $FechaArreglo[2]);
    $fi=strftime("%A, %d de %B de %Y", $Fecha);  
    echo"<center>";  
      echo"<table>";
      echo"<tr class='primeralinea'><td class='primeralinea'>No PRESTAMO</td>";
      echo"<td><input type='text' name='num_pres' size='6' value=".$matriz['num_prestamo']." readonly> </tr>";
      echo"<tr><td>NOMBRE</td><td> ".$matriz['nombre']."</td></tr>";
      echo"<tr><td>Fecha prestamo</td><td>".$fi."</td></tr>";
      $number=number_format($matriz['monto'], 0, ",",".");
      echo"<tr><td>Monto</td><td><input type='text' name='monto' size='8' value=".$number." ></td></tr>";
      $number=number_format($matriz['cuota'], 0, ",",".");
      echo"<tr><td>cuota</td><td><input type='text' name='cuota' size='8' value=".$number." ></td></tr>";
      echo"<tr><td>No cuotas</td><td><input type='text' name='ncuo' size='8' value=".$matriz['num_cuotas']." ></td></tr>";
      echo"</table><br>"; 
      echo "<br>";
      echo "<table>";
      echo "<tr class='primeralinea'><td class='primeralinea'>Fecha</td><td class='primeralinea'>Abono</td></tr>";
      do{
        $number=number_format($matriz2['monto_abono'], 0, ",",".");
        $f=$matriz2['fecha_m'];
        $FechaArreglo = explode("-", date("m-d-Y", strtotime($f)));
        $Fecha = mktime(0, 0, 0, $FechaArreglo[0], $FechaArreglo[1], $FechaArreglo[2]);
        $f=strftime("%A, %d de %B de %Y", $Fecha);  
        echo "<tr><td>".$f."</td><td>".$number."</td></tr>";
        echo "<tr><td></td><td></td></tr>";
      }while ($matriz2=@mysql_fetch_array($resultado2)); 
      echo"<tr class='primeralinea'><td class='primeralinea'>Total Abonado</td><td class='primeralinea'>".$abonado."</td></tr>";
      echo"<tr class='primeralinea'><td class='primeralinea'>Saldo Pendiente</td><td class='primeralinea'>".$pendiente."</td></tr>";
      echo"<table>";
      echo"</center>";
      echo "<br><br>";
    }

  
  mysql_close($conex);
?>


  </body>
</html>