<?php
	session_start();
	include("db.php");
?>
<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="images/favicon.ico"/> 
<link rel="stylesheet" type="text/css" href="styles/admin.css" />
<link rel="stylesheet" type="text/css" href="styles/estilo.css" />
<script language="javascript" type="text/javascript" src="js/calendario.js"></script>
<script src="js/jquery.js" type="text/javascript" language="javascript"></script>
	<title>Administracion de Autobuses SQLeros.Com.Ar</title>
<script language="javascript">
	$(document).ready(function(){
			//Menu altas callback..
			$("#menuAltas").click(function(){
				$("#altas").show("slow");
				$("#bajas").fadeOut("slow");
				$("#consultas").fadeOut("slow");
			});
			//Menu consultas callback..
			$("#menuConsultas").click(function(){
				$("#altas").fadeOut("slow");
				$("#bajas").fadeOut("slow");
				$("#consultas").show("slow");
			});
			//---------Manejadores para los menus de abajo -----------//
			$("#altachofer").click(function()
			{
					$("#dac").show("slow");
					$("#daa").hide("slow");
					$("#daco").hide("slow");
					$("#dat").hide("slow");
					$("#dab").hide("slow");
			});
			$("#altaautobus").click(function()
			{
					$("#daa").show("slow");
					$("#dac").hide("slow");
					$("#daco").hide("slow");
					$("#dat").hide("slow");
					$("#dab").hide("slow");
			});
			$("#altacorridas").click(function()
			{
					$("#daa").hide("slow");
					$("#dac").hide("slow");
					$("#daco").show("slow");
					$("#dat").hide("slow");
					$("#dab").hide("slow");
			});
			$("#altaterminal").click(function()
			{
					$("#daa").hide("slow");
					$("#dac").hide("slow");
					$("#daco").hide("slow");
					$("#dat").show("slow");
					$("#dab").hide("slow");
					
			});
			$("#altaboleto").click(function()
			{
					$("#daa").hide("slow");
					$("#dac").hide("slow");
					$("#daco").hide("slow");
					$("#dat").hide("slow");
					$("#dab").show("slow");
					
			});
			//agregar chofer
			$("#acf").submit(function()
			{
				$("#msgbox").removeClass().addClass('messagebox').text('Ejecutando Consulta....').fadeIn(1000);
				$.post("insertar_chofer.php",{ nomchofer:$("#nomchofer").val(),sexchofer:$("#sexchofer").val(),edadchofer:$("#edadchofer").val(),numchofer:$("#numchofer").val(),rand:Math.random() } ,	function(data){
					if(data=="yes")
					{
						$("#msgbox").fadeTo(200,0.1,function()
						{
							$(this).html('Registro Agregado.....').addClass('messageboxok').fadeTo(900,1,function()
							{
								$("#nomchofer").val("");
								$("#sexchofer").val("");
								$("#edadchofer").val("");
								$("#numchofer").val("");
							});
						});
					}else
						$("#msgbox").fadeTo(200,0.1,function(){
							  $(this).html('Datos no registrados...').addClass('messageboxerror').fadeTo(900,1);
							  $("#nomchofer").val("");
								$("#sexchofer").val("");
								$("#edadchofer").val("");
								$("#numchofer").val("");
						});
				});
			return false;
			});
			//agregar terminal
			$("#atf").submit(function()
			{
				$("#msgbox").removeClass().addClass('messagebox').text('Ejecutando Consulta....').fadeIn(1000);
				$.post("insertar_terminal.php",{ terminal:$("#terminal").val(),rand:Math.random() } ,	function(data){
					if(data=="yes")
					{
						$("#msgbox").fadeTo(200,0.1,function()
						{
							$(this).html('Registro Agregado.....').addClass('messageboxok').fadeTo(900,1,function()
							{
								$("#terminal").val("");
							});
						});
					}else
						$("#msgbox").fadeTo(200,0.1,function(){
							  $(this).html("...").addClass('messageboxerror').fadeTo(900,1);
							  $("#terminal").val("");
						});
				});
			return false;
			});
			//agregar un autobus..
			$("#aaf").submit(function()
			{
				$("#msgbox").removeClass().addClass('messagebox').text('Ejecutando Consulta....').fadeIn(1000);
				$.post("insertar_autobus.php",{ numautobus:$("#numautobus").val(),numasientos:$("#numasientos").val(),modautobus:$("#modautobus").val(),numserie:$("#numserie").val(),choferautobus:$("#choferautobus").val(),rand:Math.random() } ,function(data){
				//alert(data);
					if(data=="yes")
					{
						$("#msgbox").fadeTo(200,0.1,function()
						{
							$(this).html('Registro Agregado.....').addClass('messageboxok').fadeTo(900,1,function()
							{
								$("#numautobus").val("");
								$("#numasientos").val("");
								$("#modautobus").val("");
								$("#numserie").val("");
								$("#choferautobus").val("");
							});
						});
					}else
						$("#msgbox").fadeTo(200,0.1,function(){
							  $(this).html("...").addClass('messageboxerror').fadeTo(900,1);
							  $("#numautobus").val("");
								$("#numasientos").val("");
								$("#modautobus").val("");
								$("#numserie").val("");
								$("#choferautobus").val("");
						});
				});
			return false;
			});
			//agregar un corridas..
			$("#acof").submit(function()
			{
				$("#msgbox").removeClass().addClass('messagebox').text('Ejecutando Consulta....').fadeIn(1000);
				$.post("insertar_corrida.php",{ ciudad:$("#ciudad").val(),hora:$("#hora").val(),fecha:$("#fecha").val(),rand:Math.random() } ,function(data){
				//alert(data);
					if(data=="yes")
					{
						$("#msgbox").fadeTo(200,0.1,function()
						{
							$(this).html('Registro Agregado.....').addClass('messageboxok').fadeTo(900,1,function()
							{
								$("#ciudad").val("");
								$("#hora").val("");
								$("#fecha").val("");
							});
						});
					}else
						$("#msgbox").fadeTo(200,0.1,function(){
							  $(this).html(data).addClass('messageboxerror').fadeTo(900,1);
							 $("#ciudad").val("");
								$("#hora").val("");
								$("#fecha").val("");
						});
				});
			return false;
			});
	});
