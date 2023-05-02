<?php
  session_start();
  include("../conexion.php");
  $conex=conectarse("cartera");
  $cartera=$_SESSION['cartera'];
  $consult= "select * from carteras where nombre_car = '$cartera';";
  $res=mysql_query($consult,$conex);
  $mat=@mysql_fetch_array($res);
  $cod_cart=$mat['cod_cartera'];
  $n_pres=$_POST['num_id'];
  $ruta=$_POST['ruta'];
  $n_pos=$_POST['nr'];
  $b=count($n_pos);
  $x=0;    
  do{ 
    $insert="update prestamos set orden_ruta='$n_pos[$x]' where num_prestamo='$n_pres[$x]';";
    $result=mysql_query($insert,$conex);
    $x=$x+1; 
  }while ($x<=$b);
    $verif="select * from prestamos where cod_cartera=$cod_cart and estado='1' order by orden_ruta;";
    $r_verif=mysql_query($verif,$conex);
    $mat=@mysql_fetch_array($r_verif);
    $z=0;
    $y=0;
    
    echo"<table border='1'>";
    echo"<tr class='primeralinea'>";
    echo"<td class='primeralinea'>N Pres</td>";
    echo"<td class='primeralinea'>RUTA BD</td>";
    echo"<td class='primeralinea'>Ruta corregida</td></tr>";
    do{ 
      $num_p[$z]=$mat['num_prestamo'];
      echo"<tr><td>".$num_p[$z]."</td>";
      echo"<td>".$n_pos[$z]."</td>";
      $n_pos[$y]=$y+1;
      echo"<td>".$n_pos[$y]."</td>";
      $insert="update prestamos set orden_ruta='$n_pos[$y]' where num_prestamo='$num_p[$z]';";
      $result2=mysql_query($insert,$conex);
      $y++;
      $z++;
    }while($mat=mysql_fetch_array($r_verif));
    echo "</table>";
    if($result2)
    {
    echo "<script>";
    echo "window.alert('¡¡¡ DATOS GRABADOS EXITOSAMENTE....¡¡¡¡');";
    echo "document.location='orden_ruta.php';";
    echo "</script>";   
    }
    else
    {
      echo "<script>";
      echo "window.alert('¡¡¡ Los DATOS no han Sido GRABADOS.... Revise ¡¡¡¡');";
      echo "</script>";
    }
  mysql_close($conex); 
?>