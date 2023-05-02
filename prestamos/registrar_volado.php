<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
  $n_pres=$_GET['id'];
  if (!(empty($n_pres))) 
  {
    $update="update prestamos set estado='3' where num_prestamo='$n_pres';"; 
    $resultado=mysql_query($update,$conex);
    if($resultado)
    {
      echo "<script>";
      echo "window.alert('Este prestamo a pasado a la lista de volados');";
      echo "document.location='../reportes/listar_prestamo.php';";
      echo "</script>";   
    }
    else
    {
      echo "<script>";
      echo "window.alert('Datos no grabados');";
      echo "document.location='../reportes/listar_prestamo.php';";
      echo "</script>";
    }  
  }
?>
