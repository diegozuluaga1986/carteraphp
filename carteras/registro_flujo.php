<?php
  session_start();
  include("../conexion.php");
  $cartera=$_SESSION['cartera'];
  $conex=conectarse("cartera");
  $date=$_POST['fech'];
  $cobro=$_POST['cobro'];
  $p_n=$_POST['np'];
  $volteos=$_POST['rn'];
  $gas=$_POST['gas'];
  $via=$_POST['via'];
  $sueldo=$_POST['sueldo'];
  $s_c=$_POST['sec'];
  $gc=$_POST['gc'];
  $aho=$_POST['ah'];
  $div=$_POST['div'];
  $base=$_POST['base'];


  $consult= "select * from carteras where nombre_car = '$cartera';";
  $result=mysql_query($consult,$conex);
  $mat=mysql_fetch_array($result);
  $cod_cart=$mat['cod_cartera'];
  //$consul_caja="select caja from flujo_cartera where fecha_flujo='$date'";
?>
<html>
  <body>
<?php   
  
  $registro_flujo="insert into flujo_cartera (cod_cartera,fecha_flujo,cobro,prestado,renovado,gasolina,";
  $registro_flujo.="viaticos,sueldo_c,sueldo_s,gastos_ofi,ahorro,dividendos,base)";
  $registro_flujo.=" values ('$cod_cart','$date','$cobro','$p_n','$volteos','$gas','$via',";
  $registro_flujo.="'$sueldo','$s_c','$gc','$aho','$$div',$base);";
  $result2=mysql_query($registro_flujo,$conex);
  if($result2)
  {
    
    echo "<script>";
    echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
    echo "</script>";   
    echo "fecha = ".$date;
    echo "<br>";
    echo "cobro = ".$cobro;
    echo "<br>";
    echo "Prestamos nuevos= ".$p_n;
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