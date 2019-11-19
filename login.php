<?php 
session_start();
include("db.php");
$user_name=htmlspecialchars($_POST['user_name'],ENT_QUOTES);
$pass=md5($_POST['password']);

//validamos si existe el nombre.. y el pass
$sql="SELECT username, password FROM usuarios WHERE username='".$user_name."'";
$result=mysqli_query($link, $sql);
$row=mysqli_fetch_array($result);

//si el nombre existe..
if(mysqli_num_rows($result)>0)
{
	//comparamos el password
	if(strcmp($row['password'],$pass)==0)
	{
		echo "yes";
		//cargamos la session..
		$_SESSION['uname']=$user_name; 
	}
	else
		echo "no"; 
}
else
	echo "no"; //login invalido..
?>