<?php 
session_start();
include("db.php");
//validamos si existe el nombre.. y el pass
$id_choferSql="select count(*) as id from chofer";
$result=mysqli_query($id_choferSql);
$row=mysqli_fetch_array($result);
$id_chofer=$row['id'];
$nombre=$_POST['nomchofer'];
$sexo=$_POST['sexchofer'];
$edad=$_POST['edadchofer'];
$num=$_POST['numchofer'];
$sqlCad="insert into chofer values ($id_chofer,'$nombre','$sexo',$edad,'$num')";
$result=mysqli_query($id_choferSql);
if(mysqli_num_rows($result)>0)
	echo "yes";
else
	echo "no"; 
?>