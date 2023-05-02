<?php
  session_start();
  include("../../conexion.php");
  $conex=conectarse("cartera");
  $bus_cart="select * from carteras order by orden;";
  $r_bus=mysql_query($bus_cart,$conex);
  $m_cart=mysql_fetch_array($r_bus);
?> 
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Detalles Cartera</title>
	<link href="../../resultados.css" rel="stylesheet" type="text/css">
	<link href="../../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">  
    <script type="text/javascript" src="../../bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../../funciones/funciones.js"></script>
</head>
<body>
	<br>
	<center><H3>Listado general de Carteras</H></center>
	<br>
	<center><table><tr class="titulo"><td>Cartera</td><td>Estado</td><td>Acción</td>
	 
<?php
$act=0;
$inact=0;
	do {
		$num_cart=$m_cart['cod_cartera'];
		
		if ($m_cart['activa']==1) {
			echo "<tr><td class='activa'>".$m_cart['nombre_car']."</td>";
			echo "<td class='activa'>Activa</td>";
			echo "<td><a href='desactivar.php?id=$num_cart' class='btn btn-danger'>Inhabilitar</a></td>";
			$act=$act+1;
		}
		else{
			echo "<tr><td class='inactiva'>".$m_cart['nombre_car']."</td>";
			echo "<td class='inactiva'>Inactiva</td>";
			echo "<td> <a href='activar.php?id=$num_cart' class='btn btn-info'>Reactivar</a></td>";	
			$inact=$inact+1;	
		}
		echo "</tr>";
		
	} while ($m_cart=mysql_fetch_array($r_bus));
	echo "<tr class='titulo'><td>Carteras activas</td><td colspan='2'>".$act."</td></tr>";
	echo "<tr class='titulo'><td>Carteras inactivas</td><td colspan='2'>".$inact."</td></tr>";

?>
	</table>
	</center>
	<br>
	
</body>
</html>