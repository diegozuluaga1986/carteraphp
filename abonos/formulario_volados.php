<?php
  session_start();
  include("../conexion.php");
  $conex=conectarse("cartera");
  $cartera=$_SESSION['cartera'];
  if($cartera!="")
  {
?>
<html>
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
    <div class='fixed'>
    <table>
    <tr class='primeralinea'><td colspan='12'>Cartera: <?php echo $cartera;?></td></tr>  
    <tr class='primeralinea'>
    <td class='td_fecha'>FECHA</td>
    <td class='td_fecha'>No cliente</td>
    <td class='ruta'>RUTA</td>
    <td class='nombre'>NOMBRE</td>
    <td class='c_d'>CUOTA DIARIA</td>
    <td class='c_a'>Cuotas Abo- nadas</td>
    <td class='abo'>ABONO</td>
    <td class='pres'>PRESTAMO</td>
    <td class='pend'>Cuotas x pagar</td>
    <td class='tc'>Total cuotas</td>
    <td class='mf'>MONTO FINAL</td>
    <td class='ta'>TOTAL ABONADO</td>
    <td class='sal'>SALDO</td>
    <td class='ren'><table class='t_hija'><tr class='primeralinea'><td colspan='4'>RENOVACION</td></tr><tr class='primeralinea'><td>R N</td><td>CUOTA</td><td>N C</td><td>ANT</td></tr></table></td>
    <td class='td_fecha'>Nº </td></tr> 
  </table></div>
<!--captura fecha//-->

<!-- fin captura fecha //-->
<?php   
    $consult= "select * from carteras where nombre_car = '$cartera';";
    $result=mysql_query($consult,$conex);
    $mat=mysql_fetch_array($result);
    $cod_cart=$mat['cod_cartera'];
    $consulta="select prestamos.num_prestamo, prestamos.num_cliente,";
    $consulta.=" prestamos.fecha_inicio, prestamos.monto, prestamos.num_cuotas,";
    $consulta.=" prestamos.cuota, prestamos.monto_final, prestamos.orden_ruta,";
    $consulta.=" prestamos.cod_cartera, prestamos.dia_abona,";
    $consulta.=" clientes.nombre from";
    $consulta.=" prestamos, clientes where prestamos.num_cliente=clientes.num_cliente";
    $consulta.=" and prestamos.cod_cartera=$cod_cart and prestamos.estado='3'";
    $consulta.=" order by orden_ruta;";
    $resultado=mysql_query($consulta,$conex);
    $matriz=mysql_fetch_array($resultado);
    $tab=1;
    if(!(empty($fecha))){
        echo "<div class='cuerpo'>";
        echo"<form name='abonar' action='registro_abonos.php' method='POST' autocomplete='off'> ";
        echo"<table>";
        do{
          echo"<tr>";
          echo"<td class='td_fecha'> <input type='text' name='fech' size='8' value=".$fecha." readonly></td>";  //FECHA invisible en navegador    
          echo"<td class='td_fecha'> <input type='text' name='nc[]' size='8' value=".$matriz['num_cliente']." readonly></td>";//Numero cliente invisible en navegador
          echo"<td class='ruta'><input type='text' class='angosto' name='or[]' maxlength='3' value=".$matriz['orden_ruta']." readonly></td>";//RUTA 
          echo"<td class='nombre'> ".$matriz['nombre']."</td>";//NOMBRE
          $number=number_format($matriz['cuota'], 0, ",",".");
          echo"<td class='c_d'> $".$number."</td>";//CUOTA DIARIA
          $n_p=$matriz["num_prestamo"];
          $consulta_det="select monto_abono from detalle_movimientos where num_prestamo=$n_p;";
          $r_det=mysql_query($consulta_det,$conex);
          $m_det=mysql_fetch_array($r_det);
          $suma=0;
          do{
            $suma=$suma+$m_det['monto_abono'];    
          }while($m_det=mysql_fetch_array($r_det));
          $cuotas=$suma/$matriz['cuota'];
          $modulo=$suma%$matriz['cuota'];
          $mod=$modulo/$matriz['cuota'];
          $cuotas=$cuotas-$mod;
          $pendientes=$matriz['num_cuotas']-$cuotas;
          echo"<td class='c_a'> ".$cuotas."</td>";//CUOTAS ABONADAS   
          echo"<td class='abo'><input type='text' class='td_abono' name='cuota[]' maxlength='4' tabindex=".$tab." onkeypress=return handleEnter(this, event)'></td>";//ABONO
          $number=number_format($matriz['monto'], 0, ",",".");
          echo"<td class='pres'> $".$number."</td>";//PRESTAMO          
          echo"<td class='pend'> ".$pendientes."</td>";//CUOTAS PENDIENTES
          echo"<td class='tc'> ".$matriz['num_cuotas']."</td>";//TOTAL CUOTAS
          $number=number_format($matriz['monto_final'], 0, ",",".");
          echo"<td class='mf'> $".$number."</td>";//MONTO FINAL
          $number=number_format($suma, 0, ",",".");
          echo"<td class='ta'> $".$number."</td>";//TOTAL ABONADO
          $monto_p=$matriz['monto_final']-$suma;
          $number=number_format($monto_p, 0, ",",".");
          echo"<td class='sal'> $".$number."</td>";//SALDO PENDIENTE
          echo"<td class='ren'><table class='t_hija'><tr><td class='t_hija'><input type='text' class='td_abono' name='rn[]' maxlength='4' ></td>";//RENOVACION NP
          echo"<td class='t_hija'><input type='text' class='td_abono' name='n_cu[]' maxlength='6' ></td>";//RENOVACION VC
          echo"<td class='t_hija'><input type='text' class='td_abono' name='t_c[]' maxlength='3' ></td>";// RENOVACION NC
          echo"<td class='t_hija'><input type='text' class='td_abono' name='ant[]' maxlength='6' ></td></tr></table></td>";// ANTICIPO 
          echo"<td class='td_fecha'> <input type='text' name='num_id[]' size='6' value=".$matriz['num_prestamo']." readonly></td>";//Nº PRESTAMO, Invisible
          echo"<td class='td_fecha'> <input type='text' name='dia_abo[]' size='6' value=".$matriz['dia_abona']."></td>";//Nº PRESTAMO, Invisible
          echo"</tr>";
          $tab=$tab++;
        }while($matriz=mysql_fetch_array($resultado));
        echo"</table></div>";
        echo"<div class='botom'>";
        echo"<p><input type='button' class='btn btn-info' onclick='pregunta()' value='Enviar'></P>";
        echo"<p><input type='reset' class='btn btn-info' value='Borrar'></p>";
        echo"</form></div><br>";
    }
  }
  else
  echo "<h2>Debe elegir una cartera </h2>";
  mysql_close($conex);
?>
</body>
</html>