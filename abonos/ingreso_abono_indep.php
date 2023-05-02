<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
  $date_abo=$_POST['date'];
    $abono=$_POST['cuota'];
    $n_pres=$_POST['np'];
    if ((empty($abono))) {
        echo "<script>";
        echo "window.alert('¡¡¡ DEBE ELEGIR UN PRESTAMO....¡¡¡¡');";
        echo "document.location='../reportes/listar_prestamo.php';";
        echo "</script>";
      }  
    else
    { 
       $insert="insert into detalle_movimientos (fecha_m,num_prestamo,monto_abono)  values('$date_abo','$n_pres','$abono');";
       $result=mysql_query($insert,$conex);
       if($result)
       {
         echo "<script>";
         echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
         echo "document.location='../reportes/listar_prestamo.php';";
         echo "</script>";
       }
    }
?>