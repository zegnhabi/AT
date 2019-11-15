<?php 

session_start();

include("db_safe.php");

//validamos si existe el nombre.. y el pass
$stmt = $mysqli->prepare('insert into terminal values (null, ?)');

if (!$stmt->bind_param('s', $_POST['terminal'])) {
	die("Error binding parameter.");
}

if (!$stmt->execute()) {
	die("Error executing query.");
}

if ($stmt->insert_id) {
	echo "Yes";
} else {
	echo "No";
}