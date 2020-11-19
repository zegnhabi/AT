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
<title><?php echo $title3;?></title>
</head>
<body onload="Util.cargar();">
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
if(isset($_GET['id']))
{
	//Cargamos los valores de los datos.
	$id_boleto=base64_decode($_GET['id']);
	//Creamos un arreglo para ver los asientos totales y los que todavia estan disponibles.
	$asientos=array(
	"fila1"=>array(
	"as04"=>"vacio",
	"as08"=>"vacio",
	"as12"=>"vacio",
	"as16"=>"vacio",
	"as20"=>"vacio",
	"as24"=>"vacio",
	"as28"=>"vacio",
	"as32"=>"vacio",
	"as36"=>"vacio",
	),
	"fila2"=>array(
	"as03"=>"vacio",
	"as07"=>"vacio",
	"as11"=>"vacio",
	"as15"=>"vacio",
	"as19"=>"vacio",
	"as23"=>"vacio",
	"as27"=>"vacio",
	"as31"=>"vacio",
	"as35"=>"vacio",
	),
	"fila3"=>array(
	"as02"=>"vacio",
	"as06"=>"vacio",
	"as10"=>"vacio",
	"as14"=>"vacio",
	"as18"=>"vacio",
	"as22"=>"vacio",
	"as26"=>"vacio",
	"as30"=>"vacio",
	"as34"=>"vacio",
	),
	"fila4"=>array(
	"as01"=>"vacio",
	"as05"=>"vacio",
	"as09"=>"vacio",
	"as13"=>"vacio",
	"as17"=>"vacio",
	"as21"=>"vacio",
	"as25"=>"vacio",
	"as29"=>"vacio",
	"as33"=>"vacio",
	)
	);
	//Creamos la consulta SQL para los datos de las corridas y los asientos desocupados.
	$consulta="select id_boleto,asiento from boletos where id_boleto=$id_boleto";
	$tabla = mysqli_query($link, $consulta);
	$asientosOcupados=mysqli_num_rows($tabla);
	if($asientosOcupados >= 0 && $asientosOcupados < 36)
	{
		while ($registro = mysqli_fetch_array($tabla))
		{
			//variables de filas
			$i=4;
			$j=3;
			$k=2;
			$l=1;
			//Ciclos que recorren las filas de las esas.
			foreach($fila=$asientos['fila1'] as $asiento => $estado)
			{
				if($registro['asiento']==$i)
				{
						$asientos['fila1'][$asiento]="ocupado";
				}
				$i+=4;
			}
			foreach($fila=$asientos['fila2'] as $asiento => $estado)
			{
				if($registro['asiento']==$j)
				{
						$asientos['fila2'][$asiento]="ocupado";
				}
				$j+=4;
			}
			foreach($fila=$asientos['fila3'] as $asiento => $estado)
			{
				if($registro['asiento']==$k)
				{
						$asientos['fila3'][$asiento]="ocupado";
				}
				$k+=4;
			}
			foreach($fila=$asientos['fila4'] as $asiento => $estado)
			{
				if($registro['asiento']==$l)
				{
						$asientos['fila4'][$asiento]="ocupado";
				}
				$l+=4;
			}
		}
	}else{
	?>
<div class="error">
<?php echo $corridaSinAsientos;?>
</div><br />
<i class="copy">&reg; 2009 -  <?php echo date('Y'); ?> <a href="http://at-sqleros.herokuapp.com/wps">at-sqleros.herokuapp.com</a> <a href="mailto:zegnhabi@gmail.com?subject=Comentarios y sugerencias sistema de boletaje"> <?php $contacto;?> </a></i>
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
	//liberamos la tabla del bloqueo..
	mysqli_free_result($tabla); 
	//Creamos la consulta SQL para los datos de la corrida.
	$consulta="SELECT * FROM `boleto` WHERE `id` = $id_boleto";
	$tabla = mysqli_query($link, $consulta);
?>
<div id="Cuerpo"  align="center">
	<form id="boleto" method="post" action="">
	<table id="opciones">
		<tr>
			<td colspan="4">
				<label><?php echo $selectAsientos;?></label>
			</td>
		</tr>
		<tr>
			<td>
				<label><? echo $xfecha;?></label>
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
			<td colspan="3">
				<label><?php echo $selectNumBoletos;?></label>
			</td>
			<td colspan="1">
				<select id="num_boletos" onchange="Util.bolsMax(this.selectedIndex);">
					<?php
						for($i=1;$i<=5;$i++){
					?>
					<option value="<?php echo"$i";?>"> <?php echo"$i";?></option>
					<?php
					}
					?>
				</select>
			</td>
		</tr>
		</table>
		<!--terminan las opciones-->
		
		<!--Inicia el carrito-->
		<br />
<table id="carrito" cellspacing="0" cellpadding="0">
	<tr>
		<td rowspan="5">
		<img src="images/bus_top.gif"/>
		</td>
		<td>
		<?php
		$fila1=$asientos['fila1'];
		foreach( $fila1 as $asiento => $estado )
		{
			if($estado=="ocupado")
			{
				echo "<img src=\"images/$estado.gif\" id=\"$asiento\"/>";
			}else if($estado=="vacio")
			{
				echo "<img src=\"images/$asiento.jpg\" class=\"links\" id=\"$asiento\" onclick=\"Util.swapImage(this);\"/>";
			}
		}
		?>
		</td>
		<td rowspan="5">
		<img src="images/bus_back.gif" />
		</td>
	</tr>
	<tr>
		<td>
		<?php
		$fila2=$asientos['fila2'];
		foreach( $fila2 as $asiento => $estado )
		{
			if($estado=="ocupado")
			{
				echo "<img src=\"images/$estado.gif\" id=\"$asiento\" />";
			}else if($estado=="vacio")
			{
				echo "<img src=\"images/$asiento.jpg\" class=\"links\"  id=\"$asiento\" onclick=\"Util.swapImage(this);\"/>";
			}
		}
		?>
		</td>
	</tr>
	<tr>
		<td>
		<?php
		$fila3=$asientos['fila3'];
		foreach( $fila3 as $asiento => $estado )
		{
			if($estado=="ocupado")
			{
				echo "<img src=\"images/$estado.gif\" id=\"$asiento\"/>";
			}else if($estado=="vacio")
			{
				echo "<img src=\"images/$asiento.jpg\" class=\"links\"  id=\"$asiento\" onclick=\"Util.swapImage(this);\"/>";
			}
		}
		?>
		</td>
	</tr>
	<tr>
		<td>
		<?php
		$fila4=$asientos['fila4'];
		foreach( $fila4 as $asiento => $estado )
		{
			if($estado=="ocupado")
			{
				echo "<img src=\"images/$estado.gif\" id=\"$asiento\" />";
			}else if($estado=="vacio")
			{
				echo "<img src=\"images/$asiento.jpg\" class=\"links\"  id=\"$asiento\" onclick=\"Util.swapImage(this);\"/>";
			}
		}
		?>
		</td>
	</tr>
</table>
<br />
<div id="ind">
	<table id="indicaciones" cellpadding="0" cellspacing="0">
	<tr><td><img src="images/ocupado.gif">&nbsp;<label class="enfasis"><?php echo $AsientoOcupado;?></label>&nbsp;</label><img src="images/asientoNormal.gif">&nbsp;<label class="enfasis"><?php echo $AsientoDisponible;?>&nbsp;<img src="images/seleccionado.gif">&nbsp;<label class="enfasis"><?php echo $AsientoSeleccionado;?></label></tr>
	</table>
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
				<img src="images/continuar.gif" id="continuar" onclick="Util.avanzar();" class="links"/>
			</td>
		</tr>
	</table>
	<input type="hidden" id="num_bol_selec" value="0" />
	<input type="hidden" id="bolsMax" value="0" />
	<input type="hidden" id="id_corrida" value="<?php echo $id_boleto; ?>" />
	</form>
</div><br />
<i class="copy">&reg; 2009 -  <?php echo date('Y'); ?> <a href="http://at-sqleros.herokuapp.com/wps">at-sqleros.herokuapp.com</a> <a href="mailto:zegnhabi@gmail.com?subject=Comentarios y sugerencias sistema de boletaje"> <?php echo $contacto;?></a></i>
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
<i class="copy">&reg; 2009 -  <?php echo date('Y'); ?> <a href="http://at-sqleros.herokuapp.com/">at-sqleros.herokuapp.com</a> <a href="mailto:zegnhabi@gmail.com?subject=Comentarios y sugerencias sistema de boletaje"> Contacto </a></i>
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