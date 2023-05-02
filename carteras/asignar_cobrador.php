<?php
  session_start();
  include("../conexion.php");
  $conex=conectarse("cartera");
?> 
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Asignacion cobrador</title>
	<link href="../resultados.css" rel="stylesheet" type="text/css">
<link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">  
    <script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
</head>
<body>
<?php
  $cartera=$_SESSION['cartera'];
  if($cartera!=""){	
    $bus_cobra="select * from cobradores order by id_cob;";
    $r_bus=mysql_query($bus_cobra,$conex);
    $m_cobradores=mysql_fetch_array($r_bus);

    echo"<center>";
    echo"<h2>Asignar cobrador a cartera ".$cartera."</h2>";
    echo "<br>";
    echo"<form name='asignar' method='post' Action='recibe_asignacion.php'>";
    echo"<table>";
    echo"<tr><td>Cobrador</td>";
    echo"<td><select name='cobrador'>";
    echo"<option> </option>";            
    do{
        echo"<option>".$m_cobradores['nombre_co']."</option>";          
    }while($m_cobradores=mysql_fetch_array($r_bus));
    echo "</td></tr>";
    echo"</table><br>"; 
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