<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
  $nombre=$_POST['nombre'];
  $telefono=$_POST['telefono'];
  $sueldo=$_POST['sueldo'];
  $sueldo=str_replace('.','',$sueldo);
  $f_a=date('ymd');
  $insertar="insert into cobradores (nombre_co,telefono,sueldo,fecha_inicio) values('$nombre','$telefono','$sueldo','$f_a');";
  $resultado=mysql_query($insertar,$conex);
  if($resultado)
  {
    echo "<script>";
    echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
    echo "</script>";
  }
  else
  {
    echo "<script>";
    echo "window.alert('¡¡¡ Los DATOS no han Sido GRABADOS.... Revise ¡¡¡¡');";
    echo "document.location='../cobradores/formulario_cobrador.php';";
    echo "</script>";
  }
  mysql_close($conex);  
?> 