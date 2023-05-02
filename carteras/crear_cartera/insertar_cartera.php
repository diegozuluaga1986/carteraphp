<?php 
  include("../../conexion.php");
  $conex=conectarse("cartera");
  $codigo=$_POST['cod_car'];
  $nom=$_POST['Nombre_cartera'];
  $cobrador=$_POST['Cobrador'];
  $f_ini=$_POST['Fecha']; 
  $caja=0;  
  $consulta="insert into carteras (nombre_car,cobrador,fecha_inicio,caja,total_cartera)";
  $consulta.=" values('$nom','$cobrador','$f_ini','$caja','0');";
  $resultado=mysql_query($consulta,$conex);
  if($resultado)
  {
    echo "<script>";
    echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
    echo "document.location='formulario_cartera.php';";
    echo "</script>";
  }
  else
  {
    echo "<script>";
    echo "window.alert('¡¡¡ Los DATOS no han Sido GRABADOS.... Revise ¡¡¡¡');";
    echo "document.location='formulario_cartera.php';";
    echo "</script>";
  }
  mysql_close($conex);  
?> 