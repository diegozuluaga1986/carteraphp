<?php
  session_start();
  include("../../conexion.php");
  $conex=conectarse("cartera");
  $cod=$_POST['car'];
  $nomco=$_POST['nomco'];
  $actualizar=0;
  if(empty($nomco))
  {    
    echo "<script>";
    echo "window.alert('¡¡¡ Debe indicar un nombre para la cartera ....¡¡¡¡');";
    echo "document.location='detalle.php';";
    echo "</script>";   
    mysql_close($conex);  
  }
  else
  {
    $matriz_carteras= "select nombre_car from carteras;";
    $r_m_c=mysql_query($matriz_carteras,$conex);
    $array_carteras=mysql_fetch_array($r_m_c);
    do
    {
      if ($array_carteras['nombre_car']==$nomco) 
      {
        $actualizar=1;
      }
    }while($array_carteras=@mysql_fetch_array($r_m_c));  
    if ($actualizar==1) 
    {
      echo "<script>";
      echo "window.alert('¡¡¡ Este nombre ya pertenece a otra cartera ....¡¡¡¡');";
      echo "document.location='detalle.php';";
      echo "</script>";   
      mysql_close($conex);
    }  
    else
    {
      $update="update carteras set nombre_car='$nomco' ";
      $update.="where cod_cartera='$cod';"; 
      $resultado=mysql_query($update,$conex); 
      if($resultado)
      {
        echo "<script>";
        echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
        echo "window.close();";
        echo "</script>";
      } 
    }        
  }

  
  
  mysql_close($conex);  
?>

 
</body>
</html>