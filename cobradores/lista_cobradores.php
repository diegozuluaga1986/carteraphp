<?php
  session_start();
  include("../conexion.php");
  $conex=conectarse("cartera");
  $bus_cobra="select * from cobradores order by id_cob;";
  $r_bus=mysql_query($bus_cobra,$conex);
  $m_cobradores=mysql_fetch_array($r_bus);
?> 
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Listado cobradores</title>
	<link href="../resultados.css" rel="stylesheet" type="text/css">
	<link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">  
    <script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../funciones/funciones.js"></script>
</head>
<body>
	<br>
	<center><H3>Listado de Cobradores</H></center>
	<br>
	<center>
		<table>
			<tr class="titulo"><td>Nombre</td><td></td><td>Acción</td></tr>	 
<?php
	do {	
			$codigo=$m_cobradores['id_cob'];
			echo "<tr><td>".$m_cobradores['nombre_co']."</td>";
			echo "<td><a href='modificar_cobra.php?id=$codigo' class='btn btn-info'>Editar</a></td>";
			if ($m_cobradores['activo']==1) 
			{
				echo "<td><a href='anular_cobrador.php?id=$codigo' class='btn btn-danger'>desactivar</a></td>";
			}
			else
			{
				echo "<td><a href='reactivar_cobrador.php?id=$codigo' class='btn btn-warning'>reactivar</a></td>";
			}	
		
	} while ($m_cobradores=mysql_fetch_array($r_bus));
?>
	</table>
	</center>
	<br>
	
</body>
</html>