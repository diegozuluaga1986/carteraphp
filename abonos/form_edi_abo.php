<?php
  session_start();
  include("../conexion.php");
  $conex=conectarse("cartera");
  setlocale (LC_TIME,"spanish");
?>
<html>
<head>
<title></title>
<link href="../resultados.css" rel="stylesheet" type="text/css">
<link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
<link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">  
<link rel="stylesheet" href="../funciones/jquery-ui-1.11.2/jquery-ui.css" />
    <script type="text/javascript" src="../bootstrap2/js/bootstrap.js"></script>
    <script type="text/javascript" src="../funciones/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="../funciones/jquery-ui-1.11.2/jquery-ui.js"></script>
    <script type="text/javascript" src="../funciones/funciones.js"></script>
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
  <center><h4>Ingresar fecha</h4>        
    <form name="insertar_fecha" action="form_edi_abo.php" method="POST" autocomplete="off">  
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
    $fecha=$_POST['fecha'];
    $consult= "select * from carteras where nombre_car = '$cartera';";
    $result=mysql_query($consult,$conex);
    $mat=mysql_fetch_array($result);
    $cod_cart=$mat['cod_cartera'];
    $suma=0;
    $x=1;
    if(!(empty($fecha))){
      $consulta="select detalle_movimientos.fecha_m, detalle_movimientos.contador, detalle_movimientos.monto_abono,";
      $consulta.=" detalle_movimientos.num_prestamo, prestamos.cod_cartera, prestamos.num_cliente, prestamos.orden_ruta, clientes.nombre,";
      $consulta.=" clientes.num_cliente from detalle_movimientos, prestamos, clientes";
      $consulta.=" where detalle_movimientos.num_prestamo=prestamos.num_prestamo";
      $consulta.=" and detalle_movimientos.fecha_m='$fecha' and prestamos.cod_cartera='$cod_cart'";
      $consulta.=" and prestamos.num_cliente=clientes.num_cliente order by prestamos.orden_ruta;";
      $resultado=mysql_query($consulta,$conex);
      $matriz=mysql_fetch_array($resultado);
      
      $fa=$fecha;
      $FechaArreglo = explode("-", date("m-d-Y", strtotime($fa)));
      $Fecha = mktime(0, 0, 0, $FechaArreglo[0], $FechaArreglo[1], $FechaArreglo[2]);
      $fa=strftime("%A, %d de %B de %Y", $Fecha);  
      echo $fa;
      echo "<br>";
      echo"<center><table>";
        echo"<tr class='primeralinea'>";
          echo"<td class='td_fecha'>CONTADOR</td>";
          echo"<td class='td_fecha'>FECHA</td>";
          echo"<td class='primeralinea'>RUTA</td>";
          echo"<td class='primeralinea'>NOMBRE</td>";
          echo"<td class='primeralinea'>ABONO</td>";
          echo"<td class='primeralinea'>ACCION</td>";
        echo"</tr>";
        do{
          echo"<tr>";
          $cont=$matriz['contador'];
          echo"<td class='td_fecha'> <input type='text' name='cont' size='15' value=".$cont." readonly></td>";  //FECHA invisible en navegador    
          echo"<td class='td_fecha'> <input type='text' name='f' size='8' value=".$fecha." readonly></td>";  //FECHA invisible en navegador 
          echo"<td>".$matriz['orden_ruta']."</td>";//RUTA 
          echo"<td class='nombre'> ".$matriz['nombre']."</td>";//NOMBRE
          echo"<td><input type='text' class='td_abono' name='abono' size='9' value=".$matriz['monto_abono']." readonly></td>";  
          echo"<td><a href='editar_abo.php?id=$cont' class='btn btn-info'>Editar</a></td>";
          $suma=$suma+$matriz['monto_abono'];
          if ($matriz['monto_abono']>0) {
            $coteo=$coteo+1;
          }
        echo"</tr>";
        }while($matriz=mysql_fetch_array($resultado));
        echo "<tr class='primeralinea'><td></td><td class='primeralinea'>Total cobro</td><td class='primeralinea'>$".$suma."</td><td></td></tr>";
        echo "<tr class='primeralinea'><td></td><td class='primeralinea'>Cotearon</td><td class='primeralinea'>".$coteo."</td><td></td></tr>";
        echo"</table></center><br>";
    }  
  }
  else
  echo "<h2>Debe elegir una cartera </h2>";
  mysql_close($conex);
?>