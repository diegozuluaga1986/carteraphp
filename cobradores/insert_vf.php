<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
  $cobrador=$_POST['cobra'];
  $fecha=$_POST['fecha'];
  $vale=$_POST['vale'];
  $vale=str_replace('.','',$vale);
  $faltante=$_POST['faltante'];
  $faltante=str_replace('.','',$faltante);
  $buscar_cob="select * from cobradores where nombre_co='$cobrador';";
  $rbuscar_co=mysql_query($buscar_cob,$conex);
  $m_co=mysql_fetch_array($rbuscar_co);
  $id_cob=$m_co['id_cob'];
  $insertar="insert into cuadre_dia (id_cob, fecha_cuadre, vale, faltante) values('$id_cob','$fecha','$vale','$faltante');";
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
    echo "document.location='../cobradores/fomulario_vf.php';";
    echo "</script>";
  }
  mysql_close($conex);  
?> 