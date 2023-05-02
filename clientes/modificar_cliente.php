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
  </head>
  <body>  
  <br>
  <h3>Formulario actualizacion de datos de clientes</h3>
  <br>
<?php
  $cliente_id=$_GET['id'];
  if(!(empty($cliente_id)))
  {
    $consulta="select * from clientes where num_cliente='$cliente_id';"; 
    $resultado=mysql_query($consulta,$conex); 
    $matriz=mysql_fetch_array($resultado);  
  }

    if(!(empty($resultado)))
    {
      echo"<center>";  
      echo"<form name='Insertar' method='post' Action='editar_cliente.php'>";
      echo"<table>";
      echo"<tr class='primeralinea'><td class='primeralinea'>CLIENTE N°</td>";
      echo"<td><input type='text' name='num_cliente' size='6' value=".$matriz['num_cliente']." readonly> </tr>";
      $nom=$matriz['nombre'];
      echo"<tr><td>NOMBRE</td><td><input type='text' name='nom' value='$nom'></td></tr>";
      $ced=$matriz['cedula'];
      echo"<tr><td>CEDULA</td><td><input type='text' name='ced' value='$ced' </td></tr>";
      echo"<tr><td>PROFESION</td>";
      $prof=$matriz['profesion'];
      echo"<td><input type='text' name='labor' value='$prof'></td></tr>";
      echo"<tr><td>DIRECCION</td>";
      $direccion=$matriz['direccion'];
      echo"<td><input type='text' name='dir' value='$direccion'></td></tr>";
      echo"<tr><td>BARRIO</td>";
      $barrio=$matriz['barrio'];
      echo"<td><input type='text' name='bar' value='$barrio'></td></tr>";
      echo"<tr><td>CIUDAD</td>";
      $ciudad=$matriz['ciudad'];
      echo"<td><input type='text' name='ciu' value='$ciudad'></td></tr>";
      echo"<tr><td>TELEFONO 1</td>";
      $tel=$matriz['tel_fijo'];
      echo"<td><input type='text' name='tf' value='$tel'></td></tr>";
      echo"<tr><td>TELEFONO 2</td>";
      $tel2=$matriz['celular'];  
      echo"<td><input type='text' name='cel' value='$tel2'></td></tr>";     
      echo"</table><br>";
      echo"<input type='submit' class='btn btn-info' value='Modificar'>";
      echo"</form>";
      echo"</center>";  
    }
  
  mysql_close($conex);
?>


  </body>
</html>