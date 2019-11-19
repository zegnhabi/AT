<?php 
session_start();
include("db.php");
$numautobus=$_POST['numautobus'];
$numasientos=$_POST['numasientos'];
$modautobus=$_POST['modautobus'];
$numserie=$_POST['numserie'];
$choferautobus=$_POST['choferautobus'];
$sql = "INSERT INTO autobus (id_autobus, num_asientos, modelo,num_serie, id_chofer) VALUES (".$numautobus.",".$numasientos.",".$modautobus.",'".$numserie."', ".$choferautobus.")";
$result=mysqli_query($link, $sql);
if(mysqli_num_rows($result)>0)
	echo "yes";
else
	echo "yes"; 
?>