</script>
</head>
<body>
<div id="Cabecera" align="center">
	<img src="images/logo.jpg" alt="Autobuses SQLeros.Com.Ar"/>
</div>
<div id="nombreAdmin" align="center">
	<label> Bienvenido: <?php echo $_SESSION['uname'];?></label>
	<label id="menuAltas" style="cursor:pointer;"> Operaciones </label>
	<label id="menuConsultas" style="cursor:pointer;"> Consultas </label>
	<label><a href="secure.php?salir">Salir</a></label>
</div>
<div id="contenido" align="center">
	<br/>
	<br/>
	<div id="altas" style="display:none;">
		<label id="altachofer" style="cursor:pointer;">Chofer</label>
		<label id="altaautobus" style="cursor:pointer;">Autobus</label>
		<label id="altacorridas" style="cursor:pointer;">Corridas</label>
		<label id="altaterminal" style="cursor:pointer;">Terminal</label>
		<label id="altaboleto" style="cursor:pointer;">Boleto</label>
	</div>
	<div id="consultas" style="display:none;">
		<label id="altachofer" style="cursor:pointer;">Chofer</label>
		<label id="altaautobus" style="cursor:pointer;">Autobus</label>
		<label id="altaboletos" style="cursor:pointer;">Boletos</label>
		<label id="altaCorridas" style="cursor:pointer;">Corridas</label>
	</div>
	<!--Inicia Form de alta chofer-->
	<div id="dac" style="display:none;border: 1px dotted; width:300px; border-color:#FF8000;">
		<form id="acf">
			<table>
				<tr>
					<td colspan="2">
						Nombre: <br />
						<input type="text" id="nomchofer" >  
					</td>
				</tr>
				<tr>
					<td>
						Sexo: <br />
						<select id="sexchofer">
							<option value="M" />Masculino
							<option value="F" />Femenino
						</select>
					</td>
					<td>
						Edad: <br />
						<select id="edadchofer">
							<?php 
							for($i=18;$i<=50;$i++)
							{
								echo "<option value=\"$i\" />$i";
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Numero Telefonico: <br />
						<input type="text" id="numchofer" > 
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" id="fac" >
						<input type="reset" id="x" >
					</td>
				</tr>
			</table>
		</form>
	</div>
	<!--Inicia Form de alta autobus-->
	<div id="daa" style="display:none;border: 1px dotted; width:300px; border-color:#FF8000;">
		<form id="aaf">
			<table>
				<tr>
					<td colspan="2">
						No. de autobus: <br />
						<input type="text" id="numautobus" >  
					</td>
				</tr>
				<tr>
					<td colspan="2">
						No. de asientos: <br />
						<input type="text" id="numasientos" > 
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Modelo: <br />
						<input type="text" id="modautobus" > 
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Placas: <br />
						<input type="text" id="numserie" > 
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Chofer: <br />
						<select id="choferautobus">
						<?php
						$consulta="SELECT id_chofer as id,nombre FROM chofer;";
						$tabla=mysqli_query($link, $consulta);
						while($registro=mysqli_fetch_array($tabla))
						{
							echo "<option value=\"".$registro['id']."\" >".$registro['nombre'];
						}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" id="x" >
						<input type="reset" id="y" >
					</td>
				</tr>
			</table>
		</form>
	</div>
	<!--Inicia Form de alta corridas-->
	<div id="daco" style="display:none;border: 1px dotted; width:300px; border-color:#FF8000;">
		<form id="acof">
			<table>
				<tr>
					<td colspan="2">
						Ciudad: <br />
						<input type="text" id="ciudad" >  
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Hora de Salida: (hh:mm:ss)<br />
						<input type="text" id="hora" maxlength="8" > 
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Fecha:<br />
						<input id="fecha" type="text" maxlength="10" readonly="readonly"> 
				<a href="javascript:NewCal('fecha','ddmmyyyy')"><img 
				src="images/calendario.gif" width="16" height="16" 
				border="0" alt="Selecciona una fecha"></a>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" id="x" >
						<input type="reset" id="y" >
					</td>
				</tr>
			</table>
		</form>
	</div>
	<!--Inicia Form de alta terminal-->
	<div id="dat" style="display:none;border: 1px dotted; width:300px; border-color:#FF8000;">
		<form id="atf">
			<table>
				<tr>
					<td colspan="2">
						Nombre de la terminal: <br />
						<input type="text" id="terminal" >  
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" id="x" >
						<input type="reset" id="y" >
					</td>
				</tr>
			</table>
		</form>
	</div>
	<!--Inicia Form de crear el puto boleto 2_@-->
	<div id="dab" style="display:none;border: 1px dotted; width:300px; border-color:#FF8000;">
		<form id="abf">
			<table>
				<tr>
					<td colspan="2">
						Hora de salida: <br />
						<input type="text" id="terminal" >  
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Hora de llegada: <br />
						<input type="text" id="terminal" >  
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Autobus: <br />
						<input type="text" id="terminal" >  
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Terminal de salida<br />
						<input type="text" id="terminal" >  
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Fecha de salida: <br />
						<input type="text" id="terminal" >  
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Terminal de llegada: <br />
						<input type="text" id="terminal" >  
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Fecha de llegada: <br />
						<input type="text" id="terminal" >  
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Precio: <br />
						<input type="text" id="terminal" >  
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" id="x" >
						<input type="reset" id="y" >
					</td>
				</tr>
			</table>
		</form>
	</div>
<!--Inicia el div de los mensajitos Ajax.... �_�-->
<span id="msgbox" style="display:none"></span>
</div>
<br/>
<br/>
<br/>
<br/>
<div id="pie">
	<span id="msgbox" style="display:none"></span>
	<i class="copy">&reg; 2009 -  <?php echo date('Y'); ?> Autobuses SQLeros.Com.Ar</i>
</div>
</body>
</html>