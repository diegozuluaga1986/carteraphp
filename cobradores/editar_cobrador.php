<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
  $n_cobra=$_POST['id_cob'];
  $nom=$_POST['nom'];
  $sueldo=$_POST['sueldo'];
  $cargo=$_POST['cargo'];
  $tel=$_POST['cel'];  
  $dire=$_POST['dir'];
  $barrio=$_POST['bar'];
  $ciudad=$_POST['ciu'];
 
  if(empty($nom))
  {    
    echo "<script>";
    echo "window.alert('¡¡¡ Debe indicar un nombre cobrador ....¡¡¡¡');";
    echo "document.location='modificar_cobra.php';";
    echo "</script>";   
    mysql_close($conex);  
  }
  else
  {
    $update="update cobradores set nombre_co='$nom', cargo='$cargo', direccion='$dir', ";
    $update.="barrio='$barrio', ciudad='$ciudad', telefono='$tel', sueldo='$sueldo' ";
    $update.="where id_cob='$n_cobra';"; 
    $resultado=mysql_query($update,$conex);
    if($resultado)
    {
      echo "<script>";
      echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
      echo "document.location='lista_cobradores.php';";
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