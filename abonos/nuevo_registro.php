<?php
  session_start();
  include("../conexion.php");
  $cartera=$_SESSION['cartera'];
  $conex=conectarse("cartera");
  $date_abo=$_POST['fech'];
  $ncliente=$_POST['nc'];
  $n_pres=$_POST['num_id'];
  $abono=$_POST['cuota'];
  $volteos=$_POST['rn'];
  $c_vol=$_POST['n_cu'];
  $tc_v=$_POST['t_c'];
  $ruta=$_POST['or'];
  $anticipo=$_POST['ant'];
  $dia_abo=$_POST['dia_abo'];
  $b=count($abono);
  $x=0;
  $coteo=0;
  $cr=0;
  $t=0;
  $consult= "select * from carteras where nombre_car = '$cartera';";
  $result=mysql_query($consult,$conex);
  $mat=mysql_fetch_array($result);
  $cod_cart=$mat['cod_cartera'];

?>
<html>
  <head>
    <title>Registro abonos</title>
    <link href="../resultados.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
    <script type="text/javascript" src="../bootstrap2/js/bootstrap.js"></script>
  </head>
  <body>
    <br>
<?php   
  do 
  {
    $abono[$x]=$abono[$x]*1000;
    $insert="insert into detalle_movimientos (fecha_m,num_prestamo,monto_abono)  values('$date_abo','$n_pres[$x]','$abono[$x]');";
    $result=mysql_query($insert,$conex);
    $consul_monto="select sum(monto_abono) from detalle_movimientos where num_prestamo='$n_pres[$x]';";
    $res=mysql_query($consul_monto,$conex);
    $m=@mysql_result($res,0);
    $consult_final="select monto_final from prestamos where num_prestamo='$n_pres[$x]';";
    $rfinal=mysql_query($consult_final,$conex);
    $ma=@mysql_result($rfinal,0,monto_final);

    $consul_cliente="select clientes.num_cliente, clientes.nombre, prestamos.num_cliente, prestamos.control";
    $consul_cliente.=" from clientes, prestamos where prestamos.num_cliente = clientes.num_cliente";
    $consul_cliente.=" and prestamos.num_prestamo ='$n_pres[$x]';";
    $r_cliente=mysql_query($consul_cliente,$conex);
    $cliente=@mysql_fetch_array($r_cliente);
    $con=$cliente['control']; 

    if ($abono[$x]>0) {
      $coteo=$coteo+1;
    }

    if ($m>=$ma) {
      /*$ins="update prestamos set estado='0' where num_prestamo='$n_pres[$x]';";
      $rins=mysql_query($ins,$conex);*/
      $control=$con+1;
      /*$ins="update prestamos set control='$control' where num_prestamo='$n_pres[$x]';";
      $rins=mysql_query($ins,$conex);*/
      $t=$t+1;
      
    }
    if ($volteos[$x]>0) {
      $volteos[$x]=$volteos[$x]*1000;
      $mf=$c_vol[$x]*$tc_v[$x];
      $nuevo_p="insert into prestamos  (num_cliente,fecha_inicio,monto,monto_final,cuota,num_cuotas,orden_ruta,cod_cartera,dia_abona)"; 
      $nuevo_p.=" values('$ncliente[$x]','$date_abo','$volteos[$x]','$mf','$c_vol[$x]','$tc_v[$x]','$ruta[$x]','$cod_cart','$dia_abo[$x]');";
      $renovacion=mysql_query($nuevo_p,$conex);
      if ($anticipo[$x]>0) {
        $consul_np="select * from prestamos order by num_prestamo desc;";
        $rconsul=mysql_query($consul_np,$conex);
        $np=@mysql_result($rconsul,0,num_prestamo);  
        $inser_ant="insert into detalle_movimientos (fecha_m,num_prestamo,monto_abono)  values('$date_abo','$np','$anticipo[$x]');";
        $resin_abo=mysql_query($inser_ant,$conex);
        $recaudo=$recaudo+$anticipo[$x];
      }
      $cr=$cr+1;
    }
     if ($m>=$ma AND $volteos[$x]>0) {
      $renovados[]=@mysql_result($r_cliente,0,nombre);
    }
    if ($m>=$ma AND $volteos[$x]==0) {
      /*$con_control=" select prestamos.control from prestamos where prestamos.num_prestamo='$n_pres[$x]';";
      $rcon_control=mysql_query($con_control,$conex);  
      $contr=@mysql_result($rcon_control,0,control);
      if ($contr==1) {*/
        $terminados[]=@mysql_result($r_cliente,0,nombre);
        $x=$x+1;
      //}
      
    }
    $recaudo=$recaudo+$abono[$x];
    $t_volteos=$t_volteos+$volteos[$x];
  }while($x<$b);

  if($result)
  {
    //$in_flujo="insert into flujo_cartera (cod_cartera,fecha_flujo,cobro,prestado,gasolina,viaticos,sueldo_c,sueldo_s,gastos_ofi,ahorro)";

    echo "<script>";
    echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
    echo "</script>";
    $t=$t-$cr;
    ?>
    <H2>Cartera: <?php echo $cartera; ?></H2>
    <br>
    <H3>Fecha: <?php echo $date_abo; ?></H3>
    <br>
    <table class="centrado">
      <tr><td>Total Recaudado</td><td><?php echo $recaudo; ?></td></tr>
      <tr><td>Monto Renovado</td><td><?php echo $t_volteos; ?></td></tr>
      <tr><td>Clientes renovados</td><td><?php echo $cr; ?></td><td><?php @print implode('<br />',$renovados);  ?></td></tr>
      <tr><td>Clientes que cotearon</td><td><?php echo $coteo; ?></td></tr>
      <tr><td>Clientes que terminaron</td><td><?php echo $t; ?></td><td><?php @print implode('<br />',$terminados); ?></td></tr>
      <tr><td>Control</td><td><?php echo $con;?></td></tr>
    </table> 
<?php
    if ($t>0) {
      echo "<H3>Debe Ordenar la ruta...</H>";
      echo "<H3>Desea hacerlo ahora</H> <a href='../prestamos/orden_ruta.php' class='btn btn-info'>Si</a>";             
    }            
  }
  else
  {
    echo "<script>";
    echo "window.alert('¡¡¡ Los DATOS no han Sido GRABADOS.... Revise ¡¡¡¡');";
    echo "</script>";
  }
  mysql_close($conex); 
?>
  </body>
</html>