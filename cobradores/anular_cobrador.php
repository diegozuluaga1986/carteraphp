<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
  $id_cobra=$_GET['id'];
  $f_a=date('ymd');
  $update="update cobradores set activo='0', fecha_fin='$f_a'";
  $update.=" where id_cob='$id_cobra';"; 
  $resultado=mysql_query($update,$conex);

  if($resultado)
  {
    echo "<script>";
    echo "window.alert('¡¡¡ El cobrador ha sido desactivado....¡¡¡¡');";
    echo "document.location='lista_cobradores.php';";
    echo "</script>";   
  }
  else
  {
    echo "<script>";
    echo "window.alert('¡¡¡ Los DATOS no han Sido GRABADOS.... Revise ¡¡¡¡');";
    echo "document.location='lista_cobradores.php';";
    echo "</script>";
  }
  mysql_close($conex);  
?>

 
</body>
</html>