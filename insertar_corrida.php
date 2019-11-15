<?php 
session_start();
include("db.php");
$ciudad=$_POST['ciudad'];
$hora=$_POST['hora'];
$fecha=$_POST['fecha'];
$fecha=explode("-",$fecha);
$fecha = date("Y-m-d",mktime(0,0,0,$fecha[1],$fecha[0],$fecha[2]));
$sql = "insert into corridas (ciudad,hora_salida,fecha) values('$ciudad','$hora','$fecha')";
$result=mysqli_query($sql);
if(mysqli_num_rows($result)>0)
	echo "yes";
else
	echo "yes"; 
	
?>