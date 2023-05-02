<?php
  session_start();
  include("../../conexion.php");
  //Recibiendo datos de formulario
  $cartera=$_SESSION['cartera'];
  $conex=conectarse("cartera");
  $date_abo=$_POST['fech'];
  $ncliente=$_POST['nc'];
  $n_pres=$_POST['num_id'];
  $abono=$_POST['cuota'];
  //$ruta=$_POST['or'];
  //$anticipo=$_POST['ant'];
  //$dia_abo=$_POST['dia_abo'];
  $b=count($abono);
  $x=0;
  $coteo=0;
  $cr=0;
  $t=0;
  //Eligiendo cartera
  $consult= "select * from carteras where nombre_car = '$cartera';";
  $result=mysql_query($consult,$conex);
  $mat=mysql_fetch_array($result);
  $cod_cart=$mat['cod_cartera'];
?>
<html>
  <head>
    <title>Registro abonos</title>
    <link href="../../resultados.css" rel="stylesheet" type="text/css">
    <link href="../../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
    <script type="text/javascript" src="../../bootstrap2/js/bootstrap.js"></script>
  </head>
  <body>
    <br>
<?php   
  do 
  { 
    //Registrando abonos a base de datos
    $abono[$x]=$abono[$x]*1000;
    $insert="insert into detalle_movimientos (fecha_m,num_prestamo,monto_abono,fecha_registrada)  values('$date_abo','$n_pres[$x]','$abono[$x]','$date_abo');";
    $result=mysql_query($insert,$conex);
    //consultando total abonado de cada prestamo.
    $consul_monto="select sum(monto_abono) from detalle_movimientos where num_prestamo='$n_pres[$x]';";
    $res=mysql_query($consul_monto,$conex);
    $m_a=@mysql_result($res,0);
    //consultando monto final de cada prestamo
    $consult_final="select monto_final from prestamos where num_prestamo='$n_pres[$x]';";
    $rfinal=mysql_query($consult_final,$conex);
    $m_f=@mysql_result($rfinal,0,monto_final);
    //consultando datos de cada cliente
    $consul_cliente="select clientes.num_cliente, clientes.nombre, prestamos.num_cliente, prestamos.control";
    $consul_cliente.=" from clientes, prestamos where prestamos.num_cliente = clientes.num_cliente";
    $consul_cliente.=" and prestamos.num_prestamo ='$n_pres[$x]';";
    $r_cliente=mysql_query($consul_cliente,$conex);
    //contando abonos
    if ($abono[$x]>0) {
      $coteo=$coteo+1;
    }
    //actualizando estado de prestamos terminados
    if ($m_a>=$m_f) {
      $ins="update prestamos set estado='0', fin_pres='$date_abo' where num_prestamo='$n_pres[$x]';";
      $rins=mysql_query($ins,$conex);
      //contando prestamos terminados
      $t=$t+1;
      //Capturando datos prestamos terminados
      $terminados[$x]["num_prestamo"]=$n_pres[$x]; 
      $terminados[$x]["nombre"]=@mysql_result($r_cliente,0,nombre);
      $terminados[$x]["nc"]=$ncliente[$x];
      $terminados[$x]["ruta"]=$ruta[$x];
      $terminados[$x]["dia"]=$dia_abo[$x];
    }
    $recaudo=$recaudo+$abono[$x];
    $x=$x+1;
  }while($x<$b);

  if($result)
  {
    //$in_flujo="insert into flujo_cartera (cod_cartera,fecha_flujo,cobro,prestado,gasolina,viaticos,sueldo_c,sueldo_s,gastos_ofi,ahorro)";
    echo "<script>";
    echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
    echo "</script>";
    echo "<br><br>";
    echo "<a href='resumen.php?fecha=$date_abo' class='btn btn-info' target='_blank'>ver resumen</a>";
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