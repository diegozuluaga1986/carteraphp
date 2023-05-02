<?php
  session_start(); 
  include("../conexion.php");
  $conex=conectarse("cartera");
  $nombre=$_POST['nombre'];
  $cedula=$_POST['cedula'];
  $_SESSION['cc']=$cedula;
  $direccion=$_POST['direccion'];
  $barrio=$_POST['barrio'];
  $dir_casa=$_POST['dir_c'];
  $ciudad=$_POST['ciudad'];
  $telefono=$_POST['tel'];
  $celular=$_POST['cel'];
  $profesion=$_POST['pro'];
 
//validamos los campos obligatorios
  $validar="select * from clientes where cedula='$cedula';";
  $r_va=mysql_query($validar,$conex);
  $total_resul=mysql_num_rows($r_va);
  if(empty($cedula))
  {
    $total_resul=0;
  }
  if((empty($nombre))||(empty($cedula))||(empty($ciudad)))
  {    
    echo "<script>";
    echo "window.alert('¡¡¡ Debe ingresar todos los valores con * ....¡¡¡¡');";
    echo "document.location='formulario_insert.php';";
    echo "</script>";   
    mysql_close($conex);  
  }
  if($total_resul>=1)
  {
    echo "<script>";
    echo "window.alert('¡¡¡ESTE CLIENTE YA EXISTE....¡¡¡¡');";
    echo "document.location='formulario_insert.php';";
    echo "</script>";
    mysql_close($conex);
  }     
  $consulta="insert into clientes (nombre,cedula,profesion,direccion,barrio,dir_casa,ciudad,tel_fijo,celular) values('$nombre','$cedula','$profesion','$direccion','$barrio','$dir_casa','$ciudad','$telefono','$celular');";
  $resultado=mysql_query($consulta,$conex);
  if($resultado)
  {
    echo "<script>";
    echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
    echo "document.location='../prestamos/formulario_prestamo.php';";
    echo "</script>";
  }
  else
  {
    echo "<script>";
    echo "window.alert('¡¡¡ Los DATOS no han Sido GRABADOS.... Revise ¡¡¡¡');";
    echo "document.location='../prestamos/formulario_prestamo.php';";
    echo "</script>";
  }
  mysql_close($conex);  
?> 