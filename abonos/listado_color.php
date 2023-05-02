<?php  
  session_start();
  include("../conexion.php");
  include("../fpdf/fpdf.php");
  $conex=conectarse("cartera");
  $cartera=$_SESSION['cartera'];
  date_default_timezone_set ("America/Bogota");
  setlocale (LC_TIME,"spanish");
  $hoy = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
  $val_dia=strftime("%w", $hoy);
  if ($val_dia=="6") {
    $dia = mktime(0, 0, 0, date("m"), date("d")+2, date("Y"));
  }
  else{
    $dia = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));
  }
  $dia= strftime("%A, %d de %B de %Y", $dia);
  $pag=1;

  if($cartera!=""){
    $consult= "select * from carteras where nombre_car = '$cartera';";
    $result=mysql_query($consult,$conex);
    $mat=@mysql_fetch_array($result);
    $fpdf= new FPDF('L','mm','legal');
    $fpdf->SetAutoPageBreak(true,10);  
    $fpdf->AddPage();
    $fpdf->SetFont('Helvetica', 'B', 12);
    $fpdf->SetTextColor(1,1,1);
    $fpdf->Cell(40, 10, $mat['nombre_car'], 0);
    $fpdf->Cell(75, 10, $dia, 0);
    $fpdf->Cell(13, 10, 'Pag. ', 0);
    $fpdf->Cell(10, 10, $pag, 0);
    $fpdf->Ln();
    
    $cod_cart=$mat['cod_cartera'];
    $consulta="select prestamos.num_prestamo, prestamos.num_cliente,";
    $consulta.=" prestamos.fecha_inicio,"; 
    $consulta.=" DATE_ADD(prestamos.fecha_inicio, INTERVAL prestamos.num_cuotas DAY) 'fecha_fin',";    
    $consulta.=" prestamos.monto,";
    $consulta.=" prestamos.monto_final,";
    $consulta.=" prestamos.cuota,";
    $consulta.=" prestamos.num_cuotas, prestamos.orden_ruta, prestamos.cod_cartera, prestamos.dia_abona,"; 
    $consulta.=" clientes.nombre, clientes.profesion, clientes.direccion, clientes.barrio,"; 
    $consulta.=" clientes.ciudad, clientes.celular, clientes.tel_fijo from";
    $consulta.=" prestamos, clientes where prestamos.num_cliente=clientes.num_cliente";
    $consulta.=" and prestamos.cod_cartera=$cod_cart and prestamos.estado='1'";
    $consulta.=" order by orden_ruta;";
    $resultado=mysql_query($consulta,$conex);
    $matriz=@mysql_fetch_array($resultado); 

    $fpdf->SetFont('Arial', 'B', 8);
    $fpdf->SetTextColor(1,1,1);
    $fpdf->Cell(14, 8, 'Notas', 1);
    $fpdf->Cell(6, 8, '#', 1);
    $fpdf->Cell(37, 8, 'Cliente', 1);
    $fpdf->Cell(31, 8, 'Ocupacion', 1, 0, 'C');
    $fpdf->Cell(13, 8, '$', 1, 0, 'C');
    $fpdf->Cell(10, 8, 'Dia', 1);
    $fpdf->Cell(7, 8, '#_C', 1);
    $fpdf->Cell(12, 8, 'Abono', 1);
    $fpdf->Cell(7, 8, 'Pico', 1);
    $fpdf->Cell(10, 8, 'Monto', 1);
    $fpdf->Cell(9, 8, 'Abo', 1);
    $fpdf->Cell(10, 8, 'Saldo', 1);
    //$fpdf->Cell(9, 8, 'C_P', 1);
    $fpdf->Cell(9, 8, 'Mora', 1);
    $fpdf->Cell(13, 8, 'Ultimo', 1, 0, 'C');
    $fpdf->Cell(13, 8, 'Inicia', 1);
    //$fpdf->Cell(13, 8, 'Termina', 1);
    $fpdf->Cell(30, 8, 'Direccion', 1);
    $fpdf->Cell(25, 8, 'Barrio', 1);
    $fpdf->Cell(15, 8, 'Ciudad', 1);
    $fpdf->Cell(19, 8, 'Telefono 1', 1);
    $fpdf->Cell(19, 8, 'Telefono 2', 1);
    $fpdf->Ln();

    $sumatoria=0;
    $total_abo=0;
    $total_p=0;
    $x=0;
    $rx=1;
    do
    {
        $x=$x+1;
        $suma=0; 
        $atr=0; 
        $cuotas=0;
        $ultimo=" ";
        $notas=" ";
        $p=$matriz['num_prestamo'];
        $insert="update prestamos set orden_ruta='$rx' where num_prestamo='$p';";
        $res_insert=mysql_query($insert,$conex);

        $detalle="select * from detalle_movimientos where num_prestamo=$p order by fecha_m;";
        $valid_d=mysql_query($detalle,$conex); 
        if($valid_d) {
            $m_det=@mysql_fetch_array($valid_d);
            $cant=@mysql_num_rows($valid_d);                  
            do {
                $suma=$suma+$m_det['monto_abono']; 
                if ($matriz['fecha_inicio']==$m_det['fecha_m']) {
                    $cant=$cant - 1;
                }
                if ($m_det['monto_abono']!=0) {
                    $ultimo=$m_det['fecha_m'];   
                }

            }while($m_det=@mysql_fetch_array($valid_d));
            $suma_abo="select SUM(monto_abono) from detalle_movimientos where num_prestamo=$p;";
            $resul_sum=mysql_query($suma_abo,$conex);
            $abonado=mysql_result($resul_sum,0);
            if ($abonado==0) {
                    $ultimo=$matriz['fecha_inicio'];       
                }
            $cuotas=$suma/$matriz['cuota'];
            $modulo=$suma%$matriz['cuota'];
            $mod=$modulo/$matriz['cuota'];
            $cuotas=$cuotas-$mod;
            $atr=$cant - $cuotas;
            if ($atr<=0) {
                $atr=" ";
            }
            
        }
     
        $pendientes=$matriz['num_cuotas']-$cuotas;
        $monto_p=$matriz['monto_final']-$suma;
        $t_cartera=$t_cartera+$monto_p;
        $total_abo=$total_abo+$suma;
        $total_p=$total_p+$monto_p;

        $consul_fe="select DATE_ADD(NOW(), INTERVAL $pendientes DAY)"; 
        $r_consul_fe=mysql_query($consul_fe,$conex); 
        $fin_real=@mysql_result($r_consul_fe,0);
        
        

        if ($x==44) {
            $pag=$pag + 1;
            $fpdf->SetFont('Helvetica', 'B', 12);
            $fpdf->SetTextColor(1,1,1);
            $fpdf->Cell(40, 10, $mat['nombre_car'], 0);
            $fpdf->Cell(75, 10, $dia, 0);
            $fpdf->Cell(13, 10, 'Pag. ', 0);
            $fpdf->Cell(10, 10, $pag, 0);
            $fpdf->Ln();
            $fpdf->SetFont('Arial', 'B', 8);
            $fpdf->Cell(14, 8, 'Notas', 1);
            $fpdf->Cell(6, 8, '#', 1);
            $fpdf->Cell(37, 8, 'Cliente', 1);
            $fpdf->Cell(31, 8, 'Ocupacion', 1, 0, 'C');
            $fpdf->Cell(13, 8, '$', 1, 0, 'C');
            $fpdf->Cell(10, 8, 'Dia', 1);
            $fpdf->Cell(7, 8, '#_C', 1);
            $fpdf->Cell(12, 8, 'Abono', 1);
            $fpdf->Cell(7, 8, 'Pico', 1);
            $fpdf->Cell(10, 8, 'Monto', 1);
            $fpdf->Cell(9, 8, 'Abo', 1);
            $fpdf->Cell(10, 8, 'Saldo', 1);
            //$fpdf->Cell(9, 8, 'C_P', 1);
            $fpdf->Cell(9, 8, 'Mora', 1);
            
            $fpdf->Cell(13, 8, 'Ultimo', 1, 0, 'C');
            $fpdf->Cell(13, 8, 'Inicia', 1);
            //$fpdf->Cell(13, 8, 'Termina', 1);
            $fpdf->Cell(30, 8, 'Direccion', 1);
            $fpdf->Cell(25, 8, 'Barrio', 1);
            $fpdf->Cell(15, 8, 'Ciudad', 1);
            $fpdf->Cell(19, 8, 'Telefono 1', 1);
            $fpdf->Cell(19, 8, 'Telefono 2', 1);
            $fpdf->Ln();
            $x=1;
        }
        $f=$matriz['fecha_inicio'];
        $fecha_fin=$matriz['fecha_fin'];
        $consul_mora="select DATEDIFF('$fin_real','$fecha_fin')";
        $r_conmora=mysql_query($consul_mora,$conex);
        $mora=@mysql_result($r_conmora,0);
        
        $actual=date("Y-m-d");
        $tiempo="select DATEDIFF('$actual','$f')";
        $res_tiempo=mysql_query($tiempo,$conex);
        $tie=@mysql_result($res_tiempo,0);

        $inhabil=$tie - $cant;
        if ($inhabil<0) {
            $inhabil=0;
        }

        $mora=$mora - $inhabil;

        if ($mora<=0) {
                $mora=" ";
            }
         
        if ($matriz['fecha_inicio']==date("Y-m-d") or $cant==0) {
            $fpdf->SetFont('Arial', 'B', 8);
            $fpdf->SetTextColor(1,1,1);
            $notas="Nuevo";
        }
        elseif ($abonado>=$matriz['monto_final']) {  
            $fpdf->SetFont('Arial', 'B', 8);
            $notas="Termino";
        }
        else{
            $fpdf->SetFont('Arial', '', 8); 
            $fpdf->SetTextColor(1,1,1);  
        }
        
        if ($mora>17) {
            $fpdf->SetFont('Arial', 'B', 8);
            $fpdf->SetTextColor(242,10,10);
        }
        
        if ($matriz['dia_abona']=="Diario") {
            $dia_abona=" ";
        }
        else{
            $dia_abona=$matriz['dia_abona'];
        }
        
        $fpdf->Cell(14, 4, $notas, 1);//NOTAS
        $fpdf->Cell(6, 4, $rx, 1);//RUTA
        $fpdf->Cell(37, 4, $matriz['nombre'], 1);//NOMBRE
        $fpdf->Cell(31, 4, $matriz['profesion'], 1, 0, 'R');//OCUPACION
        //$number=number_format($matriz['cuota'], 0, ",",".");
        $cu=$matriz['cuota']/1000;
        if ($cu<1) {
            $cu=0;
        }
        $w=$cu." x ".$matriz['num_cuotas'];
        $fpdf->Cell(13, 4, $w, 1, 0, 'C');//CUOTA
        $fpdf->Cell(10, 4, $dia_abona, 1);//Dia abono
        $fpdf->Cell(7, 4, $cuotas, 1, 0, 'R');//CUOTAS ABONADAS
        $fpdf->Cell(12, 4, '  ', 1);//ABONO
        $modulo=$modulo/1000;
        if ($modulo<1) {
            $modulo=" ";
        }
        $fpdf->Cell(7, 4, $modulo, 1);//PICO
        //$number=number_format($matriz['monto'], 0, ",",".");
        $number=$matriz['monto']/1000;
        $fpdf->Cell(10, 4, $number, 1);//PRESTAMO
        //$number=number_format($suma, 0, ",",".");
        $number=$suma/1000;
        $fpdf->Cell(9, 4, $number, 1);//MONTO ABONADO
        //$number=number_format($monto_p, 0, ",",".");
        $number=$monto_p/1000;
        $fpdf->Cell(10, 4, $number, 1);//SALDO PENDIENTE
        //$fpdf->Cell(9, 4, $pendientes, 1);//CUOTAS PENDIENTES


        $fpdf->Cell(9, 4, $mora, 1);//DIAS DE MORA

        //$f=date("d/m/Y",strtotime($f));
        $FechaArreglo = explode("-", date("m-d-Y", strtotime($f)));
        $Fecha = mktime(0, 0, 0, $FechaArreglo[0], $FechaArreglo[1], $FechaArreglo[2]);
        $f=strftime("%b-%d", $Fecha);
        $FechaArreglo = explode("-", date("m-d-Y", strtotime($ultimo)));
        $Fecha = mktime(0, 0, 0, $FechaArreglo[0], $FechaArreglo[1], $FechaArreglo[2]);
        $ultimo= strftime("%b-%d", $Fecha);
        $fpdf->Cell(13, 4, $ultimo, 1, 0, 'C');//ULTIMO ABONO
        $fpdf->Cell(13, 4, $f, 1);//FECHA PRESTAMO
        $ncuotas=$matriz['num_cuotas'];
        $FechaArreglo = explode("-", date("m-d-Y", strtotime($fecha_fin)));
        $Fecha = mktime(0, 0, 0, $FechaArreglo[0], $FechaArreglo[1], $FechaArreglo[2]);
        $fecha_fin=strftime("%b-%d", $Fecha);
        //fpdf->Cell(13, 4, $fecha_fin, 1);FECHA A CANCELAR
        $fpdf->Cell(30, 4, $matriz['direccion'], 1);//DIRECCION
        $fpdf->Cell(25, 4, $matriz['barrio'], 1);//BARRIO
        $fpdf->Cell(15, 4, $matriz['ciudad'], 1);//CIUDAD
        $fpdf->Cell(19, 4, $matriz['tel_fijo'], 1);//TELEFONO 1
        $fpdf->Cell(19, 4, $matriz['celular'], 1);//TELEFONO 2
        $fpdf->Ln();
        $promedio=$promedio + $matriz['cuota'];
        $rx=$rx+1;
    }while($matriz=@mysql_fetch_array($resultado));
    $fpdf->SetFont('Arial', '', 8);
    $fpdf->Cell(14, 3, '', 1);//NOtas
    $fpdf->Cell(6, 3, '', 1);//#
    $fpdf->Cell(37, 3, '', 1);//CLIENTE
    $fpdf->Cell(31, 3, '', 1);//OCUPACION
    $fpdf->Cell(13, 3, '', 1);//V CUOTA
    $fpdf->Cell(10, 3, '', 1);//DIA ABONO
    $fpdf->Cell(7, 3, '', 1);//# C
    $fpdf->Cell(12, 3, '', 1);//ABONO
    $fpdf->Cell(7, 3, '', 1);//PICO
    $fpdf->Cell(10, 3, '', 1);//MONTO
    $fpdf->Cell(9, 3, '', 1);//ABONADO
    $fpdf->Cell(10, 3, '', 1);//SALDO
    //$fpdf->Cell(9, 3, '', 1);//CP
    $fpdf->Cell(9, 3, '', 1);//MORA
    
    $fpdf->Cell(13, 3, '', 1, 0, 'C');//ULTIMO
    $fpdf->Cell(13, 3, '', 1);//INICIA
    //$fpdf->Cell(13, 3, '', 1);//TERMINA
    $fpdf->Cell(30, 3, '', 1);//DIRECCION
    $fpdf->Cell(25, 3, '', 1);//BARRIO
    $fpdf->Cell(15, 3, '', 1);//CIUDAD
    $fpdf->Cell(19, 3, '', 1);//TELEFONO 1
    $fpdf->Cell(19, 3, '', 1);//TELEFONO 2
    $fpdf->Ln();
    $fpdf->SetFont('Arial', 'B', 8);
    $fpdf->Cell(14, 4, ' ', 1);//NOTAS
    $fpdf->Cell(6, 4, '', 1);//RUTA
    $fpdf->Cell(37, 4, '', 1);//NOMBRE
    $fpdf->Cell(31, 4, 'PROMEDIO', 1, 0, 'C');//OCUPACION
    $promedio=number_format($promedio, 0, ",",".");
    $fpdf->Cell(23, 4, $promedio, 1, 0, 'C');//PROMEDIO DE CUOTAS
    $fpdf->Cell(7, 4, '', 1);//# C
    $fpdf->Cell(38, 4, 'CARTERA X COBRAR', 1, 0, 'C');//TOTAL CARTERA
    $t_cartera=number_format($t_cartera, 0, ",",".");
    $fpdf->Cell(19, 4, $t_cartera, 1, 0, 'C');//TOTAL CARTERA
    $fpdf->Output();
  }
  else{
    echo "<h2>Debe elegir una cartera</h2>";
  }

 mysql_close($conex);

?>