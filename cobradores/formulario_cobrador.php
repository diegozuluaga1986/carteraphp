<?php
include("../conexion.php");
$conex=conectarse("cartera");
$tabla = "cobradores";
$consulta = "select * from $tabla";
$resultado=mysql_query($consulta);
$numregistros=mysql_numrows($resultado);
$numero=$numregistros + 1;
?> 
<html lang="es"> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<head><title>inserci&oacute;n</title> 
  <link href="../resultados.css" rel="stylesheet" type="text/css">
  <link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
    <link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">  
    <script type="text/javascript" src="../bootstrap2/js/bootstrap.js"></script>
    <script type="text/javascript" src="../funciones/funciones.js"></script>
     <script type="text/javascript">

window.onload = function () {

document.inser_cliente.nombre.focus();

document.inser_cliente.addEventListener('submit', validarFormulario);

}

 

function validarFormulario(evObject) {

evObject.preventDefault();

var todoCorrecto = true;

var formulario = document.inser_cliente;

for (var i=0; i<4; i++) {

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

    <center><H3>Entrada de datos para registro de cobradores</H3>
      <Form name="inser_cliente" method="Post" Action="insert_cobrador.php"> 
        <Table>
          <TR>
            <TD>Numero:</TD>
            <TD class="formulario"> <input type="text" name="numero" size="10" value="<?php echo $numero ?>" readonly>
          </TR>
          <TR>
            <TD>* Nombre:</TD>
            <TD class="formulario"><input type="text" name="nombre" size="60"></TD>
          </TR>
          <TR>
            <TD>* Telefono:</TD>
            <TD class="formulario"><input type="text" name="telefono" size="10"></TD>
          </TR>
          <TR>
            <TD>* Sueldo:</TD>
            <TD class="formulario"><input type="text" name="sueldo" size="6" onkeyup="puntitos(this,this.value.charAt(this.value.length-1),0)"></TD>
          </TR>
         
       </Table>  
	   <br> 
       <input type='submit' class='btn btn-info' value='Grabar'>
       <input type="reset" class="btn btn-info" value="Borrar">
      </Form>
    </center>
  </body>
</html>