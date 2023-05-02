<?php
  session_start();
  include("../conexion.php");
  $conex=conectarse("cartera");
  $cartera=$_SESSION['cartera'];
 	$consult="select * from carteras where nombre_car = '$cartera';";
    $result=mysql_query($consult,$conex);
    $mat=mysql_fetch_array($result);
    $cod_cart=$mat['cod_cartera'];
    $nom_co=$_POST['cobrador'];
    $bus_cobra="select * from cobradores where nombre_co ='$nom_co'; ";
  	$r_bus=mysql_query($bus_cobra,$conex);
  	$m_cobradores=mysql_fetch_array($r_bus);
  	$id_cob=$m_cobradores['id_cob'];
    $update="update carteras set id_cob='$id_cob' where cod_cartera='$cod_cart';"; 
    $resultado=mysql_query($update,$conex);
    if($resultado)
    {
      echo "<script>";
      echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
      echo "</script>";   
      mysql_close($conex);
    }
    else
    { 
      echo "<script>";
      echo "window.alert('¡¡¡ Los DATOS no han Sido GRABADOS.... Revise ¡¡¡¡');";
      echo "</script>";
    }
?>

