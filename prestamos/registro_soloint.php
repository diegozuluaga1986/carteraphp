<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
  $num_per=$_POST['num'];
  $fecha_pres=$_POST['fecha'];
  $valor=$_POST['monto'];
  $cuotas=1;
  $cartera=$_POST['cartera'];
  $dia_cobro=$_POST['dcobro'];
  $consult= "select * from carteras where nombre_car = '$cartera';";
  $res=mysql_query($consult,$conex);
  $mat=mysql_fetch_array($res);
  $cod_cart=$mat['cod_cartera'];
  $cont_cu=0;
  $prec_cuota=$_POST['cuota'];
  $m_final=$valor;
  $ruta=$_POST['ruta'];
  $anticipo=$_POST['anti'];
  $tipo="solo interes";

    $insert="insert into prestamos  (num_cliente,fecha_inicio,monto,monto_final,cuota,num_cuotas,orden_ruta,cod_cartera,dia_abona,tipo) values('$num_per','$fecha_pres','$valor','$m_final','$prec_cuota','$cuotas','$ruta','$cod_cart','$dia_cobro','$tipo');";
    $result=mysql_query($insert,$conex);
    if($result)
    {
      if ($anticipo>0) {
        $consul_np="select * from prestamos order by num_prestamo desc;";
        $rconsul=mysql_query($consul_np,$conex);
        $np=@mysql_result($rconsul,0,num_prestamo);  
        $inser_ant="insert into detalle_movimientos (fecha_m,num_prestamo,monto_abono)  values('00000000','$np','$anticipo');";
        $resin_abo=mysql_query($inser_ant,$conex);
      }
      
      echo "<script>";
      echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
      echo "document.location='../clientes/formulario_insert.php';";
      echo "</script>";
    }
    else
    {
      echo "<script>";
      echo "window.alert('¡¡¡ Los DATOS no han Sido GRABADOS.... Revise ¡¡¡¡');";
      echo "document.location='formulario_prestamo.php';";
      echo "</script>";
    }
  mysql_close($conex);  
?> 

