<?php
  session_start();
  include("../../conexion.php");
  $conex=conectarse("cartera");
  $cartera=$_SESSION['cartera'];
  $consult= "select * from carteras where nombre_car = '$cartera';";
  $result=mysql_query($consult,$conex);
  $mat=@mysql_fetch_array($result);
  $cod_cart=$mat['cod_cartera'];
  $fecha=$_POST['fecha'];
  $cobrador=$_POST['cobra'];
  $base=$_POST['base'];
  $base=str_replace('.','',$base);
  $efectivo=$_POST['efectivo'];
  $efectivo=str_replace('.','',$efectivo);
  $monto_nuevos=$_POST['nuevo'];
  $monto_nuevos=str_replace('.','',$monto_nuevos);
  $vale_cobra=$_POST['vale'];
  $vale_cobra=str_replace('.','',$vale_cobra);
  $vale_super=$_POST['vale_sup'];
  $vale_super=str_replace('.','',$vale_super);
  $gastos=$_POST['gastos'];
  $gastos=str_replace('.','',$gastos);
  $entregue=$_POST['entregue'];
  $entregue=str_replace('.','',$entregue);
  $recibi=$_POST['recibi'];
  $recibi=str_replace('.','',$entregue);
 //
  if($cartera!="")
  {
    $consul_cobra="select cobradores.id_cob from cobradores where cobradores.nombre_co='$cobrador';";
    $result_cobrador=mysql_query($consul_cobra,$conex);
    $info_cob=@mysql_fetch_array($result_cobrador);
    $id_cob=$info_cob['id_cob'];
    //Consultar renovados
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
    $renovados=@mysql_fetch_array($resul_reno);
    do{
    $mont=$mont+$renovados['monto'];
    $No++;
    }while($renovados=@mysql_fetch_array($resul_reno));  
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
    <title>Entrega cobrador</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
    <link href="../../resultados.css" rel="stylesheet" type="text/css">
    <link href="../../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">  
    <link rel="stylesheet" href="../../funciones/jquery-ui-1.11.2/jquery-ui.css" />
    <script type="text/javascript" src="../../bootstrap2/js/bootstrap.js"></script>
    <script type="text/javascript" src="../../funciones/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="../../funciones/jquery-ui-1.11.2/jquery-ui.js"></script>
    <script type="text/javascript" src="../../funciones/funciones.js"></script>
  </head>
  <body>
    <br>
    <center>
      <H2>Cartera: <?php echo $cartera; ?></H2>
      <br>
      <H3>Fecha: <?php echo $fecha; ?></H3>
      <div>
        <form name='cuadre' action='.php' method='POST' autocomplete='off'>
          <table border='2' class="align_right">
<?php            
            echo "<tr><td>Cartera:</td><td colspan='2'>".$cartera."</td></tr>";
            echo "<tr><td>Cobrador:</td><td colspan='2' class='formulario'><input type='text' name='cobra' size='10' value='".$contador."' readonly></td></tr>";//cobrador
            echo "<tr><td>Fecha:</td><td colspan='2' class='formulario'><input type='text' name='Fecha' size='10' value='".$fecha."' readonly></td></tr>";//Fecha
            echo "<tr><td colspan='3'></td></tr>";
            $number=number_format($base, 0, ",",".");
            echo "<tr><td>Base:</td><td colspan='2' class='formulario'><input type='text' dir='rtl' name='base' size='6' value='".$number."' readonly></td></tr>";//Base
            $number=number_format($efectivo, 0, ",",".");
            echo "<tr><td>Efectivo:</td><td colspan='2' class='formulario'><input type='text' dir='rtl' name='efectivo' size='8' value='".$number."' readonly></td></tr>";//Efectivo
            $number=number_format($mont, 0, ",",".");
            echo "<tr><td>Renovados:</td><td colspan='2' class='formulario'><input type='text' dir='rtl' name='renovado' size='8' value='".$number."' readonly></td></tr>";//Renovados
            $number=number_format($monto_nuevos, 0, ",",".");
            echo "<tr><td>Nuevos:</td><td colspan='2' class='formulario'><input type='text' dir='rtl' name='nuevo' size='8' value='".$number."' readonly></td></tr>";//Nuevos
            //Total prestado*********************
            $total_pres=$monto_nuevos+$mont;
            //***********************************
            $number=number_format($vale_cobra, 0, ",",".");
            echo "<tr><td>Vale cobrador:</td><td colspan='2' class='formulario'><input type='text' dir='rtl' name='vale' size='8' value='".$number."' readonly></td></tr>"; //Vale
            $number=number_format($vale_super, 0, ",",".");           
            echo "<tr><td>Vale Supervisor:</td><td colspan='2' class='formulario'><input type='text' dir='rtl' name='vale_sup' size='8' value='".$number."' readonly></td></tr>"; // Vale supervisor
            $number=number_format($gastos, 0, ",",".");
            echo "<tr><td>Gastos oficina:</td><td colspan='2' class='formulario'><input type='text' dir='rtl' name='gastos' size='8' value='".$number."' readonly></td></tr>";// Gastos
            $number=number_format($entregue, 0, ",",".");
            echo "<tr><td>Entregue:</td><td colspan='2' class='formulario'><input type='text' dir='rtl' name='entregue' size='8' value='".$number."' readonly></td></tr>";//Entregue
            $number=number_format($recibi, 0, ",",".");
            echo "<tr><td>Recibi:</td><td colspan='2' class='formulario'><input type='text' dir='rtl' name='recibi' size='8' value='".$number."' readonly></td></tr>";//Recibi
            echo "<tr><td colspan='3'></td></tr>";
            $number=number_format($total_cobro, 0, ",",".");
            echo "<tr><td>Oficina:</td><td colspan='3' class='formulario'><input type='text' dir='rtl' name='oficina' size='8' value='".$number."' readonly></td></tr>";//Total cobro oficina
            $entregado=$mont+$monto_nuevos+$efectivo+$vale_cobra+$vale_super+$gastos+$entregue-$base-$recibi;
            $diferencia=$entregado-$total_cobro;
            $number=number_format($diferencia, 0, ",",".");
            echo "<tr><td>Diferencia:</td>";
            if ($diferencia==0) {
              echo "<td colspan='2'>OK</td></tr>";//Diferencia
            }
            if ($diferencia>0) {
              echo "<td widht='10'>S</td><td class='formulario'><input type='text' name='sobrante' size='8' value='".$number."' readonly></td></tr>";//Diferencia
            }
            if ($diferencia<0) {
              $diferencia=$diferencia*-1;
              $number=number_format($diferencia, 0, ",",".");
              echo "<td widht='20'>F</td><td class='formulario'><input type='text' name='sobrante' size='8' value='".$number."' readonly></td></tr>";//Diferencia
              $faltante=$diferencia;
            }
            echo "<tr><td>Clientes:</td><td colspan='2' class='formulario'><input type='text' name='clientes' size='8' value='".$coteo."'></td></tr>";//Clientes

          echo "</table>";  
      echo"</div></center>";
 //registrar datos de movimientos
  $insert_mov="insert into movimientos (fecha, cod_cartera, dinero_cobrado, dinero_prestado)  values('$fecha', '$cod_cart', '$total_cobro', '$total_pres');";
  $result=mysql_query($insert_mov,$conex);    
 //registrar vales y faltantes
  $insert_vale="insert into vales (id_cob, fecha, monto, pendiente) values('$id_cob', '$fecha', '$vale_cobra', 'si')";
  $result_vale=mysql_query($insert_vale,$conex);
  $insert_falt="insert into faltantes (id_cob, fecha, monto, pendiente) values('$id_cob', '$fecha', '$faltante', 'si')";
  $result_falt=mysql_query($insert_falt,$conex);

  }//if($cartera!="")
  else
  echo "<h2>Debe elegir una cartera </h2>";
  mysql_close($conex);
?>
</body>
</html>