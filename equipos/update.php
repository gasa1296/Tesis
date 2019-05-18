<?php
include"../header.php";

$sql = "UPDATE equipo SET nombre='$_POST[nombre]', alias='$_POST[alias]' WHERE id='$_POST[id]'";

if (mysqli_query($conn, $sql)) {
	header("location: index.php");
	die();
} else {
	echo "Error " . mysqli_error($conn);
}

?>