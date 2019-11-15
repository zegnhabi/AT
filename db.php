<?php
//creamos la conexion a la basse de datos
$link = mysqli_connect(getenv('DB_URL'), getenv('DB_USER'), getenv('DB_PASSWORD'), getenv('DB_NAME')) or die(mysqli_error());
mysqli_select_db($link, getenv('DB_NAME')) or die(mysqli_error());
?>
