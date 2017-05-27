<?php 
session_start();
include("db.php");
$ciudad=$_POST['terminal'];
//validamos si existe el nombre.. y el pass
$sqlCad="insert into terminal values (null,'".$ciudad."')";
$result=mysql_query($sqlCad);
if(mysql_num_rows($result)>0)
	echo "yes";
else
	echo "yes"; 
?>