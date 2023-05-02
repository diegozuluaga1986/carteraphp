<?php
  session_start();
  include("../conexion.php");
  $conex=conectarse("cartera");
  $fecha=$_POST['fecha'];
  $consult= "select * from carteras where nombre_car = '$cartera';";
  $res=mysql_query($consult,$conex);
  $mat=mysql_fetch_array($res);
  $cod_cart=$mat['cod_cartera'];
?>
<!DOCTYPE html>
<html lang="es">  
<head>
  <meta charset="utf-8"/> 
  <meta content="Miller Posada" name="author" />
  <meta content="acumular" name="description" />
  <meta content="etiqueta1, etiqueta2, etiqueta3" name="prestamos" />
  <title>Acumular</title>
  <link href="../resultados.css" rel="stylesheet" type="text/css">
<link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
<link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">  
<link rel="stylesheet" href="../funciones/jquery-ui-1.11.2/jquery-ui.css" />
    <script type="text/javascript" src="../bootstrap2/js/bootstrap.js"></script>
    <script type="text/javascript" src="../funciones/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="../funciones/jquery-ui-1.11.2/jquery-ui.js"></script>
    <script type="text/javascript" src="../funciones/funciones.js"></script>
</head>
<body>
<?php
	$cartera=$_SESSION['cartera'];
  	if($cartera!=""){
    	echo $cartera;
    	echo "<br>";
    	echo $cod_cart;
    	echo "<br>";
    	//validar fecha
    	$consul_fecha="SELECT * FROM cajas WHERE fecha='$fecha';";
    	$resfecha=mysql_query($consul_fecha,$conex);
    	$conteo=mysql_num_rows($resfecha);
    	if ($conteo>0) {
   			echo "<script>";
       	 	echo "window.alert('¡¡¡ Esta fecha ya fue acumulada ¡¡¡¡');";
        	echo "window.close();"; 
        	echo "</script>";
   		}//if ($cajas['fecha']==$fecha)
   		else{
    		//consulta de cajas
			$consulta_cajas="select * from cajas where cod_cartera=$cod_cart order by id_caja desc limit 1;";   		
   			$res_cajas=mysql_query($consulta_cajas,$conex);
   			$filas=mysql_num_rows($res_cajas);
   			$cajas= mysql_fetch_array($res_cajas);
   			if ($filas==0) {
   				$monto="0";
   			}
   			else
   			{
   				$monto=$cajas['monto'];
   				$fe_caja_ant=$cajas['fecha'];
   			}
   			//consulta de movimientos
   			$consulta_mov="SELECT * FROM movimientos WHERE cod_cartera ='$cod_cart' AND fecha ='$fecha';";
   			$resul_mov=mysql_query($consulta_mov,$conex);
   			$fi2=mysql_num_rows($resul_mov);
   			$movimientos=mysql_fetch_array($resul_mov);
   			$cobro=$movimientos['dinero_cobrado'];
   			$prestado=$movimientos['dinero_prestado'];
   			//consulta de vales
   			$consulta_vales="select * from vales where cod_cartera='$cod_cart' and fecha='$fecha';";
   			$res_val=mysql_query($consulta_vales,$conex);
   			$fi3=mysql_num_rows($res_val);
   			$vales=mysql_fetch_array($res_val);
   			// consulta de faltantes
   			$consulta_fal="select * from faltantes where cod_cartera='$cod_cart' and fecha='$fecha';";
   			$res_fal=mysql_query($consulta_fal,$conex);
   			$faltantes=mysql_fetch_array($res_fal);
   			echo "<br>";
   			echo "<center><table>";
   			$number=number_format($monto, 0, ",",".");
   			echo "<tr><td class='azul'>Caja anterior</td><td>$".$number."</td></tr>";
   			$number=number_format($cobro, 0, ",",".");
   			echo "<tr><td class='azul'>Dinero cobrado</td><td>$".$number."</td></tr>";
   			$number=number_format($prestado, 0, ",",".");
   			echo "<tr><td class='azul'>Dinero prestado</td><td>$".$number."</td></tr>";
   			$number=number_format($vales['monto'], 0, ",",".");
   			echo "<tr><td class='azul'>Vale cobrador</td><td>$".$number."</td></tr>";
   			echo "<tr><td class='azul'>Vale supervisor</td><td></td></tr>";
   			$number=number_format($faltantes['monto'], 0, ",",".");
   			echo "<tr><td class='azul'>Faltante</td><td>$".$number."</td></tr>";
   			$caja_nueva=$monto+$cobro-$prestado-$vales['monto']-$faltantes['monto'];
   			$number=number_format($caja_nueva, 0, ",",".");
   			echo "<tr><td class='azul'>Total caja</td><td>$".$number."</td></tr>";
   			echo "</table>";
   			$insert_ncaja="insert into cajas (fecha,cod_cartera,monto) values ('$fecha','$cod_cart','$caja_nueva');";
   			$regiscaja=mysql_query($insert_ncaja,$conex);
   			echo "<br>";
   			echo "<h2>Acumulación correcta</h2></center>";
   		}//else
    }//if($cartera!="")
  else
  echo "<h2>Debe elegir una cartera </h2>";
  mysql_close($conex);
?>

</body>
</html>