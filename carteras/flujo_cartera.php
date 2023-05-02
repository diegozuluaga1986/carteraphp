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
    <link rel="stylesheet" href="../funciones/jquery-ui-1.11.2/jquery-ui.css" />
    <script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="../funciones/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="../funciones/jquery-ui-1.11.2/jquery-ui.js"></script>
    <script type="text/javascript" src="../funciones/funciones.js"></script>
</head>
<body>
<br><br>
<?php
  $cartera=$_SESSION['cartera'];
  if($cartera!=""){
    echo $cartera;
?>
<!--captura fecha//-->
<div class="buscar_cliente">
  <center><h2>Registrar flujo de caja</h2>        
    <form name="insertar_fecha" action="flujo_cartera.php" method="POST">  
      <table>
        <tr>
          <td>Fecha: </td>
          <td class="formulario"><input type="text" style='width:auto' name="fecha" id="calen" size="8" ></td>
        </tr> 
        <tr>
          <td colspan="2"><center><input type="submit" class="btn btn-info" value="Ingresar"></center></td>
        </tr>
      </table>
    </form>  
  </center>
</div>
<!-- fin captura fecha //-->
<?php   
    $fecha=$_POST['fecha'];
    $consult= "select * from carteras where nombre_car = '$cartera';";
    $result=mysql_query($consult,$conex);
    $mat=mysql_fetch_array($result);
    $cod_cart=$mat['cod_cartera'];
    if(!(empty($fecha))){
      $consul_monto="select sum(monto_abono) from detalle_movimientos where fecha_m='$fecha';";
      $res=mysql_query($consul_monto,$conex);
      $m=@mysql_result($res,0);   
      echo "<center>".$fecha."</center>";
      echo "<center><div id='detalle'>";
      echo"<form name='flujo' action='registro_flujo.php' method='POST'> ";
      echo"<table border='2'>";
      echo"<tr><td class='invisible'>cod_cartera: </td><td class='invisible'><input type='text' name='cart' size='6' value=".$cod_cart."></td></tr>";
      echo"<tr><td class='invisible'>fecha: </td><td class='invisible'><input type='text' name='fech' size='6' value=".$fecha."></td></tr>";
      echo"<tr><td>Cobro: </td><td class='formulario'><input type='text' name='cobro' size='10' value=".$m."></td></tr>";
      echo"<tr><td>renovado: </td><td class='formulario'><input type='text' name='rn' size='10'></td></tr>";
      echo"<tr><td>Prestamos nuevos: </td><td class='formulario'><input type='text' name='np' size='10'></td></tr>";
      echo"<tr><td>Gasolina: </td><td class='formulario'><input type='text' name='gas' size='6'></td></tr>";
      echo"<tr><td>Viaticos: </td><td class='formulario'><input type='text' name='via' size='6'></td></tr>";  
      echo"<tr><td>Sueldo cobrador: </td><td class='formulario'><input type='text' name='sueldo' size='8'></td></tr>";  
      echo"<tr><td>Sueldo secre: </td><td class='formulario'><input type='text' name='sec' size='6'></td></tr>";
      echo"<tr><td>Gastos oficina: </td><td class='formulario'><input type='text' name='gc' size=''></td></tr>";
      echo"<tr><td>Ahorro: </td><td class='formulario'><input type='text' name='ah' size='8'></td></tr>";
      echo"<tr><td>Dividendos: </td><td class='formulario'><input type='text' name='div' size='10'></td></tr>";
      echo"<tr><td>Base: </td><td class='formulario'><input type='text' name='base' size='8'></td></tr>";
      echo"</table></div>";
      echo"<br><input type='submit' class='btn btn-info' value='Insertar'> &nbsp; &nbsp;";
      echo"<input type='reset' class='btn btn-info' value='Borrar'></form></div>"; 
      echo"<br><br><br>";      
    }
    else{
    echo "<h2>Debe ingresar una fecha</h2>";
    }
  }
  else
  echo "<h2>Debe elegir una cartera";  
  mysql_close($conex);
?>
</body>
</html>