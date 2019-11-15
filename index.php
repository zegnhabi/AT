<?php
	session_start();
	if($_GET['lang']){
		$lang=$_GET['lang'];
		switch($lang)
		{
			case "es":
			include("lenguaje/lang-es.php");
			$_SESSION['lang']=$lang;
			break;
			
			case "en":
			include("lenguaje/lang-en.php");
			$_SESSION['lang']=$lang;
			break;
			
			case "de":
			include("lenguaje/lang-de.php");
			$_SESSION['lang']=$lang;
			break;
			
			case "fr":
			include("lenguaje/lang-fr.php");
			$_SESSION['lang']=$lang;
			break;
			
			default:
			include("lenguaje/lang-es.php");
			$_SESSION['lang']=$lang;
			break;
		}
	}else
	{
		include("lenguaje/lang-es.php");
		$_SESSION['lang']=$lang;
	}
	include("db.php");
?>
<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<script language="javascript" type="text/javascript" src="js/util.js"></script>
<script language="javascript" type="text/javascript" src="js/calendario.js"></script>
<link rel="shortcut icon" href="images/favicon.ico"/> 
<!--<link rel="stylesheet" type="text/css" href="styles/estilo.css" />-->
<meta http-equiv="Content-Type" content="text/html; iso-8859-7">
<meta name="title" content="Sistema Web Boletaje Autobuses ">
<meta name="ROBOTS" content="INDEX,FOLLOW">
<meta http-equiv="Content-Language" content="es">
<meta name="description" content="sistema para la venta de boletos de una terminal de autobuses">
<meta name="abstract" content="sistema para la venta de boletos de una terminal de autobuses">
<meta name="keywords" content="ticket,bus,sqleros,php,mysql,javascript,autobuses, sistema web, GiS,corridas,boletos, boletaje">
<meta name="author" content="Jose Ibanez">
<meta name="copyright" content="">
<meta name="rating" content="General">
<meta http-equiv="Reply-to" content="zegnhabi@gmail.com">
<meta name="creation_Date" content="07/09/1942">
<meta name="revisit-after" content="2 days">
<meta name="doc-rights" content="Public">
<!--<script type="text/javascript">
   var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32712866-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>-->
<!--<script>
var adfly_id = 1721590;
var adfly_advert = 'banner';
var frequency_cap = 5;
var frequency_delay = 5;
var init_delay = 3;
</script>
<script src="http://adf.ly/js/entry.js"></script> -->
<title><?php echo $title; ?></title>
</head>
<body onload="Util.fechaHoy();">
<!--<div id="adsenseFooter" align="center">-->
<!--<script type="text/javascript">
google_ad_client = "ca-pub-5193806461374156";
/* autobuses header */
google_ad_slot = "3892902209";
google_ad_width = 728;
google_ad_height = 15;
</script>-->
<!--<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>-->
<div id="Cabecera" align="center">
	<img src="images/logo.jpg" alt="Autobuses X"/>
</div>
<div id="Cuerpo"  align="center">
	<form id="busqueda" method="post" action="">
	<table id="opciones">
		<tr>
			<td>
			<span class="label label-warning"><i class="icon-globe icon-white"></i> <?php echo $selectLenguaje;?>
				<a href="?lang=es"><img src="images/es.png" alt="Espa&ntilde;ol" height="15" width="20"></a>
				<a href="?lang=de"><img src="images/de.jpg" alt="Deutsch" height="15" width="20"></a>
				<a href="?lang=en"><img src="images/en.jpg" alt="English" height="15" width="20"></a>
				<a href="?lang=fr"><img src="images/fr.png" alt="Fran�ais" height="15" width="20"></a></span>
			<!--<span class="label label-warning"><i class="icon-road icon-white"></i> <?php echo $selectOrigen;?></span>-->
			</td>
		</tr>
		<tr>
			<td>
				<span class="label label-warning"><i class="icon-road icon-white"></i> <?php echo $selectOrigen;?></span>
			</td>
		</tr>
		<tr>
			<td>
				<?php
					//Creamos la consulta SQL
					$tabla = mysqli_query($link, "SELECT `ciudad` FROM  `vistacorridas` GROUP BY  `ciudad`"); 
				?>
				<select id="origen">
				<option value="-1" selected="selected">--<?php echo $selectOrigen;?>--</option>
				<?php
				//recorremos la tabla en busca de los registros
					while ($registro = mysqli_fetch_array($tabla)) { 
				?>
				<option value="<?php echo $registro[0]; //a�adimos el registro ?>"><?php echo $registro[0]; //a�adimos el registro?></option>
				<?php
					} 
					//liberamos la tabla del bloqueo..
					mysqli_free_result($tabla);
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<span class="label label-warning"><i class="icon-road icon-white"></i> <?php echo $selectDestino;?></span>
			</td>
		</tr>
		<tr>
			<td>
				<?php
					//Creamos la consulta SQL
					$tabla = mysqli_query($link, "SELECT `ciudad` as `id` FROM  `vistacorridas` GROUP BY  `ciudad`"); 
				?>
				<select id="destino">
				<option value="-1" selected="selected">--<?php echo $selectDestino;?>--</option>
				<?php
				//recorremos los registros
					while ($registro = mysqli_fetch_array($tabla)) { 
				?>
				<option value="<?php echo $registro[0]; //a�adimos el valor?>"><?php echo $registro[0]; //a�adimos el valor?></option>
				<?php
					} 
					//liberamos la tabla...
					mysqli_free_result($tabla);
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<input id="fecha" type="text" maxlength="10" readonly="readonly"> 
				<a href="javascript:NewCal('fecha','ddmmyyyy')"><!--<img 
				src="images/calendario.gif" width="16" height="16" 
				border="0" alt="Selecciona una fecha">--><i class="icon-calendar"></i></a>
			</td>
		</tr>
		<tr>
			<td>
				<hr class="separador"/>
				<input type="hidden" id="fechahoy" value=""/>
			</td>
		</tr>
		<tr align="right">
			<td>
				<a onclick="Util.Buscar();" class="btn btn-warning" alt="�Buscar!"><i class=" icon-search icon-white"></i> Buscar</a>
			</td>
		</tr>
		<tr>
		</tr>
		<tr>
			<td>
				<i class="copy">&reg;2017 <a href="#">Autobuses</a> <a href="mailto:zegnhabi@gmail.com?subject=Comentarios y sugerencias sistema de boletaje"><?php echo $contacto;?></a>
<!--<a href="http://adf.ly/8UE6W">Descarga</a></i>-->
			</td>
		</tr>
		</table>
	</form>
</div>
<!--<div id="adsenseHeader" align="center">
<script type="text/javascript">
google_ad_client = "ca-pub-5193806461374156";
/* Autobuses */
google_ad_slot = "4436487963";
google_ad_width = 728;
google_ad_height = 90;
</script>
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>-->
<!--jquery-->
<script src="//code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--jquery-->
</body>
</html>			
