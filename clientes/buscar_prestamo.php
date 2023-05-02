  <?php
    include("../conexion.php");
    $conex=conectarse("cartera");
  ?>
    <!doctype html>
    <html>
      <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <title></title>
        <link href="../resultados.css" rel="stylesheet" type="text/css">    
        <link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
        <link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="screen" href="../estilo.css" />   
        <link rel="stylesheet" href="../funciones/jquery-ui-1.11.2/jquery-ui.css" />
        <script type="text/javascript" src="../bootstrap2/js/bootstrap.js"></script>
        <script type="text/javascript" src="../funciones/jquery-1.11.2.js"></script>
        <script type="text/javascript" src="../funciones/jquery-ui-1.11.2/jquery-ui.js"></script>
        <script type="text/javascript" src="../funciones/funciones.js"></script>
      </head>
      <body>
        <div class="buscar_cliente">
          <center><h2>Buscar Prestamos</h2>
            <form name="buscar" action="buscar_prestamo.php" method="POST">  
              <table>
                <tr>
                  <td>Cedula cliente: </td>
                  <td class="formulario"><input type="text" name="cedu" size="10" maxleng="10"></td>
                </tr>  
                <tr>
                  <td colspan="2"><center><input type="submit" class="btn btn-info" value="buscar"></center></td>
                </tr>
              </table>
            </form>  
          </center>
        </div>    
  <?php
      $ced=$_POST['cedu'];  
      $busca_cliente="select * from clientes where cedula='$ced'";
      $control=mysql_query($busca_cliente,$conex);
      $total_resul=mysql_num_rows($control);
      $cliente=@mysql_fetch_array($control); 
      if((!(empty($ced)))&&($total_resul==0))
      {
        echo "<script>";
        echo "window.alert('¡¡¡ Este cliente no posee prestamos ....¡¡¡¡');";
        echo "</script>";   
      }
      $id_cliente=$cliente['num_cliente'];
      $consulta="select prestamos.num_prestamo, prestamos.num_cliente,";
      $consulta.=" prestamos.fecha_inicio,"; 
      $consulta.=" DATE_ADD(prestamos.fecha_inicio, INTERVAL prestamos.num_cuotas DAY) 'fecha_fin',";    
      $consulta.=" prestamos.monto,";
      $consulta.=" prestamos.monto_final,";
      $consulta.=" prestamos.cuota,";
      $consulta.=" prestamos.dia_abona,";
      $consulta.=" prestamos.num_cuotas, prestamos.orden_ruta, prestamos.cod_cartera,"; 
      $consulta.=" prestamos.estado,";
      $consulta.=" prestamos.fin_pres,";
      $consulta.=" clientes.nombre, clientes.profesion, clientes.direccion, clientes.barrio,"; 
      $consulta.=" clientes.ciudad, clientes.celular, clientes.tel_fijo, carteras.cod_cartera, carteras.nombre_car from";
      $consulta.=" prestamos, clientes, carteras where prestamos.num_cliente='$id_cliente' and prestamos.num_cliente=clientes.num_cliente and";
      $consulta.=" prestamos.cod_cartera=carteras.cod_cartera;";
      $resultado=mysql_query($consulta,$conex);
      $matriz=@mysql_fetch_array($resultado);  

      //$consulta="select * from prestamos where presta";

  ?>
  <center><table>
          <tr class='primeralinea'>
            <td class='primeralinea'>CARTERA</td>
            <td class='primeralinea'>NOMBRE</td>
            <td class='primeralinea'>FECHA PRESTAMO</td>
            <td class='primeralinea'>PRESTAMO</td>
            <td class='primeralinea'>CUOTA</td>
            <td class='primeralinea'># CUOTAS</td>
            <td class='primeralinea'>MONTO FINAL</td>
            <td class='primeralinea'>ESTADO</td>
            <td class='primeralinea'>FECHA TERMINO</td>
            <td class='primeralinea'>DIAS MORA</td>
          </tr>
  <?php
          do
      {
            $fin_real=$matriz['fin_pres'];
            $fecha_fin=$matriz['fecha_fin'];
            $consul_mora="select DATEDIFF('$fin_real','$fecha_fin')";
            $r_conmora=mysql_query($consul_mora,$conex);
            $mora=@mysql_result($r_conmora,0);
            echo "<tr>";
            echo "<td>".$matriz['nombre_car']."</td>";
            echo "<td>".$matriz['nombre']."</td>";
            echo "<td>".$matriz['fecha_inicio']."</td>";
            $monto=number_format($matriz['monto'], 0, ",",".");
            echo "<td>".$monto."</td>";
            $cuota=number_format($matriz['cuota'], 0, ",",".");
            echo "<td>".$cuota."</td>";
            echo "<td>".$matriz['num_cuotas']."</td>";
            $montof=number_format($matriz['monto_final'], 0, ",",".");
            echo "<td>".$montof."</td>";
            if ($matriz['estado']==0) {
              $estado="Terminado";
            }
            if ($matriz['estado']==2) {
              $estado="Anulado";
            }
            if ($matriz['estado']==1) {
              $estado="Activo";
            }
            echo "<td>".$estado."</td>";
            echo "<td>".$matriz['fin_pres']."</td>";
            echo "<td>".$mora."</td>";
          echo "</tr>";
      }while($matriz=@mysql_fetch_array($resultado));
      echo"</table></center>\n";

  ?> 
  <br>
  </body> 
  </html>  