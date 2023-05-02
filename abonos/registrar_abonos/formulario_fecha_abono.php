<?php
  session_start();
  include("../../conexion.php");

  $conex=conectarse("cartera");
?>
<html>
<head>
<title></title>
<link href="../../resultados.css" rel="stylesheet" type="text/css">
<link href="../../bootstrap2/css/bootstrap.css" rel="stylesheet">   
<link href="../../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">  
<link rel="stylesheet" href="../../funciones/jquery-ui-1.11.2/jquery-ui.css" />
    <script type="text/javascript" src="../../bootstrap2/js/bootstrap.js"></script>
    <script type="text/javascript" src="../../funciones/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="../../funciones/jquery-ui-1.11.2/jquery-ui.js"></script>
    <script type="text/javascript" src="../../funciones/funciones.js"></script>
<body>
</head>
<br><br>
<?php
  $cartera=$_SESSION['cartera'];
  if($cartera!=""){
    echo "<H2>".$cartera."</H2>";
?>
<!--captura fecha//-->
<div class="buscar_cliente">
  <center><h4>Registrar Abonos</h4>        
    <form name="insertar_fecha" action="tabulador_abonos.php" method="POST" autocomplete="off" target="_blank">  
      <table>
        <tr>
          <td>Fecha: </td>
          <td class="formulario"><input type="text" style='width:auto' name="fecha" id="calen" size="8"></td>
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
    
  }
  else
  echo "<h2>Debe elegir una cartera </h2>";
  mysql_close($conex);
?>
</body>
</html>