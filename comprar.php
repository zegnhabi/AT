	<?php
session_start();
	if($_SESSION['lang']){
		$lang=$_SESSION['lang'];
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
	}
	include("db.php");
?>
<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<script language="javascript" type="text/javascript" src="js/util.js"></script>
<link rel="stylesheet" type="text/css" href="styles/estilo.css" />
<link rel="shortcut icon" href="images/favicon.ico"/> 
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
<title><?php echo $title4;?></title>
</head>
<body onload="Util.scrlsts();">
<div id="adsenseFooter" align="center"><script type="text/javascript"><!--
google_ad_client = "ca-pub-5193806461374156";
/* autobuses header */
google_ad_slot = "3892902209";
google_ad_width = 728;
google_ad_height = 15;
//-->
</script>
<script type="text/javascript"
src="https://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>
<div id="Cabecera" align="center">
	<img src="images/logo.jpg" alt="Autobuses at-sqleros.herokuapp.com"/>
</div>

<?php
if(isset($_GET['id']) && isset($_GET['as']))
{
	//Cargamos los valores de los datos.
	$id_boleto=base64_decode($_GET['id']);
	$asientos=base64_decode($_GET['as']);
	$asientos=explode(",",$asientos);
	//Creamos la consulta SQL para los datos de la corrida.
	$consulta="SELECT * FROM `boleto` WHERE `id` = $id_boleto";
	$tabla = mysqli_query($link, $consulta);
?>
<div id="Cuerpo"  align="center">
	<form id="boleto" method="post" action="">
	<table id="opciones">
		<tr>
			<td colspan="4">
				<label><?php echo $ComprarBoletos;?></label>
			</td>
		</tr>
		<tr>
			<td>
				<label><?php echo $xfecha;?></label>
			</td>
			<td>
				<label><?php echo $xhora;?></label>
			</td>
			<td>
				<label><?php echo $xD;?></label>
			</td>
			<td>
				<label><?php echo $xA;?></label>
			</td>
		</tr>
		<tr>
			<?php 
			while ($registro = mysqli_fetch_array($tabla))
			{
			?>
			<td>
				<?php echo $registro['fecha_salida'];?>
			</td>
			<td>
				<?php echo $registro['hora_salida'];?>
			</td> 
			<td>
				<?php echo $registro['ciudad_salida'];?>
			</td>
			<td>
				<?php echo $registro['ciudad_llegada'];?>
			</td>
			<?php
			}
			//liberamos la tabla del bloqueo..
			mysqli_free_result($tabla); 
			?>
		</tr>
		<tr>
			<td colspan="2">
				<label><?php echo $Asientos;?></label>
			</td>
			<td colspan="2"><label><?php echo $NombreDelPasajero;?></label></td>
		</tr>
				<?php
				//Ordenamos el array.
				sort($asientos);
				for($i=0;$i<count($asientos);$i++)
				{
					$labelAsiento=substr($asientos[$i],-2);
					echo "<tr><td colspan=\"1\"><input type=\"hidden\" id=\"asiento$i\" value=\"$labelAsiento\"/ ><label>$labelAsiento</label></td><td colspan=\"3\"><input type=\"text\" id=\"nombre$i\" class=\"boleto\" value=\"\" maxlength=\"65\" onfocus=\"Util.focusCampo(this);\" onblur=\"Util.blurCampo(this);\" / ></td></tr>";
				}
				?>
		</table>
		<!--terminan las opciones-->
</div>
</div>
	<table id="continuar" align="center">
		<tr>
			<td>
				<img src="images/regresar.gif" onclick="Util.Regresar();" class="links" />
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				<img src="images/continuar.gif" id="continuar" onclick="Util.realizarCompra();" class="links"/>
			</td>
		</tr>
	</table>
	<input type="hidden" id="id_boleto" value="<?php echo $id_boleto; ?>" />
	</form>
</div>
<i class="copy">&reg; 2009 -  <?php echo date('Y'); ?> <a href="https://at-sqleros.herokuapp.com/wps">at-sqleros.herokuapp.com</a> <a href="mailto:zegnhabi@gmail.com?subject=Comentarios y sugerencias sistema de boletaje"> <?php echo $contacto;?> </a></i>
<div id="adsenseHeader" align="center">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-5193806461374156";
/* Autobuses */
google_ad_slot = "4436487963";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="https://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
</body>
</html>

<?php
}else{
?>
<div class="error">
	<?php echo $excepcion;?>
</div><br />
<i class="copy">&reg; 2009 -  <?php echo date('Y'); ?> <a href="https://at-sqleros.herokuapp.com">at-sqleros.herokuapp.com</a> <a href="mailto:zegnhabi@gmail.com?subject=Comentarios y sugerencias sistema de boletaje"> <?php echo $contacto;?> </a></i>
<div id="adsenseHeader" align="center">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-5193806461374156";
/* Autobuses */
google_ad_slot = "4436487963";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="https://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
</body>
</html>
<?php
}
?>