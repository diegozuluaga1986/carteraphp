<?php
  session_start();
  include("../../conexion.php");
  $cartera=$_SESSION['cartera'];
  $conex=conectarse("cartera");
  $fecha=$_GET['fecha'];
  $consult= "select * from carteras where nombre_car = '$cartera';";
  $result=mysql_query($consult,$conex);
  $mat=mysql_fetch_array($result);
  $cod_cart=$mat['cod_cartera'];
  //Consultar renovados *************************************************************************************************
    $con_reno="select prestamos.num_prestamo, prestamos.num_cliente,";
    $con_reno.=" prestamos.fecha_inicio,"; 
    $con_reno.=" DATE_ADD(prestamos.fecha_inicio, INTERVAL prestamos.num_cuotas DAY) 'fecha_fin',";    
    $con_reno.=" prestamos.monto,";
    $con_reno.=" prestamos.monto_final,";
    $con_reno.=" prestamos.cuota,";
    $con_reno.=" prestamos.num_cuotas, prestamos.orden_ruta, prestamos.cod_cartera, prestamos.dia_abona,";
    $con_reno.=" prestamos.renovado, prestamos.nuevo, prestamos.estado,"; 
    $con_reno.=" clientes.nombre, clientes.profesion, clientes.direccion, clientes.barrio,"; 
    $con_reno.=" clientes.ciudad, clientes.celular, clientes.tel_fijo from";
    $con_reno.=" prestamos, clientes where prestamos.num_cliente=clientes.num_cliente";
    $con_reno.=" and prestamos.cod_cartera=$cod_cart and prestamos.fecha_inicio='$fecha'";
    $con_reno.=" order by orden_ruta;";
    $resul_reno=mysql_query($con_reno,$conex);
    $No=mysql_num_rows($resul_reno);
    $renovados=@mysql_fetch_array($resul_reno);
    do{
      $mont=$mont+$renovados['monto'];
      $clientes_reno[]=$renovados['nombre'];
      //$No=$No+1;
    }while($renovados=@mysql_fetch_array($resul_reno));  
    //Consultar terminados *******************************************************************************************

    $con_ter="select prestamos.num_prestamo, prestamos.fin_pres, prestamos.renovado, prestamos.estado, prestamos.orden_ruta, clientes.nombre";
    $con_ter.=" FROM prestamos, clientes";
    $con_ter.=" WHERE prestamos.num_cliente = clientes.num_cliente AND prestamos.fin_pres = '$fecha' ";
    $con_ter.=" AND prestamos.renovado = '0' AND prestamos.cod_cartera = $cod_cart order by orden_ruta;";
    $resul_ter=mysql_query($con_ter,$conex);
    $terminados=@mysql_fetch_array($resul_ter);
    $t=mysql_num_rows($resul_ter);
    do{
      $clientes_ter[]=$terminados['nombre'];
    }while($terminados=@mysql_fetch_array($resul_ter));  


//Consultar total cobro
    $consulta_cobro="select detalle_movimientos.fecha_m, detalle_movimientos.contador, detalle_movimientos.monto_abono,";
    $consulta_cobro.=" detalle_movimientos.num_prestamo, prestamos.cod_cartera, prestamos.num_cliente, prestamos.orden_ruta, clientes.nombre,";
    $consulta_cobro.=" clientes.num_cliente from detalle_movimientos, prestamos, clientes";
    $consulta_cobro.=" where detalle_movimientos.num_prestamo=prestamos.num_prestamo";
    $consulta_cobro.=" and detalle_movimientos.fecha_m='$fecha' and prestamos.cod_cartera='$cod_cart'";
    $consulta_cobro.=" and prestamos.num_cliente=clientes.num_cliente order by prestamos.orden_ruta;";
    $res_cobro=mysql_query($consulta_cobro,$conex);
    $cobro=mysql_fetch_array($res_cobro); 
    do{
        $total_cobro=$total_cobro+$cobro['monto_abono'];
        if ($cobro['monto_abono']>0) {
          $coteo++; 
        } 
    }while($cobro=mysql_fetch_array($res_cobro));

?>
<html>
  <head>
    <title>Resumen</title>
    <link href="../../resultados.css" rel="stylesheet" type="text/css">
    <link href="../../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
    <script type="text/javascript" src="../../bootstrap2/js/bootstrap.js"></script>
  </head>
  <body>
    <br>
  <H2>Cartera: <?php echo $cartera; ?></H2>
    <br>
    <H3>Fecha: <?php echo $fecha; ?></H3>
    <br>
    <table class="centrado">

      <tr><td class="azul">Total Recaudado</td><td colspan="2"><?php $recaudo=number_format($total_cobro, 0, ",","."); echo $recaudo; ?></td></tr>
      <tr><td class="azul">Monto Renovado</td><td colspan="2"><?php $t_volteos=number_format($mont, 0, ",","."); echo $t_volteos; ?></td></tr>
      <tr><td class="azul">Clientes renovados</td><td><?php echo $No; ?></td><td><?php @print implode('<br />',$clientes_reno);  ?></td></tr>
      <tr><td class="azul">Clientes que cotearon</td><td colspan="2"><?php echo $coteo; ?></td></tr>
      <tr><td class="azul">Clientes que terminaron</td><td><?php echo $t; ?></td><td><?php @print implode('<br />',$clientes_ter); ?></td></tr>
    </table> 
  </body>
  </html> 