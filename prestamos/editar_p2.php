<?php
  session_start();
  include("../conexion.php");
  $conex=conectarse("cartera");
  $n_pres=$_POST['num_pres'];
  $m=$_POST['Monto'];
  $vc=$_POST['Cuota'];
  $nc=$_POST['Numero_cuota'];
  $dc=$_POST['dia_cobro'];
  $cart=$_POST['cartera'];
  $cod=$_POST['cc'];
  $mf=$vc*$nc;
  if (!(empty($cart))) {
    $consult= "select * from carteras where nombre_car = '$cart';";
    $result=mysql_query($consult,$conex);
    $mat=@mysql_fetch_array($result);
    $cod_cart=$mat['cod_cartera'];
  }
  else{
    $cod_cart=$cod;
  }
  if($mf<=$m)
  { 
    echo "<script>";
    echo "window.alert('¡¡¡ Error: Existe un error en la cantidad o valor de la cuota ....¡¡¡¡');";
    echo "document.location='modificar_p2.php';";
    echo "</script>";
    echo $m_final;
    mysql_close($conex); 
  } 
  else{
    $update="update prestamos set monto='$m', cuota='$vc', cod_cartera='$cod_cart', ";
    $update.="num_cuotas='$nc', monto_final='$mf', dia_abona='$dc' where num_prestamo='$n_pres';"; 
    $resultado=mysql_query($update,$conex);
    if($resultado)
    {
      echo "<script>";
      echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
      echo "document.location='../reportes/revisar_prestamos.php';";
      echo "</script>";   
    }
    else
    { 
      echo "<script>";
      echo "window.alert('¡¡¡ Los DATOS no han Sido GRABADOS.... Revise ¡¡¡¡');";
      echo "</script>";
    }
  }  
  mysql_close($conex);  
?>

 
</body>
</html>