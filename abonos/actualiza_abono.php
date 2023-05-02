<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
  $m=$_POST['abono'];
  $np=$_POST['np'];
  $fe=$_POST['fec'];
  $contador=$_POST['conta'];
  $update="update detalle_movimientos set monto_abono='$m' where contador='$contador';"; 
  $resultado=mysql_query($update,$conex);
  if($resultado)
  {
    $consul_monto="select sum(monto_abono) from detalle_movimientos where num_prestamo='$np';";
    $res=mysql_query($consul_monto,$conex);
    $m=@mysql_result($res,0);
    $consult_final="select monto_final from prestamos where num_prestamo='$np';";
    $rfinal=mysql_query($consult_final,$conex);
    $ma=@mysql_result($rfinal,0,monto_final);
    if ($m>=$ma) {
      $ins="update prestamos set estado='0', fin_pres='$fe' where num_prestamo='$np';";
      $rins=mysql_query($ins,$conex);
      echo "<script>";
      echo "window.alert('¡¡¡ CON ESTE CAMBIO EL PRESTAMO ES PAGADO EN SU TOTALIDAD ¡¡¡¡');";
      echo "document.location='form_edi_abo.php';"; 
      echo "</script>";
    }
    else {
      $ins="update prestamos set estado='1', fin_pres='NULL' where num_prestamo='$np';";
      $rins=mysql_query($ins,$conex);
      echo "<script>";
      echo "window.alert(' DATOS GRABADOS PRESTAMO ACTIVO ');";
      echo "document.location='form_edi_abo.php';"; 
      echo "</script>";
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