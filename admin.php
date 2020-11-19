<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="images/favicon.ico"/> 
<link rel="stylesheet" type="text/css" href="styles/admin.css" />
<meta http-equiv="Content-Type" content="text/html; iso-8859-7">
<meta name="title" content="Sistema Web Boletaje Autobuses ">
<meta name="ROBOTS" content="INDEX,FOLLOW">
<meta http-equiv="Content-Language" content="es">
<meta name="description" content="sistema para la venta de boletos de una terminal de autobuses">
<meta name="abstract" content="sistema para la venta de boletos de una terminal de autobuses">
<meta name="keywords" content="ticket,bus,sqleros,php,mysql,javascript,autobuses, sistema web, GiS,corridas,boletos, boletaje">
<meta name="author" content="Jos� Ram�n Ib��ez">
<meta name="copyright" content="">
<meta name="rating" content="General">
<meta http-equiv="Reply-to" content="zegnhabi@gmail.com">
<meta name="creation_Date" content="07/09/1942">
<meta name="revisit-after" content="2 days">
<meta name="doc-rights" content="Public">
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32712866-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<script src="js/jquery.js" type="text/javascript" language="javascript"></script>
	<title>Administracion de Autobuses at-sqleros.herokuapp.com</title>
<script language="javascript">
$(document).ready(function()
{
	$("#login_form").submit(function()
	{
		//remueve las classes del fading del form
		$("#msgbox").removeClass().addClass('messagebox').text('Validando....').fadeIn(1000);
		//Checa si existe o no el usuario, via ajax
		$.post("login.php",{ user_name:$('#username').val(),password:$('#password').val(),rand:Math.random() } ,function(data)
        {
		  if(data=='yes') //si el login es correcto..
		  {
		  	$("#msgbox").fadeTo(200,0.1,function()  //inicia la caja de mensajes
			{ 
			  //a�ade la clase para poner el mensaje..
			  $(this).html('Iniciando Sesion.....').addClass('messageboxok').fadeTo(900,1,
              function()
			  { 
			  	 //redirige a una pagina segura...
				 document.location='secure.php';
			  });
			  
			});
		  }
		  else 
		  {
		  	$("#msgbox").fadeTo(200,0.1,function()
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Verifica los detalles del inicio de sesion...').addClass('messageboxerror').fadeTo(900,1);
			});		
          }
				
        });
 		return false; //no envio el form fisicamente
	});
	//llamamos la funcion ajax cuando password pierde el enfoque.. para el submit
	$("#password").blur(function()
	{
		$("#login_form").trigger('submit');
	});
});
</script>

</head>
<body>
<div id="Cabecera" align="center">
	<img src="images/logo.jpg" alt="Autobuses at-sqleros.herokuapp.com"/>
</div>
<div id="loginForm">
	<form method="post" action="" id="login_form">
		<div align="center">
			<div>
				Usuario: <input name="username" type="text" id="username" value="" maxlength="20" />
			</div>
			<div style="margin-top:5px" >
				Clave:
				&nbsp;&nbsp;
				<input name="password" type="password" id="password" value="" maxlength="20" />
			</div>
			<div class="buttondiv">
				<input name="Submit" type="submit" id="submit" value="Login" style="margin-left:-10px; height:23px"  /> 
				<span id="msgbox" style="display:none"></span>
			</div>
		</div>
</form>
</div>
<div>
<i class="copy">&reg; 2009 -  <?php echo date('Y'); ?> <a href="https://at-sqleros.herokuapp.com/">at-sqleros.herokuapp.com</a> <a href="mailto:zegnhabi@gmail.com?subject=Comentarios y sugerencias sistema de boletaje"> Contacto </a></i>
</div>
</body>
</html>