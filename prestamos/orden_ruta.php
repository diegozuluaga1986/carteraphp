<?php
  session_start();
  include("../conexion.php");
  $conex=conectarse("cartera");
?>
<html>
<head>
<title></title>
<link href="../resultados.css" rel="stylesheet" type="text/css">
<link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="../estilo.css" />   
    <script type="text/javascript" src="../bootstrap2/js/bootstrap.js"></script>
</head>
<body>
<br><br>
<?php
  $cartera=$_SESSION['cartera'];
  if ($cartera=="") {
    echo "<h2>Debe elegir una cartera</h2>";
  }
  else{
    echo $cartera;
    $consult= "select * from carteras where nombre_car = '$cartera';";
    $result=mysql_query($consult,$conex);
    $mat=@mysql_fetch_array($result);
    $cod_cart=$mat['cod_cartera'];
    echo "<br>";
    $consulta="select prestamos.num_prestamo, prestamos.num_cliente,";
    $consulta.=" prestamos.monto, prestamos.num_cuotas,";
    $consulta.=" prestamos.cuota, prestamos.orden_ruta,";
    $consulta.=" clientes.nombre, clientes.direccion, clientes.ciudad from";
    $consulta.=" prestamos, clientes where prestamos.num_cliente=clientes.num_cliente and";
    $consulta.=" prestamos.cod_cartera=$cod_cart and prestamos.estado='1' ";
    $consulta.=" order by orden_ruta;";
    $resultado=mysql_query($consulta,$conex);
    $matriz=mysql_fetch_array($resultado);
    echo"<form name='abonar' action='editar_ruta.php' method='POST' autocomplete='off'> ";
    echo"<table>";
    echo"<tr class='primeralinea'>";
    echo"<td class='primeralinea'>NUMERO PRESTAMO</td>";
    echo"<td class='primeralinea'>NOMBRE</td>";
    echo"<td class='primeralinea'>DIRECCION</td>";
    echo"<td class='primeralinea'>CIUDAD</td>";
    echo"<td class='primeralinea'>POSICION RUTA</td>";
    echo"<td class='primeralinea'>POSICION NUEVA</td>";
    echo"<td class='primeralinea'>PRESTAMO</td>";
    echo"<td class='primeralinea'>CUOTA DIARIA</td>";
    echo"<td class='primeralinea'>TOTAL CUOTAS</td>";
    do
    {
     echo"<tr>";
     echo"<td> <input type='text' class='td_abono' name='num_id[]' size='6' value=".$matriz['num_prestamo']." readonly></td>";
     echo"<td> ".$matriz['nombre']."</td>";
     echo"<td> ".$matriz['direccion']."</td>";
     echo"<td> ".$matriz['ciudad']."</td>";
     echo"<td> <input type='text' class='td_abono' name='ruta[]' size='4' value=".$matriz['orden_ruta']." readonly></td>";
     echo"<td> <input type='text' class='td_abono' name='nr[]' size='4' value=".$matriz['orden_ruta']." tabindex='1'></td>";
     echo"<td> $".$matriz['monto']."</td>";
     echo"<td> $".$matriz['cuota']."</td>";
     echo"<td> ".$matriz['num_cuotas']."</td>";
     echo"</tr>";
    }while($matriz=mysql_fetch_array($resultado));
    echo"</table><br>";
    echo"<input type='submit' class='btn btn-info' value='Guardar'> &nbsp; &nbsp;";
    echo"<input type='reset' class='btn btn-info' value='Borrar'>";
    echo"</form>";
  }
?>