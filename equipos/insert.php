<?php
include"../header.php";

$sql = "INSERT INTO equipo (nombre, alias, estado) VALUES ('$_POST[nombre]', '$_POST[alias]', 1)";

if (mysqli_query($conn, $sql)) {
	header("location: index.php");
	die();
} else {
	echo "Error " . mysqli_error($conn);
}
?>