<?php
include("../../conexion.php");
$conex=conectarse("cartera");
$tabla = "carteras";
$consulta = "select * from $tabla";
$resultado=mysql_query($consulta);
$numregistros=mysql_numrows($resultado);
$numero=$numregistros + 1;
?> 
<html>
<head><title>crear cartera</title> 
<link href="../../resultados.css" rel="stylesheet" type="text/css">
<link href="../../bootstrap2/css/bootstrap.css" rel="stylesheet">   
<link rel="stylesheet" href="../../funciones/jquery-ui-1.11.2/jquery-ui.css" />
    <link href="../../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="../../estilo.css" />   
    <script type="text/javascript" src="../../bootstrap2/js/bootstrap.js"></script>
    <script type="text/javascript" src="../../funciones/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="../../funciones/jquery-ui-1.11.2/jquery-ui.js"></script>
    <script type="text/javascript" src="../../funciones/funciones.js"></script>
    <script type="text/javascript">

window.onload = function () {

document.Insertar.Nombre_cartera.focus();

document.Insertar.addEventListener('submit', validarFormulario);

document.getElementById("text").addEventListener("keydown", teclear);

var flag = false;
var teclaAnterior = "";

function teclear(event) {
  teclaAnterior = teclaAnterior + " " + event.keyCode;
  var arregloTA = teclaAnterior.split(" ");
  if (event.keyCode == 32 && arregloTA[arregloTA.length - 2] == 32) {
    event.preventDefault();
  }
} 

}

 

function validarFormulario(evObject) {

evObject.preventDefault();

var todoCorrecto = true;

var formulario = document.Insertar;

for (var i=0; i<3; i++) {

                if(formulario[i].type =='text') {

                               if (formulario[i].value == null || formulario[i].value.length == 0 || /^\s*$/.test(formulario[i].value)){

                               alert (formulario[i].name+ ' no puede estar vacio o contener solo espacios en blanco');

                               todoCorrecto=false;

                               }

                }

                }

if (todoCorrecto ==true) {formulario.submit();}

}

</script>
</head>
  <body>
    <br><br>
    <center><H3>CREANDO NUEVA CARTERA</H3>
      <Form name="Insertar" method="Post" Action="insertar_cartera.php">
        <Table>
          <TR>
            <TD>* Nombre Cartera:</TD>
            <TD class="formulario"><input type="text" name="Nombre_cartera" size="60" id="text"></TD>
          </TR>
          <TR>                      
            <TD>* Cobrador:</TD>
            <TD class="formulario"><input type="text" name="Cobrador" size="60"></TD>
          </TR>
          <TR>  
            <TD>* Fecha Inicio:</TD>
            <td class='formulario'><input type='text' name='Fecha' id='calen' size='10'></td>
          </tr>
          </TR>
       </Table>  
	   <br> 
       <input type="submit" class="btn btn-info" value="Grabar">
       <input type="reset" class="btn btn-info" value="Borrar">
      </Form>
    </center><BR>
  </body>
</html>