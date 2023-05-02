<?php
  session_start();
  include("../conexion.php");
  $conex=conectarse("cartera");
  $tabla = "clientes";  
  $consulta = "select * from $tabla";
  $resultado=mysql_query($consulta);
  $numregistros=mysql_numrows($resultado);
  $numero=$numregistros + 1;
  $cartera=$_SESSION['cartera'];
  if ($cartera=="") {
    echo "<center><h2>Debe elegir una cartera</h2></center>";
  }
  else
  {  
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

    <center><H3>ENTRADA DE DATOS PARA CLIENTES NUEVOS</H3>
      <Form name="inser_cliente" method="Post" Action="inser_cliente.php"> 
        <Table>
          <TR>
            <TD>Numero cliente:</TD>
            <TD class="formulario"> <input type="text" name="numero" size="10" value="<?php echo $numero ?>" readonly>
          
            <TD>* Nombre:</TD>
            <TD class="formulario"><input type="text" name="nombre" size="60"></TD>
          </TR>
          <TR>                 
            <TD>* Cedula:</TD>
            <TD class="formulario"><input type="text" name="cedula" size="10" maxlength=10></TD>
                      
            <TD>* Ciudad:</TD>
            <TD class="formulario"><input type="text" name="ciudad" size="10"></TD>
          </TR>
          <TR>
            <TD>Direcci&oacute;n cobro:</TD>
            <TD class="formulario"><input type="text" name="direccion" size="60"></TD>
          
            <TD>Barrio:</TD>
            <TD class="formulario"><input type="text" name="barrio" size="50"></TD>
          </TR>
          <TR>   
            <TD>Direcci&oacute;n casa:</TD>
            <TD class="formulario"><input type="text" name="dir_c" size="60"></TD>
           
            <TD>Telefono 1:</TD>
            <TD class="formulario"><input type="text" name="tel" size="10"></TD>           
          </TR>
          <TR>  
            <TD>Telefono 2:</TD>
            <TD class="formulario"><input type="text" name="cel" size="11"></TD> 
 
            <TD>Profesion:</TD>
            <TD class="formulario"><input type="text" name="pro" size="40"></TD>                
          </TR>
       </Table>  
	   <br> 
       <input type='submit' class='btn btn-info' value='Grabar'>
       <input type="reset" class="btn btn-info" value="Borrar">
      </Form>
    </center>
  </body>
</html>
<?php
}
?>