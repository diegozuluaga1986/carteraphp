<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
  $n_pres=$_POST['num_pres'];
  $mot=$_POST['motivo'];
  $f_a=date('ymd');
  $update="update prestamos set estado='2', motivo='$mot', fin_pres='$f_a' ";
  $update.=" where num_prestamo='$n_pres';"; 
  $resultado=mysql_query($update,$conex);

  if($resultado)
  {
    echo "<script>";
    echo "window.alert('¡¡¡ El prestamo ha sido Anulado....¡¡¡¡');";
    echo "document.location='listar_prestamo.php';";
    echo "</script>";   
  }
  else
  {
    echo "<script>";
    echo "window.alert('¡¡¡ Los DATOS no han Sido GRABADOS.... Revise ¡¡¡¡');";
    echo "document.location='listar_prestamo.php';";
    echo "</script>";
  }
  mysql_close($conex);  
?>

 
</body>
</html>