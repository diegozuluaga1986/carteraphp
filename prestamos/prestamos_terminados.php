<?php
  session_start();
  include("../conexion.php");
  $conex=conectarse("cartera");
?>
<!DOCTYPE html>
<html lang="es">  
<head>
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
    echo "<h3>Prestamos terminados cartera ".$cartera."</h3>";
    echo "<br>";
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
    $consulta.=" prestamos.dia_abona,";
    $consulta.=" prestamos.fin_pres,";
    $consulta.=" prestamos.num_cuotas, prestamos.orden_ruta, prestamos.cod_cartera, prestamos.dia_abona,"; 
    $consulta.=" clientes.nombre, clientes.cedula, clientes.profesion, clientes.direccion, clientes.barrio,"; 
    $consulta.=" clientes.ciudad, clientes.celular, clientes.tel_fijo from";
    $consulta.=" prestamos, clientes where prestamos.num_cliente=clientes.num_cliente";
    $consulta.=" and prestamos.cod_cartera=$cod_cart and prestamos.estado ='0'";
    $consulta.=" order by orden_ruta;";
    $resultado=mysql_query($consulta,$conex);
    $matriz=@mysql_fetch_array($resultado);  
?>
<table>
<tr class='primeralinea'>
  <td class='primeralinea'>#</td>
  <td class='primeralinea'>RUTA</td>
  <td class='primeralinea'>NOMBRE</td>
  <td class='primeralinea'>CEDULA</td>
  <td class='primeralinea'>FECHA INICIO</td>
  <td class='primeralinea'>FECHA FIN</td>
  <td class='primeralinea'>PRESTAMO</td>
  <td class='primeralinea'>CUOTA</td>
  <td class='primeralinea'>No CUOTAS</td>
  <td class='primeralinea'>MONTO FINAL</td>
  <td class='primeralinea'>DIA ABONO</td>
  <td class='primeralinea'>CUOTAS ABONADAS</td>
  <td class='primeralinea'>CUOTAS PENDIENTES</td> 
  <td class='primeralinea'>DIAS MORA</td>  
  <td class='primeralinea'>ABONADO A CAPITAL</td> 
  <td class='primeralinea'>ABONADO A INTERES</td>
  <td class='primeralinea'>TOTAL ABONADO</td>
  <td class='primeralinea'>SALDO DE CAPITAL</td>
  <td class='primeralinea'>SALDO DE INTERES</td>
  <td class='primeralinea'>SALDO TOTAL PENDIENTE</td>
 </tr>	
<?php
 $sumatoria=0;
 $total_abo=0;
 $total_p=0;
 $total_sc=0;
 $total_ip=0;
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
   $cuotas=$suma/$matriz['cuota'];
   $modulo=$suma%$matriz['cuota'];
   $mod=$modulo/$matriz['cuota'];
   $cuotas=$cuotas-$mod;
   $pendientes=$matriz['num_cuotas']-$cuotas;
   $consul_mora="select * from detalle_movimientos where num_prestamo=$p and monto_abono='0';";
   $res_cm=mysql_query($consul_mora,$conex);
   $mora=@mysql_num_rows($res_cm);  
   $monto_p=$matriz['monto_final']-$suma;
   $total_abo=$total_abo+$suma;
   $total_p=$total_p+$monto_p;
   $interes=$matriz['monto_final']-$matriz['monto'];
   $interes_dia=$interes/$matriz['num_cuotas'];
   $int_abo=$interes_dia*$cuotas;
   $abo_ca=$suma-$int_abo;
   $int_p=$interes-$int_abo;
   $cap_p=$matriz['monto']-$abo_ca;
   echo"<tr>\n";
   echo"<td> ".$matriz['num_prestamo']."</td>";//RUTA
   echo"<td> ".$matriz['orden_ruta']."</td>";//RUTA
   echo"<td> ".$matriz['nombre']."</td>\n";//NOMBRE
   echo"<td> ".$matriz['cedula']."</td>\n";//CEDULA
   echo"<td> ".$matriz['fecha_inicio']."</td>\n";//FECHA INICIO
   echo"<td> ".$matriz['fin_pres']."</td>\n";//FECHA TERMINO
   $number=number_format($matriz['monto'], 0, ",",".");
   echo"<td> $".$number."</td>\n";//PRESTAMO
   $number=number_format($matriz['cuota'], 0, ",",".");
   echo"<td> $".$number."</td>\n";//CUOTA
   echo"<td> ".$matriz['num_cuotas']."</td>\n";//Nº CUOTAS
   $number=number_format($matriz['monto_final'], 0, ",",".");
   echo"<td> $".$number."</td>\n";//MONTO FINAL
   echo"<td>".$matriz['dia_abona']."</td>\n";//DIA ABONA
   echo"<td> ".$cuotas."</td>\n";//CUOTAS ABONADAS
   echo"<td> ".$pendientes."</td>\n";//CUOTAS PENDIENTES 
   echo"<td> ".$mora."</td>\n";//DIAS DE MORA 
   $number=number_format($abo_ca, 0, ",",".");
   echo"<td> ".$number."</td>\n";//ABONADO A CAPITAL
   $number=number_format($int_abo, 0, ",",".");
   echo"<td> ".$number."</td>\n";//ABONADO A INTERES
   $suma=number_format($suma, 0, ",",".");
   echo"<td> $".$suma."</td>\n";//TOTAL ABONADO
   $number=number_format($cap_p, 0, ",",".");
   echo"<td> ".$number."</td>\n";//SALDO DE CAPITAL
   $total_sc=$total_sc+$cap_p;
   $number=number_format($int_p, 0, ",",".");
   echo"<td> ".$number."</td>\n";//SALDO DE INTERES
   $total_ip=$total_ip+$int_p;
   $monto_p=number_format($monto_p, 0, ",",".");
   echo"<td> $".$monto_p."</td>\n";//SALDO PENDIENTE
   echo"</tr>\n";
  }while($matriz=@mysql_fetch_array($resultado));
  echo"</table>\n";
}
else{
  echo "<h2>Debe elegir una cartera</h2>";
}
  mysql_close($conex);
 ?>