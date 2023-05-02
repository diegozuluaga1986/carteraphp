<?php
  session_start();
  include("../conexion.php");
  $conex=conectarse("cartera");
  date_default_timezone_set ("America/Bogota");
  setlocale (LC_TIME,"spanish");
?>
<!DOCTYPE html>
<html lang="es">  
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title></title>
    <link href="../resultados.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">  
    <link rel="stylesheet" href="../funciones/jquery-ui-1.11.2/jquery-ui.css" />
    <script type="text/javascript" src="../bootstrap2/js/bootstrap.js"></script>
    <script type="text/javascript" src="../funciones/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="../funciones/jquery-ui-1.11.2/jquery-ui.js"></script>
    <script type="text/javascript" src="../funciones/funciones.js"></script>  
  </head>
<body>
  <br>    
    <div class="buscar_cliente">
    <center><h4>Resumen</h4>        
    <form name="insertar_fecha" action="revisar_prestamos.php" method="POST" autocomplete="off">  
      <table>
        <tr>
          <td>Fecha: </td>
          <td class="formulario"><input type="text" style='width:auto' name="fecha" id="calen" size="8"></td>
        </tr> 
        <tr>
          <td colspan="2"><center><input type="submit" class="btn btn-info" value="Ingresar"></center></td>
        </tr>
      </table>
    </form>  
    </center>
    </div>
<?php
    $con_nuevos="select prestamos.num_prestamo, prestamos.num_cliente,";
    $con_nuevos.=" prestamos.fecha_inicio,"; 
    $con_nuevos.=" DATE_ADD(prestamos.fecha_inicio, INTERVAL prestamos.num_cuotas DAY) 'fecha_fin',";    
    $con_nuevos.=" prestamos.monto,";
    $con_nuevos.=" prestamos.monto_final,";
    $con_nuevos.=" prestamos.cuota,";
    $con_nuevos.=" prestamos.num_cuotas, prestamos.orden_ruta, prestamos.cod_cartera, prestamos.dia_abona,";
    $con_nuevos.=" prestamos.renovado, prestamos.nuevo, prestamos.estado,"; 
    $con_nuevos.=" clientes.nombre, clientes.profesion, clientes.direccion, clientes.barrio,"; 
    $con_nuevos.=" clientes.ciudad, clientes.celular, clientes.tel_fijo, carteras.nombre_car from";
    $con_nuevos.=" prestamos, clientes, carteras where prestamos.num_cliente=clientes.num_cliente";
    $con_nuevos.=" and prestamos.fecha_inicio='$fecha' and prestamos.cod_cartera=carteras.cod_cartera";
    $con_nuevos.=" order by cod_cartera;";
    $resul_nuevos=mysql_query($con_nuevos,$conex);
    $nuevos=@mysql_fetch_array($resul_nuevos);  


    /*$con_abonos="select detalle_movimientos.fecha_m, detalle_movimientos.contador, detalle_movimientos.monto_abono,";
    $con_abonos.=" detalle_movimientos.num_prestamo, prestamos.cod_cartera, prestamos.num_cliente, prestamos.orden_ruta, clientes.nombre,";
    $con_abonos.=" clientes.num_cliente from detalle_movimientos, prestamos, clientes";
    $con_abonos.=" where detalle_movimientos.num_prestamo=prestamos.num_prestamo";
    $con_abonos.=" and detalle_movimientos.fecha_m='$fecha' and prestamos.cod_cartera='$cod_cart'";
    $con_abonos.=" and prestamos.num_cliente=clientes.num_cliente order by prestamos.orden_ruta;";
    $r_abonos=mysql_query($con_abonos,$conex);
    $matriz_abonos=mysql_fetch_array($r_abonos);*/

    if(!(empty($fecha))){
      list($anio, $mes, $dia) = explode("/",$fecha); 
      $dia = mktime(0, 0, 0, date($mes), date($dia), date($anio));
      $dia= strftime("%A, %d de %B de %Y", $dia);
      echo "<h4>".$dia."</h4>";
?>
    <br>
    <h4>Iniciaron</h4>
    <center><table>
        <tr class='primeralinea'>
          <td class='primeralinea'>No</td>
          <td class='primeralinea'>EDITAR</td>
          <td class='primeralinea'>RUTA</td>
          <td class='primeralinea'>NOMBRE</td>
          <td class='primeralinea'>PRESTAMO</td>
          <td class='primeralinea'>CUOTA</td>
          <td class='primeralinea'># CUOTAS</td>
          <td class='primeralinea'>MONTO FINAL</td>
          <td class='primeralinea'>CARTERA</td>
          <td class='primeralinea'>ESTADO</td>
        </tr>
<?php
  $No=1;
  do
    {
      $mont=$mont+$nuevos['monto'];
      $monto_f=$monto_f+$nuevos['monto_final'];
      $pp=$nuevos['num_prestamo'];
      echo"<tr>\n";
      echo"<td> ".$No."</td>";//No
      echo"<td><a href='../reportes/modificar_p2.php?id=$pp' class='btn btn-info'><img class='icon' src='..//imagenes/b_edit.png' alt='Editar' title='Editar' height='16' width='16'></a></td>";//#PRESTAMO
      echo"<td> ".$nuevos['orden_ruta']."</td>";//RUTA
      echo"<td> ".$nuevos['nombre']."</td>\n";//NOMBRE
      $number=number_format($nuevos['monto'], 0, ",",".");
      echo"<td align=right><b> $".$number."</b></td>\n";//PRESTAMO
      $number=number_format($nuevos['cuota'], 0, ",",".");
      echo"<td align=right> $".$number."</td>\n";//CUOTA
      echo"<td> ".$nuevos['num_cuotas']."</td>\n";//Nº CUOTAS
      $number=number_format($nuevos['monto_final'], 0, ",",".");
      echo"<td align=right><b> $".$number."</b></td>\n";//MONTO FINAL
      if ($nuevos['estado']==0) {
        $estado="Terminado";
      }
      if ($nuevos['estado']==1) {
        $estado="Activo";
      }
      if ($nuevos['estado']==2) {
        $estado="Anulado";
      }
      echo"<td>".$nuevos['nombre_car']."</td>\n";//CARTERA
      echo"<td>".$estado."</td>\n";//ESTADO
      echo"</tr>\n";
      $No++;
    }while($nuevos=@mysql_fetch_array($resul_nuevos)); 
    $number=number_format($mont, 0, ",","."); 
    echo "<tr class='primeralinea'><td></td><td></td>";
    echo"<td></td><td class='primeralinea'>Total</td><td class='primeralinea'>$".$number."</td>";
    $number_f=number_format($monto_f, 0, ",",".");
    echo"<td></td><td></td><td class='primeralinea'>$".$number_f."</td><td></td><td></td></tr>";  
    echo"</table></center>";
    echo "</div>";
    echo "<br>";
  }
mysql_close($conex);
?>