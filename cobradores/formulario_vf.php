<?php
include("../conexion.php");
$conex=conectarse("cartera");
$tabla = "cobradores";
$consulta = "select * from $tabla";
$resultado=mysql_query($consulta);
$m_co=mysql_fetch_array($resultado);
?> 
<html lang="es"> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<head><title>inserci&oacute;n</title> 
  <link href="../resultados.css" rel="stylesheet" type="text/css">
  <link href="../bootstrap2/css/bootstrap.css" rel="stylesheet">   
  <link href="../bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
  <link rel="stylesheet" href="../funciones/jquery-ui-1.11.2/jquery-ui.css" />  
    <script type="text/javascript" src="../bootstrap2/js/bootstrap.js"></script>
    <script type="text/javascript" src="../funciones/jquery-1.11.2.js"></script>
    <script type="text/javascript" src="../funciones/jquery-ui-1.11.2/jquery-ui.js"></script>
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

for (var i=0; i<2; i++) {

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

    <center><H3>Registro de vales y faltantes</H3>
      <Form name="inser_cliente" method="Post" Action="insert_vf.php"> 
        <Table>
          <TR>
            <TD>* Cobrador:</TD>
            <TD class="formulario"><select name='cobra'>
                  <option>
                     <?php
                      do{
                        echo"<option>".$m_co['nombre_co']."</option>";          
                      }while($m_co=mysql_fetch_array($resultado));  
                    ?></TD>
          </TR>
          <TR>
            <TD>* Fecha:</TD>
             <td class="formulario"><input type="text" style='width:auto' name="fecha" id="calen" size="8"></td>
          </TR>
          <TR>
            <TD>* Vale:</TD>
            <TD class="formulario"><input type="text" name="vale" size="10" onkeyup="puntitos(this,this.value.charAt(this.value.length-1),0)"></TD>
          </TR>
          <TR>
            <TD>* Faltante:</TD>
            <TD class="formulario"><input type="text" name="faltante" size="10" onkeyup="puntitos(this,this.value.charAt(this.value.length-1),0)"></TD>
          </TR>
         
       </Table>  
	   <br> 
       <input type='submit' class='btn btn-info' value='Grabar'>
       <input type="reset" class="btn btn-info" value="Borrar">
      </Form>
    </center>
  </body>
</html>