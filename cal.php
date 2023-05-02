<!-- Copyright (C) 2004 hioxindia.com. HIOX Softwares, India -->
<?php

//$bgcolor="#898989";
//$tablecolor = "#675645";
//$fontcolor = "#EE49DD";
//$tableborder = "458866";

//Edit the below three lines to change the colors (Look and Feel of the calander). 
//The default values are shown in the above lines
$bgcolor="#4B9E03";
$tablecolor = "#666645";
$fontcolor = "#E3F70A";
$tableborder = "#446655";

//Don't edit any lines shown below
$today = getdate();

$mon = $today['mon']; //month
$year = $today['year']; //this year
$day = $today['mday']; //this day

$monnn = $today['month']; //month as string
//echo $monnn;

$day1 = $day-1;

$my_time= mktime(0,0,0,$mon,1,$year);
$start_mon = date('d', $my_time); //Month starting date
$start_day = date('D', $my_time); //Month starting Day
//echo $start_mon;
//echo $start_day;
$start_daynum = date('w', $my_time);

$daysIM = DayInMonth($mon,$year); //Number of days in this month

function DayInMonth($month, $year)
{
   $daysInMonth = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
   if ($month != 2)
   {
    	return $daysInMonth[$month - 1];
    }
    else
    {
   	return (checkdate($month, 29, $year)) ? 29 : 28;
    }
}
?>

<table width=250 height=150 border=0 bgcolor=<?php echo $bgcolor; ?> cellspacing=1 border=0 style="border:2px solid #000000; " color=<?php echo $tableborder; ?>>
<tr width=250 height=30>
<td width=245 align=center style="border-bottom:0px solid #ffffff">
<?php
 echo "<font color=#c9c9c9><b>";
 echo $monnn;
 echo " , ";
 echo $year;
 echo "</b></font>";
  ?>
</td><td width=5 style="border-bottom: 0px solid #ffffff">
<a href='http://hscripts.com' style="text-decoration:none; font-size:10px; color:#f5f5f5;">H</a>
</td>
</tr>

<tr width=250 height=100>
<td width=250 height=100 colspan=2>
<table width=250 height=100 border=0 bgcolor=<?php echo $bgcolor; ?> cellpadding=0 cellspacing=1 border=0 color=<?php echo $tableborder; ?>>
<tr bgcolor=#505050 align=center>
<td><font size=-1><b>Sun</b></font></td><td><font size=-1><b>Mon</b></font></td><td><font size=-1><b>Tue</b></font></td>
<td><font size=-1><b>Wed</b></font></td><td><font size=-1><b>Thu</b></font></td><td><font size=-1><b>Fri</b></font></td><td><font size=-1><b>Sat</b></font></td>
</tr>
<?php
$dd = 0;
$daye = 1;
echo "<tr bgcolor=$tablecolor>";
while($dd < $start_daynum)
{
echo  "<td></td>";
$dd = $dd+1;
}

while($dd < 7)
{
	if($daye == $day)
	{
		echo  "<td bgcolor=#001100 align=center><font size=-1 color=$fontcolor><b>".$daye++."</b></font></td>";
		$dd++;
	}
	else
	{
		echo  "<td align=center><font size=-1 color=$fontcolor><b>".$daye++."</b></font></td>";
		$dd++;
	}
}
echo "</tr>";

while($daye < $daysIM)
{
echo "<tr bgcolor=$tablecolor>";
$dd = 0;
while($dd<7)
{
if($daye <= $daysIM)
{
	if($daye == $day)
	{
		echo  "<td bgcolor=#001100 align=center><font size=-1 color=$fontcolor><b>".$daye++."</b></font></td>";
		$dd++;
	}
	else
	{
		echo  "<td align=center><font size=-1 color=$fontcolor><b>".$daye++."</b></font></td>";
		$dd++;
	};
}
else
{
echo  "<td></td>";
$dd++;
}

}
echo "</tr>";
}
?>
</table>
</td>
</tr>

</table>
