<?php
  include("../../conexion.php");
  $conex=conectarse("cartera");
?>
  <!doctype html>
  <html>
    <head>
      <meta charset="iso-8859-1" /> 
      <meta content="Miller Posada" name="author" />
      <meta content="registro de prestamos" name="description" />
      <meta content="etiqueta1, etiqueta2, etiqueta3" name="prestamos" />
      <title></title>
      <link href="../../resultados.css" rel="stylesheet" type="text/css">    
      <link href="../../bootstrap2/css/bootstrap.css" rel="stylesheet">   
      <link href="../../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" media="screen" href="../estilo.css" />   
      <link rel="stylesheet" href="../funciones/jquery-ui-1.11.2/jquery-ui.css" />
      <script type="text/javascript" src="../../bootstrap2/js/bootstrap.js"></script>
      <script type="text/javascript" src="../../funciones/jquery-1.11.2.js"></script>
      <script type="text/javascript" src="../../funciones/jquery-ui-1.11.2/jquery-ui.js"></script>
      <script type="text/javascript" src="../../funciones/funciones.js"></script>
       <script type="text/javascript">

window.onload = function () {

document.insertar.focus();

document.insertar.addEventListener('submit', validarFormulario);

}

 

function validarFormulario(evObject) {

evObject.preventDefault();

var todoCorrecto = true;

var formulario = document.insertar;

for (var i=0; i<6; i++) {

                if(formulario[i].type =='text') {

                               if (formulario[i].value == null || formulario[i].value.length == 0 || /^\s*$/.test(formulario[i].value)){

                               alert (formulario[i].name+ ' no puede estar vacio o contener solo espacios en blanco');

                               todoCorrecto=false;

                               }
                               

                }

}
/*if (formulario[3].value.length < 6 ){

                               alert (' Solo se acepta un prestamo minimo de $10.000, recuerde escribir cifras completas con todos los ceros');

                               todoCorrecto=false;

                               }*/
var montofinal=formulario[4].value * formulario[5].value;                               

if (montofinal <= formulario[3].value ){

                               alert ('Tienes un error en el valor o en el numero de las cuotas ');

                               todoCorrecto=false;

                               }
if (todoCorrecto ==true) {formulario.submit();}

}

 
</script>
    </head>
    <body> 
<?php
  $p_ant=$_GET['id'];
  $fecha=$_GET['fecha'];
  //buscar prestamo anterior
  $consulta="select prestamos.num_prestamo, prestamos.num_cliente,";
  $consulta.=" prestamos.orden_ruta,";
  $consulta.=" prestamos.cod_cartera, prestamos.dia_abona,";
  $consulta.=" clientes.nombre from";
  $consulta.=" prestamos, clientes where prestamos.num_prestamo=$p_ant";
  $consulta.=" and prestamos.num_cliente=clientes.num_cliente; ";
  $resultado=mysql_query($consulta,$conex);
  $matriz=mysql_fetch_array($resultado);
  $cartera=$matriz['cod_cartera'];  
  $n_cliente=$matriz['num_cliente'];
  $numero=$matriz['orden_ruta'];
  $dia_cobro=$matriz['dia_abona'];
  //actualizar prestamo anterior
  $ins="update prestamos set renovado='1' where num_prestamo='$p_ant';";
  $rins=mysql_query($ins,$conex);
  
  echo "<H3>RENOVACI&Oacute;N</H3>";
  echo "<center><div id='detalle'>";
  echo"<form name='insertar' action='registrar_renovacion.php' method='POST' autocomplete='off'>";
  echo"<table border='2'>";
  echo"<tr><td>No. Cliente: </td><td colspan='2' class='formulario'><input type='text' name='num' size='10' value='$n_cliente' readonly></td>";//N Cliente:
  echo"<td>Cartera:</td><td colspan='2' class='formulario'><input type='text' name='cart' value='$cartera' readonly></tr>";//Cartera:
  echo"<tr><td>Nombre:</td><td colspan='2'>".$matriz['nombre']."</td>";//nombre
  echo "<td>Fecha: </td><td colspan='2' class='formulario'><input type='text' name='Fecha' size='10' value='$fecha' readonly></td></tr>";
  echo"<tr><td>Monto Prestamo: </td><td class='formulario'><input type='text' name='Monto_prestamo' dir='rtl' size='6' maxlength='4'></td><td class='formulario'>.000</td>";//Monto:   
  echo"<td>Valor Cuota: </td><td class='formulario'><input type='text' name='valor_cuota' dir='rtl' size='5' maxlength='3'></td><td class='formulario'>.000</td></tr>";//Valor cuota: 
  echo"<tr><td>Cantidad de cuotas: </td><td colspan='2' class='formulario'><input type='text' name='numero_cuotas' size='3'></td>";//N cuotas: 
  echo"<td>No. Ruta: </td><td colspan='2' class='formulario'><input type='text' name='ruta' size='5' value='$numero'></td></tr>";//N ruta:  
  echo"<tr><td>Anticipo: </td><td class='formulario'><input type='text' name='anti' dir='rtl' size='5' maxlength='3'><td class='formulario'>.000</td></td>";//Anticipo
  echo"<td>Dia cobro: </td><td colspan='2' class='formulario'><input type='text' name='dcobro' size='5' value='$dia_cobro'></td></tr>";
  echo"</table><br> <input type='submit' class='btn btn-info' value='Insertar'>";
  echo "</form></div>";
?> 
</body>
</html> 