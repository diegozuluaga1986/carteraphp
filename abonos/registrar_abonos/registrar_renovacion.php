<?php
  include("../../conexion.php");
  $conex=conectarse("cartera");
  $num_per=$_POST['num'];
  $fecha_pres=$_POST['Fecha'];
  $valor=$_POST['Monto_prestamo'];
  $valor=$valor*1000;
  $cuotas=$_POST['numero_cuotas'];
  $cartera=$_POST['cart'];
  $dia_cobro=$_POST['dcobro'];
  $cod_cart=$_POST['cart'];             
  $cont_cu=0;
  $prec_cuota=$_POST['valor_cuota'];
  $prec_cuota=$prec_cuota*1000;
  $m_final=$cuotas * $prec_cuota;
  $ruta=$_POST['ruta'];
  $anticipo=$_POST['anti'];
  $anticipo=$anticipo*1000;
  if($m_final<=$valor)
  { 
    echo "<script>";
    echo "window.alert('¡¡¡ Error el Monto final no puede ser inferior o igual al Prestamo....¡¡¡¡');";
    echo "document.location='renovacion.php';";
    echo "</script>";
    echo $m_final;
  } 
  else
  {
    $insert="insert into prestamos  (num_cliente,fecha_inicio,monto,monto_final,cuota,num_cuotas,orden_ruta,cod_cartera,dia_abona) values('$num_per','$fecha_pres','$valor','$m_final','$prec_cuota','$cuotas','$ruta','$cod_cart','$dia_cobro');";
    $result=mysql_query($insert,$conex);
    if($result)
    {
      if ($anticipo>0) {
        $consul_np="select * from prestamos order by num_prestamo desc;";
        $rconsul=mysql_query($consul_np,$conex);
        $np=@mysql_result($rconsul,0,num_prestamo);  
        $inser_ant="insert into detalle_movimientos (fecha_m,num_prestamo,monto_abono)  values('$fecha_pres','$np','$anticipo');";
        $resin_abo=mysql_query($inser_ant,$conex);
      }
      echo "<script>";
      echo "window.alert('DATOS GRABADOS EXITOSAMENTE');";
      echo "window.close();"; 
      echo "</script>";
    }
    else
    {
      echo "<script>";
      echo "window.alert('¡¡¡ Los DATOS no han Sido GRABADOS.... Revise ¡¡¡¡');";
      echo "window.close();"; 
      echo "</script>";
    }
  } 
  mysql_close($conex);  
?> 