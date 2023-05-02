<?php
	session_start();
	include("conexion.php");
	$conex=conectarse("cartera");
	$nom_us= strip_tags($_POST['user']);
	$pass= strip_tags(($_POST['pass']));
	if($nom_us !="" AND $pass !="") {
		$validar_us="select * from usuarios where usuario= '$nom_us' and pass= '$pass';";
		$sql=mysql_query($validar_us,$conex);
		$nro=mysql_num_rows($sql);
		if($nro!=0){
			$_SESSION['logged']="Si";
			$_SESSION['admin']=$nom_us;
		} else {
			$_SESSION['error'] = "Login incorrecto";
		}
	} else {
		$_SESSION['vacio'] = "Por favor llene todos los campos";
	}
	header("location:index.php");
?>

