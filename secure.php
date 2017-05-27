<?php 
session_start();
// if no existe la sesion se redirecciona a una pagina x.
if(empty($_SESSION['uname']))
	header("Location:admin.php");	
else
	header("Location:administracion.php");	
//si sale se destruye la sesion current..
if(isset($_GET['salir']))
{
	session_destroy();
	header("Location:admin.php");
}	
?>