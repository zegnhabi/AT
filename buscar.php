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
<title><?php echo $title2;?></title>
</head>

<body onload="Util.scrlsts();">
<div id="adsenseFooter" align="center">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-5193806461374156";
/* autobuses header */
google_ad_slot = "3892902209";
google_ad_width = 728;
google_ad_height = 15;
//-->
</script>
<script type="text/javascript"
src="https://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<div id="Cabecera" align="center">
	<img src="images/logo.jpg" alt="Autobuses SQLeros.Com.Ar"/>
</div>

<?php
if(isset($_GET['or']) && isset($_GET['de']) && isset($_GET['fe']) && isset($_GET['fh']))
{
	//Cargamos los valores de los datos.
	$diferencia=2;
	$origen=base64_decode($_GET['or']);
	$destino=base64_decode($_GET['de']);
	$fecha=base64_decode($_GET['fe']);
	$fechaHoy=base64_decode($_GET['fh']);
	$fechaHoy=explode("-",$fechaHoy);
	$fecha=explode("-",$fecha);
	$fechaHoy = date("Y-m-d",mktime(0,0,0,$fechaHoy[1],$fechaHoy[0],$fechaHoy[2]));
	$fecha = date("Y-m-d",mktime(0,0,0,$fecha[1],$fecha[0],$fecha[2]));
	$hora = getdate(time());
	$hora=(($hora["hours"]==0?12:$hora["hours"])-$diferencia). ":" . $hora["minutes"] . ":" . $hora["seconds"] ; 
	//Creamos la consulta SQL
	if($fecha==$fechaHoy)
		$tabla = mysqli_query("select b.id,b.hora_salida,b.precio,b.hora_llegada from boleto b where b.ciudad_salida like('$origen') and b.ciudad_llegada like('$destino') and b.fecha_salida like('$fecha') and b.hora_salida >= '$hora'");
	else if($fecha>$fechaHoy)
		$tabla = mysqli_query("select b.id,b.hora_salida,b.precio,b.hora_llegada from boleto b where b.ciudad_salida like('$origen') and b.ciudad_llegada like('$destino') and b.fecha_salida like('$fecha')");
	else
	{
?>
	<div class="error"><?php echo $excepcion;?></div><br />
	<i class="copy">&reg;2012 Autobuses SQLeros.Com.Ar</i>
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
	return 0;
	}
?>
<div id="Cuerpo"  align="center">
	<form id="busqueda" method="post" action="">
	<table id="opciones">
		<tr>
			<td colspan="3" align="center">
				<img src="images/salida.gif"  width="100%"/>
			</td>
		</tr>
		<tr>
			<td>
				<label><?php echo $fechaIda;?></label>
			</td>
			<td>
				<label><?php echo $xorigen;?></label>
			</td>
			<td>
				<label><?php echo $xdestino;?></label>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $fecha; ?>
			</td>
			<td>
				<?php echo $origen; ?>
			</td>
			<td>
				<?php echo $destino; ?>
			</td>
		</tr>
		<tr>
			<td>
				<label><?php echo $xhorario;?></label>
			</td>
			<td>
				<label><?php echo $xtarifa;?></label>
			</td>
			<td>
				<label><?php echo $tiempoRecorrido;?></label>
			</td>
		</tr>
		<?php
			$fila=1;
			while ($registro = mysqli_fetch_array($tabla)) { 
		?>
		<tr class="color<?php if($fila==1){echo $fila;$fila++;}else if($fila==2){echo $fila;$fila=1;}?>" onclick="">
			<td>
				<input 
				type="radio" 
				id="id_corrida" 
				name="id_corrida"
				value="<?php echo "$registro[0]"; ?>" 
				onclick=""/>
				<label class="contenidoTabla"><?php echo "$registro[1]"; ?></label>
			</td>
			<td>
				<label class="contenidoTabla"><?php echo "$registro[2]"; ?></label>
			</td>
			<td>
				<label class="contenidoTabla"><?php echo "$registro[3]"; ?></label>
			</td>
		</tr>
		<?php
			}
		?>
		<tr>
			<td>
				<img src="images/regresar.gif" onclick="Util.Regresar();" class="links" />
			</td>
			<td>
				&nbsp;
			</td>
			<td>
				<img src="images/continuar.gif" id="continuar" onclick="Util.seleccionar();" class="links"/>
			</td>
		</tr>
	</table>
	</form>
</div>
<?php
}else{
?>
<div class="error"><?php echo error;?></div><br />
<?php
}
?>
<i class="copy">&reg;2012 <a href="http://www.sqleros.com.ar/">SQLeros.Com.Ar</a> <a href="mailto:zegnhabi@gmail.com?subject=Comentarios y sugerencias sistema de boletaje"><? echo $contacto;?></a></i>
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