<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
  $n_pres=$_POST['num_pres'];
  $update="update prestamos set estado='1'";
  $update.=" where num_prestamo='$n_pres';"; 
  $resultado=mysql_query($update,$conex);
  if($resultado)
  {
    echo "<script>";
    echo "window.alert('¡¡¡ El prestamo ha sido Reactivado....¡¡¡¡');";
    echo "document.location='listar_prestamo.php';";
    echo "</script>";   
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