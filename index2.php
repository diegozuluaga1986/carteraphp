<?php
  session_start();
  include("conexion.php");
  $conex=conectarse("cartera");
  $_SESSION['cartera']=$_POST['cart'];
  $bus_cart="select * from carteras where activa='1' order by orden;";
  $r_bus=mysql_query($bus_cart,$conex);
  $m_cart=mysql_fetch_array($r_bus);
  $mat=@mysql_fetch_array($m_cart); 
?> 
<!DOCTYPE html>
<html lang="es">
<head> 
  <meta charset="iso-8859-1" /> 
  <meta content="Miller Posada" name="author" />
  <meta content="registro de prestamos" name="description" />
  <meta content="etiqueta1, etiqueta2, etiqueta3" name="prestamos" />
  <title>Prestamas</title>
  <link rel="stylesheet" type="text/css" href="estilos.css">
  <link href="bootstrap2/css/bootstrap.css" rel="stylesheet">   
  <link href="bootstrap2/css/bootstrap-responsive.css" rel="stylesheet">
  <script type="text/javascript" src="bootstrap2/js/bootstrap.js"></script>
</head>
<?php  
  if(isset($_SESSION['admin'])){
    $cartera=$_SESSION['cartera'];
?>    
<body>
  <div id="wrapper">
    <div class="header">
    <a href='logout.php' class="btn btn-inverse">Cerrar Sesion</a>
      <img src="imagenes/logo2.png" width="255px" height="101px"> 
      <div class="buscar">
        <center>
          <form name="bus_car" action="#" method="POST">    
            <table>
              <tr>
                <td>Cartera: </td>
                <td class='formulario'><select name='cart'>
                  <option>
                     <?php
                      do{
                        echo"<option>".$m_cart['nombre_car']."</option>";          
                      }while($m_cart=mysql_fetch_array($r_bus));  
                    ?>
                </td>
                <td><center><input type="submit" class="btn btn-info" value="buscar"></center></td>
              </tr>  
            </table>
          </form>  
        </center>
      </div> 
    </div> 
    <div id="subheader">
      <ul class="nav">
        <li><a href="#">Carteras</a>
          <ul>
            <li><a href="carteras/crear_cartera/formulario_cartera.php" target="principal">Crear nueva cartera</a></li>
            <li><a href="carteras/cambiar_nombre_cartera/detalle.php" target="principal">Cambiar nombre cartera</a></li>
            <li><a href="carteras/activar_desactivar/estado_cartera.php" target="_blank">Activar/Desactivar</a></li>
            <li><a href="carteras/asignar_cobrador.php" target="principal">Asignar cobrador</a></li>
            <li><a href="carteras/copia_bd/copiabd.php" target="principal">copia de seguridad</a></li>
          </ul>
        </li>
        <li><a href="#">Cobradores</a>
          <ul>
            <li><a href="Cobradores/formulario_cobrador.php" target="principal">Crear nuevo cobrador</a></li>
            <li><a href="Cobradores/lista_cobradores.php" target="_blank">Listado de cobradores</a></li>
            <li><a href="Cobradores/formulario_vf.php" target="principal">Agregar vale</a></li>

          </ul>
        </li>
        <li><a href="#">Clientes</a>
          <ul>
            <li><a href="clientes/formulario_insert.php" target="principal">Agregar cliente</a></li>
            <li><a href="clientes/buscar_prestamo.php" target="_blank">Buscar prestamo</a></li>
            <li><a href="clientes/listar_cliente.php" target="_blank">Listado de clientes</a></li>
          </ul>
        </li>
        <li><a href="#">Prestamos</a>
          <ul>
            <li><a href="prestamos/formulario_prestamo.php" target="principal">Prestamo paga diario</a></li>
            <li><a href="prestamos/formulario_solo_interes.php" target="principal">Prestamo no amortizable</a></li>
            <li><a href="prestamos/orden_ruta.php" target="_blank">Enrutar</a></li>
            <li><a href="prestamos/listar_prestamo.php" target="_blank">Listado de prestamos</a></li>
            <li><a href="prestamos/resumen_dia.php" target="_blank">Resumen prestamos</a></li>
            <li><a href="prestamos/revisar_prestamos.php" target="_blank">Revisar nuevos</a></li>
            <li><a href="prestamos/prestamos_terminados.php" target="_blank">Prestamos terminados</a></li>
            <li><a href="prestamos/listado_anulados.php" target="_blank">Prestamos anulados</a></li>

          </ul>
        <li><a href="#">Abonos</a>
          <ul>
            <li><a href="abonos/registrar_abonos/formulario_fecha_abono.php" target="principal">Registrar abonos</a></li>
            <li><a href="abonos/formulario_v.php" target="principal">Registrar abonos a volados</a></li>
            <li><a href="abonos/form_edi_abo.php" target="_blank">coteo por fecha</a></li>
            <li><a href="abonos/listado_volaos.php" target="_blank">Listado diario</a></li>
            <li><a href="abonos/capital_interes.php" target="_blank">Intereses cobrados</a></li>
          </ul>
        </li>
        <li><a href="#">Caja</a>
          <ul>
            <li><a href="caja/fecha_acumulacion.php" target="principal">Acumular</a></li>
                
             
          </ul>
        </li>
      </ul>
    </div>
    <div class="contenido">  
      <div class="hora">
        <?php  
          date_default_timezone_set ("America/Bogota");
          setlocale (LC_TIME,"spanish"); 
          $fecha = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
          echo strftime("%A, %d de %B de %Y", $fecha);
          echo ", Hora ";
          echo date("H:i");
          echo"<h3>Cartera actual: ".$cartera."</h3>";  
        ?>
      </div>  
      <iframe src="" name="principal" title="principal" class="iframe">
        
      </iframe>
      <div id="push"></div> 
    </div>
  </div>
  <div class="pie">
    <p>creado por: <a href="#">Miller Adrian Posada Rendon </a></p>
     <br> 
    <p>reservados todos los derechos </p> 
  </div>
  <!-- fin pie -->
  </body>
</html>
<?php        
  }else {
?>
<body>
  <div id="wrapper">
    <div class="header">
      <img src="imagenes/logo2.png" width="255px" height="101px">    
    </div>
    <div class="contenido">
        <div class="inicio">
          <form action="login.php" name="inicio" method="post">
            <H4>INGRESAR</H4>
            <label>Usuario: </label>
            <input type="text" name="user"><br>
            <label>Pasword: </label>
            <input type="password" name="pass"><br>
            <input type="image" name="Iniciar sesion" src="imagenes/sign_in.png">
          </form>
        </div><!-- fin div inicio --> 
              
<?php
  if ($_SESSION['vacio']) {
          echo "<br>";
          echo "<p>".$_SESSION['vacio']."</p>";
          unset($_SESSION['vacio']);
        }elseif ($_SESSION['error']) {
          echo "<br>";
          echo $_SESSION['error'];
          unset($_SESSION['error']);
        }  
?>
    </div>
    <div id="push"></div> 
  </div>
  <div class="pie">
    <p>Prestamas v2.0</p><br>
    <p>creado por: <a href="#">Miller Adrian Posada Rendon </a></p>
    <br>
    <p>Cartago Valle del Cauca</p><br>
    <p>reservados todos los derechos </p> 
  </div><!-- fin pie -->
</body>
</html>
<?php
}
?>
