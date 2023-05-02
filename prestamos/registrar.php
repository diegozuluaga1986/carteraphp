<?php
  session_start();
  include("../conexion.php");
  $conex=conectarse("cartera");
  $num_per=$_POST['num'];
  $fecha_pres=$_POST['Fecha'];
  $valor=$_POST['Monto_prestamo'];
  //$valor=str_replace('.','',$valor);
  $valor=$valor*1000;
  $cuotas=$_POST['numero_cuotas'];
  $cartera=$_POST['cart'];
  $dia_cobro=$_POST['dcobro'];
  $consult= "select * from carteras where nombre_car = '$cartera';";
  $res=mysql_query($consult,$conex);
  $mat=mysql_fetch_array($res);
  $cod_cart=$mat['cod_cartera'];
  $cont_cu=0;
  $prec_cuota=$_POST['valor_cuota'];
  $prec_cuota=$prec_cuota*1000;
  //$prec_cuota=str_replace('.','',$prec_cuota);
  $m_final=$cuotas * $prec_cuota;
  $ruta=$_POST['ruta'];
  $anticipo=$_POST['anti'];
  //$anticipo=str_replace('.','',$anticipo);
  $anticipo=$anticipo*1000;
  $tipo=$_POST['tp'];
  if($m_final<=$valor)
  { 
    echo "<script>";
    echo "window.alert('¡¡¡ Error el Monto final no puede ser inferior o igual al Prestamo....¡¡¡¡');";
    echo "document.location='formulario_prestamo.php';";
    echo "</script>";
    echo $m_final;
  } 
  else
  {
    echo $m_final;
    echo " // ";
    echo $valor;
    echo " // ";
    echo $prec_cuota;
    $insert="insert into prestamos  (num_cliente,fecha_inicio,monto,monto_final,cuota,num_cuotas,orden_ruta,cod_cartera,dia_abona,nuevo) values('$num_per','$fecha_pres','$valor','$m_final','$prec_cuota','$cuotas','$ruta','$cod_cart','$dia_cobro','1');";
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
      unset($_SESSION['cc']);
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
  } 
  mysql_close($conex);  
?> 

