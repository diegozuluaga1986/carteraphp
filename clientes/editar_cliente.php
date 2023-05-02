<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
  $n_cliente=$_POST['num_cliente'];
  $prof=$_POST['labor'];
  $dire=$_POST['dir'];
  $barrio=$_POST['bar'];
  $ciudad=$_POST['ciu'];
  $tel=$_POST['tf'];
  $cel=$_POST['cel'];
  $nom=$_POST['nom'];
  $ced=$_POST['ced'];

  /*$validar="select * from clientes where cedula='$ced';";
  $r_va=mysql_query($validar,$conex);
  $total_resul=mysql_num_rows($r_va);

  if($total_resul>=1)
  {
    echo "<script>";
    echo "window.alert('¡¡¡YA EXISTE UN CLIENTE CON ESTE NUMERO DE CEDULA....¡¡¡¡');";
    echo "document.location='//reportes/listar_cliente.php';";
    echo "</script>";
    mysql_close($conex);
  } */    

  if(empty($nom))
  {    
    echo "<script>";
    echo "window.alert('¡¡¡ Debe indicar un nombre de cliente ....¡¡¡¡');";
    echo "document.location='modificar_cliente.php';";
    echo "</script>";   
    mysql_close($conex);  
  }
  else
  {
    $update="update clientes set nombre='$nom', cedula='$ced', profesion='$prof', direccion='$dir', ";
    $update.="barrio='$barrio', ciudad='$ciudad', tel_fijo='$tel', celular='$cel' ";
    $update.="where num_cliente='$n_cliente';"; 
    $resultado=mysql_query($update,$conex);
    if($resultado)
    {
      echo "<script>";
      echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
      echo "document.location='../clientes/listar_cliente.php';";
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