<?php
	include("../../conexion.php");
  	$conex=conectarse("cartera");

  	$car=$_GET['id'];
 	$consultar= "select * from carteras where cod_cartera = '$car';";
    $resultado=mysql_query($consultar,$conex);
    $matriz=@mysql_fetch_array($resultado);

	$consult= "update carteras set activa='1' where cod_cartera='$car';";
    $result=mysql_query($consult,$conex);
    $mat=@mysql_fetch_array($result);
	
  	if($result)
  	{
    	echo "<script>";
    	echo "window.alert('¡¡¡ La Cartera acaba de ser Reactivada....¡¡¡¡');";
    	echo "document.location='estado_cartera.php';";
    	echo "</script>";   
    }
  mysql_close($conex);
?>
