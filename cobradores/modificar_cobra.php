<?php
  include("../conexion.php");
  $conex=conectarse("cartera");
?>
<html lang="es">
  <head><title>Modificar datos cobradores</title>
    <meta charset="UTF-8">
    <link href="../resultados.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="../estilo.css" />   
    <script type="text/javascript" src="../bootstrap2/js/bootstrap.js"></script>
  </head>
  <body>  
  <br>
  <h3>Actualizacion datos cobradores</h3>
  <br>
<?php
  $cobrador_id=$_GET['id'];
  if(!(empty($cobrador_id)))
  {
    $consulta="select * from cobradores where id_cob='$cobrador_id';"; 
    $resultado=mysql_query($consulta,$conex); 
    $matriz=mysql_fetch_array($resultado);  
    $con_cart="select * from carteras where activa ='1';";
    $res=mysql_query($con_cart,$conex);
    $carteras=mysql_fetch_array($res);
  }

    if(!(empty($resultado)))
    {
      echo"<center>";  
      echo"<form name='Insertar' method='post' Action='editar_cobrador.php'>";
      echo"<table>";
      echo"<tr class='primeralinea'><td class='primeralinea'>N°</td>";
      echo"<td><input type='text' name='id_cob' size='6' value=".$matriz['id_cob']." readonly> </tr>";
      $nom=$matriz['nombre_co'];
      echo"<tr><td>Nombre: </td><td><input type='text' name='nom' value='$nom'></td></tr>";//Nombre
      echo "<tr><td>Sueldo: </td>";
      $sueldo=$matriz['sueldo'];
      echo "<td><input type='text' name='sueldo' value='$sueldo'></td></tr>";//Sueldo
      echo "</td></tr>";
      echo "<tr><td>Cargo: </td>";//cargo
      echo "<td><select name='cargo'>";//cargo
      echo"<option>cobrador</option>";      //cargo    
      echo"<option>supervisor</option>";    //cargo
      echo "</td></tr>";
      echo "<tr class='primeralinea'><td colspan='2'>Datos personales</td></tr>";
      echo"<tr><td>Telefono: </td>";
      $tel2=$matriz['telefono'];  //telefono
      echo"<td><input type='text' name='cel' value='$tel2'></td></tr>";  //telefono
      echo"<tr><td>Dirección: </td>";//direccion
      $direccion=$matriz['direccion'];//direccion 
      echo"<td><input type='text' name='dir' value='$direccion'></td></tr>";//direccion
      echo"<tr><td>Barrio: </td>";//Barrio
      $barrio=$matriz['barrio'];//Barrio
      echo"<td><input type='text' name='bar' value='$barrio'></td></tr>";//barrio
      echo"<tr><td>Ciudad: </td>";//ciudad
      $ciudad=$matriz['ciudad'];//ciudad
      echo"<td><input type='text' name='ciu' value='$ciudad'></td></tr>";    
      echo"</table><br>";
      echo"<input type='submit' class='btn btn-info' value='Modificar'>";
      echo "<br><br>";
      echo"</form>";
      echo "<br><br>";
      echo"</center>";  
    }
  
  mysql_close($conex);
?>


  </body>
</html>