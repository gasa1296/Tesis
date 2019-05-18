<?php
include"../header.php";

$sql = "UPDATE `calendario` SET fecha='$_POST[fecha]', nro_juego='$_POST[nro_juego]', equipo='$_POST[equipo]', estado=0, equipo='$_POST[equipo]', instancia_temporada='$_POST[instancia_temporada]' WHERE id='$_POST[id]'";

if (mysqli_query($conn, $sql)) {
	header("location: index.php");
	die();
} else {
	echo "Error: " . mysqli_error($conn);
}

?>