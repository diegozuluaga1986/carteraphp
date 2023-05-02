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
<?php
  $cartera=$_SESSION['cartera'];
  if($cartera!=""){
    echo $cartera;
    echo "<br>";
?>    
    <div class="buscar_cliente">
    <center><h4>Resumen</h4>        
    <form name="insertar_fecha" action="resumen_dia.php" method="POST" autocomplete="off">  
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
    $fecha=$_POST['fecha'];
    $consult= "select * from carteras where nombre_car = '$cartera';";
    $result=mysql_query($consult,$conex);
    $mat=@mysql_fetch_array($result);
    echo"<br>";
    $cod_cart=$mat['cod_cartera'];
    $consulta="select prestamos.num_prestamo, prestamos.num_cliente,";
    $consulta.=" prestamos.fecha_inicio,"; 
    $consulta.=" DATE_ADD(prestamos.fecha_inicio, INTERVAL prestamos.num_cuotas DAY) 'fecha_fin',";    
    $consulta.=" prestamos.monto,";
    $consulta.=" prestamos.monto_final,";
    $consulta.=" prestamos.cuota,";
    $consulta.=" prestamos.fin_pres,";
    $consulta.=" prestamos.num_cuotas, prestamos.orden_ruta, prestamos.cod_cartera, prestamos.dia_abona,"; 
    $consulta.=" prestamos.renovado, prestamos.nuevo,";
    $consulta.=" clientes.nombre, clientes.profesion, clientes.direccion, clientes.barrio,"; 
    $consulta.=" clientes.ciudad, clientes.celular, clientes.tel_fijo from";
    $consulta.=" prestamos, clientes where prestamos.num_cliente=clientes.num_cliente";
    $consulta.=" and prestamos.cod_cartera=$cod_cart and prestamos.fin_pres='$fecha' and prestamos.estado='0'";
    $consulta.=" order by orden_ruta;";
    $resultado=mysql_query($consulta,$conex);
    $matriz=@mysql_fetch_array($resultado);  

    $con_nuevos="select prestamos.num_prestamo, prestamos.num_cliente,";
    $con_nuevos.=" prestamos.fecha_inicio,"; 
    $con_nuevos.=" DATE_ADD(prestamos.fecha_inicio, INTERVAL prestamos.num_cuotas DAY) 'fecha_fin',";    
    $con_nuevos.=" prestamos.monto,";
    $con_nuevos.=" prestamos.monto_final,";
    $con_nuevos.=" prestamos.cuota,";
    $con_nuevos.=" prestamos.num_cuotas, prestamos.orden_ruta, prestamos.cod_cartera, prestamos.dia_abona,";
    $con_nuevos.=" prestamos.renovado, prestamos.nuevo, prestamos.estado,"; 
    $con_nuevos.=" clientes.nombre, clientes.profesion, clientes.direccion, clientes.barrio,"; 
    $con_nuevos.=" clientes.ciudad, clientes.celular, clientes.tel_fijo from";
    $con_nuevos.=" prestamos, clientes where prestamos.num_cliente=clientes.num_cliente";
    $con_nuevos.=" and prestamos.cod_cartera=$cod_cart and prestamos.fecha_inicio='$fecha'";
    $con_nuevos.=" order by orden_ruta;";
    $resul_nuevos=mysql_query($con_nuevos,$conex);
    $nuevos=@mysql_fetch_array($resul_nuevos);  

    $con_abonos="select detalle_movimientos.fecha_m, detalle_movimientos.contador, detalle_movimientos.monto_abono,";
    $con_abonos.=" detalle_movimientos.num_prestamo, prestamos.cod_cartera, prestamos.num_cliente, prestamos.orden_ruta, clientes.nombre,";
    $con_abonos.=" clientes.num_cliente from detalle_movimientos, prestamos, clientes";
    $con_abonos.=" where detalle_movimientos.num_prestamo=prestamos.num_prestamo";
    $con_abonos.=" and detalle_movimientos.fecha_m='$fecha' and prestamos.cod_cartera='$cod_cart'";
    $con_abonos.=" and prestamos.num_cliente=clientes.num_cliente order by prestamos.orden_ruta;";
    $r_abonos=mysql_query($con_abonos,$conex);
    $matriz_abonos=mysql_fetch_array($r_abonos);

    if(!(empty($fecha))){
      list($anio, $mes, $dia) = explode("/",$fecha); 
      $dia = mktime(0, 0, 0, date($mes), date($dia), date($anio));
      $dia= strftime("%A, %d de %B de %Y", $dia);
      echo "<h4>".$dia."</h4>";
  ?>
    <br>
    <h4>Terminaron</h4>
    <div class="cuadro">  
      <table>
        <tr class='primeralinea'>
          <td class='primeralinea'>RN</td>
          <td class='primeralinea'>#P</td>
          <td class='primeralinea'>RUTA</td>
          <td class='primeralinea'>NOMBRE</td>
          <td class='primeralinea'>FECHA PRESTAMO</td>
          <td class='primeralinea'>PRESTAMO</td>
          <td class='primeralinea'>CUOTA</td>
          <td class='primeralinea'># CUOTAS</td>
          <td class='primeralinea'>MONTO FINAL</td>
          <td class='primeralinea'>CUOTAS ABONADAS</td>
          <td class='primeralinea'>CUOTAS PENDIENTES</td> 
          <td class='primeralinea'>DIAS MORA</td>  
          <td class='primeralinea'>TOTAL ABONADO</td>
          <td class='primeralinea'>SALDO TOTAL PENDIENTE</td>
        </tr>    
  <?php
    do
    {
      $p=$matriz['num_prestamo'];
      $detalle="select * from detalle_movimientos where num_prestamo=$p;";
      $valid_d=mysql_query($detalle,$conex); 
      $m_det=@mysql_fetch_array($valid_d);
      $cant=@mysql_num_rows($valid_d); 
      $suma=0;   
      do
      {
        $suma=$suma+$m_det['monto_abono'];    
      }while($m_det=@mysql_fetch_array($valid_d));
      @$cuotas=$suma/$matriz['cuota'];
      @$modulo=$suma%$matriz['cuota'];
      @$mod=$modulo/$matriz['cuota'];
      $cuotas=$cuotas-$mod;
      $pendientes=$matriz['num_cuotas']-$cuotas;
      $f=$matriz['fecha_inicio'];
      $fecha_fin=$matriz['fecha_fin'];
      $fin_real=$matriz['fin_pres'];
      $consul_mora="select DATEDIFF('$fin_real','$fecha_fin')";
      $r_conmora=mysql_query($consul_mora,$conex);
      $mora=@mysql_result($r_conmora,0);
      $monto_p=$matriz['monto_final']-$suma;
      $total_abo=$total_abo+$suma;
      $total_p=$total_p+$monto_p;
      $interes=$matriz['monto_final']-$matriz['monto'];
      @$interes_dia=$interes/$matriz['num_cuotas'];
      $int_abo=$interes_dia*$cuotas;
      $abo_ca=$suma-$int_abo;
      $int_p=$interes-$int_abo;
      $cap_p=$matriz['monto']-$abo_ca;
      echo"<tr>\n";
      if ($matriz['renovado']==1) {
        $rn="Si";
      }
      else{
        $rn="No";
      }
      echo"<td> ".$rn."</td>";//Renovado si o no
      echo"<td> ".$matriz['num_prestamo']."</td>";//#PRESTAMO
      echo"<td> ".$matriz['orden_ruta']."</td>";//RUTA
      echo"<td> ".$matriz['nombre']."</td>\n";//NOMBRE
      echo"<td> ".$matriz['fecha_inicio']."</td>\n";//FECHA PRESTAMO
      $number=number_format($matriz['monto'], 0, ",",".");
      echo"<td> $".$number."</td>\n";//PRESTAMO
      $number=number_format($matriz['cuota'], 0, ",",".");
      echo"<td> $".$number."</td>\n";//CUOTA
      echo"<td> ".$matriz['num_cuotas']."</td>\n";//Nº CUOTAS
      $number=number_format($matriz['monto_final'], 0, ",",".");
      echo"<td> $".$number."</td>\n";//MONTO FINAL
      echo"<td> ".$cuotas."</td>\n";//CUOTAS ABONADAS
      echo"<td> ".$pendientes."</td>\n";//CUOTAS PENDIENTES 
      echo"<td> ".$mora."</td>\n";//DIAS DE MORA 
      $suma=number_format($suma, 0, ",",".");
      echo"<td> $".$suma."</td>\n";//TOTAL ABONADO
      $total_sc=$total_sc+$cap_p;
      $total_ip=$total_ip+$int_p;
      $monto_p=number_format($monto_p, 0, ",",".");
      echo"<td> $".$monto_p."</td>\n";//SALDO PENDIENTE
      echo"</tr>\n";
    }while($matriz=@mysql_fetch_array($resultado));
    echo"</table>\n";
?>
    <br>
    <h4>Iniciaron</h4>
    <table>
        <tr class='primeralinea'>
          <td class='primeralinea'>No</td>
          <td class='primeralinea'>EDITAR</td>
          <td class='primeralinea'>RUTA</td>
          <td class='primeralinea'>NOMBRE</td>
          <td class='primeralinea'>FECHA PRESTAMO</td>
          <td class='primeralinea'>PRESTAMO</td>
          <td class='primeralinea'>CUOTA</td>
          <td class='primeralinea'># CUOTAS</td>
          <td class='primeralinea'>MONTO FINAL</td>
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
      echo"<td><a href='modificar_p.php?id=$pp' class='btn btn-info'><img class='icon' src='..//imagenes/b_edit.png' alt='Editar' title='Editar' height='16' width='16'></a></td>";//#PRESTAMO
      echo"<td> ".$nuevos['orden_ruta']."</td>";//RUTA
      echo"<td> ".$nuevos['nombre']."</td>\n";//NOMBRE
      echo"<td> ".$nuevos['fecha_inicio']."</td>\n";//FECHA PRESTAMO
      $number=number_format($nuevos['monto'], 0, ",",".");
      echo"<td> $".$number."</td>\n";//PRESTAMO
      $number=number_format($nuevos['cuota'], 0, ",",".");
      echo"<td> $".$number."</td>\n";//CUOTA
      echo"<td> ".$nuevos['num_cuotas']."</td>\n";//Nº CUOTAS
      $number=number_format($nuevos['monto_final'], 0, ",",".");
      echo"<td> $".$number."</td>\n";//MONTO FINAL
      if ($nuevos['estado']==0) {
        $estado="Terminado";
      }
      if ($nuevos['estado']==1) {
        $estado="Activo";
      }
      if ($nuevos['estado']==2) {
        $estado="Anulado";
      }
      echo"<td>".$estado."</td>\n";//ESTADO
      echo"</tr>\n";
      $No++;
    }while($nuevos=@mysql_fetch_array($resul_nuevos)); 
    $number=number_format($mont, 0, ",","."); 
    echo "<tr class='primeralinea'><td></td><td></td><td></td>";
    echo"<td></td><td class='primeralinea'>Total</td><td class='primeralinea'>$".$number."</td>";
    $number_f=number_format($monto_f, 0, ",",".");
    echo"<td></td><td></td><td class='primeralinea'>$".$number_f."</td><td></td></tr>";  
    echo "</div>";
    echo "<br>";
  }
}  
else{
  echo "<h2>Debe elegir una cartera</h2>";
}  
mysql_close($conex);
?>