<?php
	include("../conexion.php");
  	$conex=conectarse("cartera");
?>
<html>
  <head><title></title>
    <link href="../resultados.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="../estilo.css" />   
    <script type="text/javascript" src="../bootstrap2/js/bootstrap.js"></script>
        <script type="text/javascript" src="../funciones/funciones.js"></script>
  </head>
  <body>  
  <br><br><br>
  <center><h1>Anular Prestamo</h1><br>
  </center>
  <br><br>
 <?php
  	$npres=$_GET['id'];
  	if(!(empty($npres)))
  	{
	    $consulta="select prestamos.num_prestamo, prestamos.num_cliente,";
	    $consulta.=" prestamos.fecha_inicio, prestamos.monto, prestamos.num_cuotas,";
	    $consulta.=" prestamos.cuota, prestamos.monto_final, prestamos.orden_ruta,";
	    $consulta.=" prestamos.cod_cartera,";
	    $consulta.=" clientes.nombre from";
	    $consulta.=" prestamos, clientes where prestamos.num_prestamo=$npres";
	    $consulta.=" and prestamos.num_cliente=clientes.num_cliente; ";
	    $resultado=mysql_query($consulta,$conex);
	    $matriz=mysql_fetch_array($resultado);
	    $car=$matriz['cod_cartera'];
	    $consult= "select * from carteras where cod_cartera = '$car';";
    	$result=mysql_query($consult,$conex);
    	$mat=@mysql_fetch_array($result);

    	
  	}
  	if(!(empty($resultado)))
  	{
    	echo"<center>";  
	    echo"<form name='Insertar' method='post' Action='anular_prestamo.php'>";
	    echo"<table>";
	    echo"<tr class='primeralinea'><td class='primeralinea'>No PRESTAMO</td>";
	    echo"<td><input type='text' name='num_pres' size='6' value=".$matriz['num_prestamo']." readonly> </td></tr>";
	    echo"<tr><td>NOMBRE</td><td> ".$matriz['nombre']."</td></tr>";
	    echo"<tr><td>Fecha</td><td>".$matriz['fecha_inicio']."</td></tr>";
	    $number=number_format($matriz['monto'], 0, ",",".");
	    echo"<tr><td>Monto</td><td>".$number."</td></tr>";
	    $number=number_format($matriz['cuota'], 0, ",",".");
	    echo"<tr><td>cuota</td><td>".$number."</td></tr>";
	    echo"<tr><td>No cuotas</td><td>".$matriz['num_cuotas']."</td></tr>";
	    echo"<tr><td>Cartera</td><td>".$mat['nombre_car']."</td></tr>";
      echo"<tr><td>Motivo de Anulacion</td><td><select name='motivo'>
              <option>Practica</option>
              <option>Cliente Fallecido</option>
              <option>Incobrable</option>
            </select></td></tr>";
	    echo"</table><br>";
	    echo"<input type='submit' class='btn btn-danger'  value='Anular'>";
	    echo"</form>";
	    echo"</center>";  
    }
  mysql_close($conex);
?>
  </body>
</html>