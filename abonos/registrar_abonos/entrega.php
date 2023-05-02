<?php
  session_start();
  include("../../conexion.php");
  $conex=conectarse("cartera");
  $cartera=$_SESSION['cartera'];
  $fecha=$_GET['fecha'];
  $tabla = "cobradores";
  $consulta = "select * from $tabla";
  $resultado=mysql_query($consulta);
  $m_co=mysql_fetch_array($resultado);
  $consult= "select * from carteras where nombre_car = '$cartera';";
  $result=mysql_query($consult,$conex);
  $mat=@mysql_fetch_array($result);
  $cod_cart=$mat['cod_cartera'];
  if($cartera!="")
  {
?>
<html>
  <head>
    <title>Entrega cobrador</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
    <link href="../../resultados.css" rel="stylesheet" type="text/css">
    <link href="../../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">  
    <link rel="stylesheet" href="../../funciones/jquery-ui-1.11.2/jquery-ui.css" />
    <script type="text/javascript" src="../../bootstrap2/js/bootstrap.js"></script>
    <script type="text/javascript" src="../../funciones/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="../../funciones/jquery-ui-1.11.2/jquery-ui.js"></script>
    <script type="text/javascript" src="../../funciones/funciones.js"></script>
  </head>
  <body>
    <br>
    <center>
      <H2>Cartera: <?php echo $cartera; ?></H2>
      <br>
      <H3>Fecha: <?php echo $fecha; ?></H3>
      <div>
        <form name='cuadre' action='registrar_entrega.php' method='POST' autocomplete='off'>
          <table border='2'>
<?php            
            echo "<tr><td>Cobrador:</td><td colspan='2' class='formulario'><select name='cobra'>";
                  echo "<option>";
                      do{
                  echo "<option>".$m_co['nombre_co']."</option>";          
                      }while($m_co=mysql_fetch_array($resultado));
                  echo "</td></tr>";//Cobrador
            echo "<tr><td>Fecha:</td><td colspan='2' class='formulario'><input type='text' name='fecha' size='10' value='$fecha' readonly></td></tr>";//Fecha
            echo "<tr><td>Base:</td><td colspan='2' class='formulario'><input type='text' name='base' size='6' onkeyup='puntitos(this,this.value.charAt(this.value.length-1),0)'></td></tr>";//Base
            echo "<tr><td colspan='2'></td></tr>";
            echo "<tr><td>Efectivo:</td><td colspan='2' class='formulario'><input type='text' name='efectivo' size='8' onkeyup='puntitos(this,this.value.charAt(this.value.length-1),0)'></td></tr>";//Efectivo
            $number=number_format($monto_nuevos, 0, ",",".");
            echo "<tr><td>Nuevos:</td><td colspan='2' class='formulario'><input type='text' name='nuevo' size='8' onkeyup='puntitos(this,this.value.charAt(this.value.length-1),0)'></td></tr>";//Nuevos
            echo "<tr><td>Vale cobrador:</td><td colspan='2' class='formulario'><input type='text' name='vale' size='8' onkeyup='puntitos(this,this.value.charAt(this.value.length-1),0)'></td></tr>"; //Vale           
            echo "<tr><td>Vale Supervisor:</td><td colspan='2' class='formulario'><input type='text' name='vale_sup' size='8' onkeyup='puntitos(this,this.value.charAt(this.value.length-1),0)'></td></tr>"; // Vale supervisor
            echo "<tr><td>Gastos oficina:</td><td colspan='2' class='formulario'><input type='text' name='gastos' size='8' onkeyup='puntitos(this,this.value.charAt(this.value.length-1),0)'></td></tr>";// Gastos
            echo "<tr><td>Entregue:</td><td colspan='2' class='formulario'><input type='text' name='entregue' size='8' onkeyup='puntitos(this,this.value.charAt(this.value.length-1),0)'></td></tr>";//Entregue
            echo "<tr><td>Recibi:</td><td colspan='2' class='formulario'><input type='text' name='recibi' size='8' onkeyup='puntitos(this,this.value.charAt(this.value.length-1),0)'></td></tr>";//Recibi
          echo "</table>";  
      echo"</div>";
      echo"<p><input type='submit' class='btn btn-info' value='Enviar'></P>";
      echo "</center>";
      echo "</form>";
  }//if($cartera!="")
  else
  echo "<h2>Debe elegir una cartera </h2>";
  mysql_close($conex);
?>
</body>
</html>