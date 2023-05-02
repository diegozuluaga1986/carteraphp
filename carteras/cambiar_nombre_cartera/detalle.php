<?php
  session_start();
  include("../../conexion.php");
  $conex=conectarse("cartera");
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
</head>
<body>
<?php
  $cartera=$_SESSION['cartera'];
  if($cartera!=""){
    echo"<h2>Modificar cartera ".$cartera."</h2>";
    echo "<br>";
	$consult= "select * from carteras where nombre_car = '$cartera';";
    $result=mysql_query($consult,$conex);
    $mat=mysql_fetch_array($result);
    echo"<center>";
    echo"<form name='editar' method='post' Action='editar_cartera.php'>";
    do{
        echo"<table>";
        echo"<tr><td>Codigo Cartera</td>";
        echo"<td><input type='text' name='car' size='6' value=".$mat['cod_cartera']." readonly></td></tr>";
        echo"<tr><td>Nombre Actual *</td>";
        echo"<td>".$mat['nombre_car']." </td></tr>";
        echo"<tr><td>Nuevo Nombre *</td>";
        echo"<td><input type='text' name='nomco' size='20'</td></tr>";
        echo"</table><br>"; 
    }while($mat=mysql_fetch_array($result));
    echo"<input type='submit' class='btn btn-info' value='Modificar'>"; 
    echo"</form>";
    echo "</center>";    
?>


<?php
}
else
echo "<h2>Debe elegir una cartera </h2>";
mysql_close($conex);
?>
</body>
</html>