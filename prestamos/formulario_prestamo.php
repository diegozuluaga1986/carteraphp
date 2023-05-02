<?php
  session_start();
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
  $cartera=$_SESSION['cartera'];
  if ($cartera=="") {
    echo "<h2>Debe elegir una cartera</h2>";
  }
  else
  {
    $consult= "select * from carteras where nombre_car = '$cartera';";
    $result=mysql_query($consult,$conex);
    $mat=@mysql_fetch_array($result);
    $cod_cart=$mat['cod_cartera'];
    $tabla = "prestamos";
    $contador = "select * from $tabla where cod_cartera=$cod_cart and estado='1';";
    $resultado=mysql_query($contador);
    $numregistros=mysql_num_rows($resultado);
    $numero=$numregistros + 1;
    $ced=$_POST['cedu'];
    $ced2=$_SESSION['cc'];
    if (isset($ced2)) {
      $ced=$ced2;
    }
    if ($ced=="") {      
?>
      <div class="buscar_cliente">
        <center><h2>Nuevo Prestamo</h2>
          <form name="buscar" action="formulario_prestamo.php" method="POST">  
            <table>
              <tr>
                <td>Prestamo N°: </td>
                <td class="formulario"> <input type="text" name="numero" size="10" value="<?php echo $numero ?>" readonly></td>
              </tr>
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
    }         
    $busca_cliente="select * from clientes where cedula='$ced'";
    $control=mysql_query($busca_cliente,$conex);
    $total_resul=mysql_num_rows($control);

    if((!(empty($ced)))&&($total_resul==0))
    {
      echo "<script>";
      echo "window.alert('¡¡¡ Cliente Nuevo debe ingresarlo a la base de datos ....¡¡¡¡');";
      echo "document.location='../clientes/formulario_insert.php';";
      echo "</script>";   
    }
    if($total_resul==1)
    {
      $cliente_result=mysql_fetch_row($control);
      echo "<H3>NUEVO PRESTAMO</H3>";
      echo "<center><div id='detalle'>";
      echo"<form name='insertar' action='registrar.php' method='POST' autocomplete='off'>";
      echo"<table border='2'>";
      echo"<tr><td>N° Cliente: </td><td colspan='2' class='formulario'><input type='text' name='num' size='10' value='$cliente_result[0]'readonly></td>";//N Cliente:
      echo"<td>Cartera:</td><td colspan='2' class='formulario'><input type='text' name='cart' value='$cartera' readonly></tr>";//Cartera:
      echo"<tr><td>Nombre:</td><td colspan='5'>".$cliente_result[1]."</td></tr>";//Nombre:
      echo"<tr><td>Cedula:</td><td colspan='2'>".$cliente_result[2]."</td>";//Cedula:
      echo"<td>Fecha: </td><td colspan='2' class='formulario'><input type='text' name='Fecha' id='calen' size='10'></td></tr>";//Fecha:
      echo"<tr><td>Monto Prestamo: </td><td class='formulario'><input type='text' name='Monto_prestamo' dir='rtl' size='6' maxlength='4'></td ><td class='formulario'>.000</td>";//Monto:   
      echo"<td>Valor Cuota: </td><td class='formulario'><input type='text' name='valor_cuota' dir='rtl' size='5' maxlength='3'></td><td class='formulario'>.000</td></tr>";//Valor cuota: 
      echo"<tr><td>Total Cuotas: </td><td colspan='2' class='formulario'><input type='text' name='numero_cuotas' size='3'></td>";//N cuotas: 
      echo"<td>N° Ruta: </td><td colspan='2' class='formulario'><input type='text' name='ruta' size='5' value='$numero'></td></tr>";//N ruta:  
      echo"<tr><td>Anticipo: </td><td class='formulario'><input type='text' name='anti' dir='rtl' size='5'></td><td class='formulario'>.000</td>";//Anticipo
      echo"<td>Dia cobro: </td><td colspan='2' class='formulario'>
              <select name='dcobro'>
                <option>Diario</option>
                <option>Lun</option>
                <option>Mar</option>
                <option>Mier</option>
                <option>Jue</option>
                <option>Vie</option>
                <option>Sab</option>
                <option>Q/nal</option>
              </select></td></tr>";
      echo"</table><br> <input type='submit' class='btn btn-info' value='Insertar'>";
      echo " <input type='reset' class='btn btn-info' value='Borrar'></form></div>";

      echo"<form name='cerrar' action='cerrar.php' method='POST'>";
      echo"<input type='submit' class='btn btn-info' value='cancelar'>";

      $_SESSION['cc']=$ced;
    }
  }
      
?> 
</body>
</html> 