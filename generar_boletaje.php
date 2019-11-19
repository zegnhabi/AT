<?php
$boleto=0;
include("db.php");
for($ano=2019;$ano<2030;$ano++):
	for($mes=4;$mes<13;$mes++):
		for($dia=1;$dia<32;$dia++):
			for($horas=17;$horas<=20;$horas += 3):
				$sql="INSERT INTO `at`.`boleto` (
				`id` ,
				`hora_salida` ,
				`hora_llegada` ,
				`num_autobus` ,
				`nombre_terminal_salida` ,
				`ciudad_salida` ,
				`fecha_salida` ,
				`nombre_terminal_llegada` ,
				`ciudad_llegada` ,
				`fecha_llegada` ,
				`precio` 
				)
				VALUES (
				'$boleto', '$horas:00:00', '09:00:00', '1', 'MONTERREY', 'MONTERREY', '$ano-$mes-$dia', 'CDMX', 'CDMX', '$ano-$mes-$dia', '600'
				);";
				$result=mysqli_query($sql);
				$boleto++;
			endfor; 
		endfor;
	endfor;
endfor;
echo "<div>Boleto: $boleto</div>";
for($ano=2019;$ano<2030;$ano++):
	for($mes=4;$mes<13;$mes++):
		for($dia=1;$dia<32;$dia++):
			for($horas=17;$horas<=20;$horas += 3):
				$sql="INSERT INTO `at`.`boleto` (
				`id` ,
				`hora_salida` ,
				`hora_llegada` ,
				`num_autobus` ,
				`nombre_terminal_salida` ,
				`ciudad_salida` ,
				`fecha_salida` ,
				`nombre_terminal_llegada` ,
				`ciudad_llegada` ,
				`fecha_llegada` ,
				`precio` 
				)
				VALUES (
				'$boleto', '$horas:00:00', '09:00:00', '2', 'CDMX', 'CDMX', '$ano-$mes-$dia', 'MONTERREY', 'MONTERREY', '$ano-$mes-$dia', '600'
				);";
				$result=mysqli_query($sql);
				$boleto++;
			endfor; 
		endfor;
	endfor;
endfor;
echo "<div>Boleto: $boleto</div>";
?>