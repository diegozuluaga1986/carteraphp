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
     <script type="text/javascript">

window.onload = function () {

document.Insertar.focus();

document.Insertar.addEventListener('submit', validarFormulario);

}

 

function validarFormulario(evObject) {

evObject.preventDefault();

var todoCorrecto = true;

var formulario = document.Insertar;

for (var i=0; i<=6; i++) {

                if(formulario[i].type =='text') {

                               if (formulario[i].value == null || formulario[i].value.length == 0 || /^\s*$/.test(formulario[i].value)){

                                    alert (formulario[i].name+ ' no puede estar vacio o contener solo espacios en blanco');
          
                                    todoCorrecto=false;

                               }

                }

}
control=formulario[2].value*formulario[3].value;
if (control<=formulario[1].value) {
    alert ('El monto final no puede ser igual o inferior al monto inicial');
    todoCorrecto=false;
}

if (todoCorrecto ==true) {formulario.submit();}

}

 
</script>
  </head>
  <body>  
  <br>
  <h3>Formulario para modificar prestamos</h3><br>
<?php
  
  $npres=$_GET['id'];
  if(!(empty($npres)))
  {
    $consulta="select prestamos.num_prestamo, prestamos.num_cliente,";
    $consulta.=" prestamos.fecha_inicio, prestamos.monto, prestamos.num_cuotas,";
    $consulta.=" prestamos.cuota, prestamos.monto_final, prestamos.orden_ruta,";
    $consulta.=" prestamos.cod_cartera, prestamos.dia_abona,";
    $consulta.=" clientes.nombre from";
    $consulta.=" prestamos, clientes where prestamos.num_prestamo=$npres";
    $consulta.=" and prestamos.num_cliente=clientes.num_cliente; ";
    $resultado=mysql_query($consulta,$conex);
    $matriz=mysql_fetch_array($resultado);  

    $cart="select * from carteras;";
    $rcart=mysql_query($cart,$conex);
    $carteras=mysql_fetch_array($rcart);  
  }
 
  if(!(empty($resultado)))
  {
    echo"<center>";  
      echo"<form name='Insertar' method='post' Action='editar_prestamo.php'>";
      echo"<table>";
      echo"<tr class='primeralinea'><td class='primeralinea'>No PRESTAMO</td>";
      echo"<td><input type='text' name='num_pres' size='6' value=".$matriz['num_prestamo']." readonly> </td></tr>";
      echo"<tr><td><h5>Nombre</h5></td><td><h5>".$matriz['nombre']."</h5></td></tr>";
      echo"<tr><td>Fecha</td><td>".$matriz['fecha_inicio']."</td></tr>";
      echo"<tr><td>Monto</td><td><input type='text' name='Monto' size='8' value=".$matriz['monto']." ></td></tr>";
      echo"<tr><td>cuota</td><td><input type='text' name='Cuota' size='8' value=".$matriz['cuota']." ></td></tr>";
      echo"<tr><td>No cuotas</td><td><input type='text' name='Numero_cuota' size='8' value=".$matriz['num_cuotas']." ></td></tr>";
      echo"<tr><td>Dia cobro</td><td><input type='text' name='dia_cobro' size='8' value=".$matriz['dia_abona']." ></td></tr>";
      echo"<tr><td>Pasar a cartera</td><td><select name='cartera'>";
      echo"<option> </option>";            
      do{
          echo"<option>".$carteras['nombre_car']."</option>";          
      }while($carteras=mysql_fetch_array($rcart));  
      echo"<td class='td_fecha'><input type='text' name='cc' size='8' value=".$matriz['cod_cartera']." readonly></td></tr>";//Numero cliente invisible en navegador
      echo"</table><br>";
      echo"<input type='submit' class='btn btn-primary' value='Modificar'>";
      echo"</form>";
      //echo "<br>";
      echo "<a href='..//abonos/form_consulta_abo.php?id=$npres' class='btn btn-primary'>Ver Ratio</a>";
      echo "<br><br>";
      echo "<a href='..//prestamos/formulario_anular.php?id=$npres' class='btn btn-danger'>Anular</a>";
      echo "<br>";
      echo"</center><br>";  
    }

  
  mysql_close($conex);
?>


  </body>
</html>