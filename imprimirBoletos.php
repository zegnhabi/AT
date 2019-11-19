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
	
	function codigo($codigo){
	//para ponerlo en una lugar donde se puedan escribir archivos
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG prefijo de localizaci�n
    $PNG_WEB_DIR = 'temp/';
    include "QRCode/qrlib.php"; 
    //a webo que necesitas tener derechos para escribir y crear
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    //nombre del archivo
    $filename = $PNG_TEMP_DIR.'test.png';
	    $errorCorrectionLevel = 'H';
	//Maximo del tama�o en puntos
    $matrixPointSize = 4;
	//Codigo
    if (isset($codigo)) { 
        //esto es muy importante!
        if (trim($codigo) == '')
            die('<h1>Error</h1>');
        // codigo de los boletos...
        $filename = $PNG_WEB_DIR.'QRCode'.md5($codigo.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($codigo, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
	return $PNG_WEB_DIR.basename($filename);
	}
}
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
<title><?php echo $title5;?></title>
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
	<img src="images/logo.jpg" alt="Autobuses SQLeros.Com.Ar"/>
</div>

<?php
if(isset($_GET['id']) && isset($_GET['as']) && isset($_GET['no']))
{
	//Cargamos los valores de los datos.
	$id_boleto=base64_decode($_GET['id']);
	$asientos=base64_decode($_GET['as']);
	$asientos=explode(",",$asientos);
	$nombres=base64_decode($_GET['no']);
	$nombres=explode(",",$nombres);
	$fechaHoy=date("Y-m-d");
	
?>
<div id="Cuerpo"  align="center">
<table id="Notificacion" >
	<tr>
		<td>
			<label><?php echo $SeHanComprado." ".count($asientos)." ".$Boletos;?>  <a href="javascript:void(0);" onclick="Util.imprimirBoleto();"> <?php echo $Imprimir;?> </a><a href="javascript:void(0);" onclick="location.href='';"> <?php echo $Inicio;?> </a><a href="mailto:zegnhabi@gmail.com"> <?php echo $contacto;?> </a></label>
		</td>
	</tr>
</table>
<?php
	//Insertamos los datos de los boletos.
	for($i=0;$i<count($asientos);$i++)
	{
		//Creamos la consulta SQL para los datos de la corrida.
		$consulta="insert into boletos values (null,$id_boleto,$asientos[$i],'".utf8_decode($nombres[$i])."','$fechaHoy')";
		$tabla = mysqli_query($link, $consulta);
	}
	//Creamos la consulta SQL para los datos de los boletos.
	$consulta="SELECT * FROM `boleto` WHERE `id` = $id_boleto";
?>
<div id="boleto">
<?php
	for($i=0;$i<count($asientos);$i++)
	{
	$tabla = mysqli_query($link, $consulta);
	$registro = mysqli_fetch_array($tabla);
	$codigo=sprintf("Boleto: %s. Origen: %s. Destino: %s. Pasajero: %s. Fecha Salida: %s. Asiento: %s. ",
								$id_boleto,
								$registro['ciudad_salida'],
								$registro['ciudad_llegada'],
								utf8_decode($nombres[$i]),
								$registro['fecha_salida'],
								$asientos[$i]);
	$imagen=codigo($codigo);
?>
	<table id="<?php echo "cuerpoBoleto$i";?>" style="border:1px dotted;">
		<tr align="center">
			<td colspan="2">
				<tt><?php echo $marca="Autobuses SQLeros.Com.Ar S.A. de C.V";?></tt>
			</td>
		</tr>
		<tr align="left">
			<td>
				<tt><?php echo $xorigen;?>:</tt>
			</td>
			<td>
				<tt><?php echo $Terminaldesalida;?></tt>
			</td>
		</tr>
		<tr align="left">
			<td>
				<tt><?php echo $registro['ciudad_salida'];?></tt>
			</td>
			<td>
				<tt><?php echo $registro['nombre_terminal_salida'];?></tt><br/><br/>
			</td>
		</tr>
		<tr align="left">
			<td>
				<tt><?php echo $xdestino;?>:</tt>
			</td>
			<td>
				<tt><?php echo $Terminaldellegada;?></tt>
			</td>
		</tr>
		<tr align="left">
			<td>
				<tt><?php echo $registro['ciudad_llegada'];?></tt>
			</td>
			<td>
				<tt><?php echo $registro['nombre_terminal_llegada'];?></tt><br/><br/>
			</td>
		</tr>
		<tr align="left">
			<td>
				<tt><?php echo $Fechadesalida;?></tt>
			</td>
			<td>
				<tt><?php echo $Asiento;?></tt>
			</td>
		</tr>
		<tr align="left">
			<td>
				<tt><?php echo $registro['fecha_salida'];?></tt>
			</td>
			<td>
				<tt><?php echo $asientos[$i];?></tt><br/><br/>
			</td>
		</tr>
		<tr align="left">
			<td>
				<tt><?php echo $Horadesalida;?></tt>
			</td>
			<td>
				<tt><?php echo $Precio;?></tt>
			</td>
		</tr>
		<tr align="left">
			<td>
				<tt><?php echo $registro['hora_salida'];?></tt>
			</td>
			<td>
				<tt><?php echo "$".$registro['precio'];?></tt><br/><br/>
			</td>
		</tr>
		<tr align="left">
			<td colspan="2">
				<tt><?php echo $Nombre;?></tt>
			</td>
		</tr>
		<tr align="left">
			<td colspan="2">
				<tt><?php echo utf8_decode($nombres[$i]); ?></tt><br/><br/>
			</td>
		</tr>
		<tr align="left">
			<td colspan="2">
				<tt><?php echo $LugaryfechadeEx;?></tt>
			</td>
		</tr>
		<tr align="left">
			<td colspan="2">
				<tt><?php echo $registro['ciudad_salida']." a  ".$fechaHoy; ?></tt><br/><br/>
			</td>
		</tr>
		<tr align="center">
			<td colspan="2">
				<tt><?php echo $sugerencia;?></tt><br/><br/>
			</td>
		</tr>
		<tr align="center">
			<td colspan="2">
				<img src="<?php echo $imagen;?>" height="50%" width="50%"/>
			</td>
		</tr>
	</table>
<?php
		}
?>
	</div>
</div>
<br />
<i class="copy">&reg;2012 <a href="http://www.sqleros.com.ar">SQLeros.Com.Ar</a> <a href="mailto:zegnhabi@gmail.com?subject=Comentarios y sugerencias sistema de boletaje"> <?php $contacto;?> </a></i>
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
<i class="copy">&reg;2012 <a href="http://www.sqleros.com.ar/">SQLeros.Com.Ar</a> <a href="mailto:zegnhabi@gmail.com?subject=Comentarios y sugerencias sistema de boletaje"> <?php $contacto;?> </a></i>
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