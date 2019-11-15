<?php
//creamos la conexion a la basse de datos
mysqli_connect(getenv('DB_URL'), getenv('DB_USER'), getenv('DB_PASSWORD')) or die(mysqli_error());
mysqli_select_db("at") or die(mysqli_error());
?>
