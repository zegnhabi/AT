<?php
//creamos la conexion a la basse de datos
mysql_connect(getenv('DB_URL'), getenv('DB_USER'), getenv('DB_PASSWORD')) or die(mysql_error());
mysql_select_db("at") or die(mysql_error());
?>
