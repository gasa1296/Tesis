<?php
include"../header.php";

$sql = "INSERT INTO `calendario`(`fecha`, `nro_juego`, `id_temporada`, `instancia_temporada`, `estado`, `equipo`) 
VALUES ('=$_POST[fecha]','$_POST[nro_juego]','$_POST[temporada]', '$_POST[instancia_temporada]', 0, '$_POST[equipo]')";

if (mysqli_query($conn, $sql)) {
	header("location: index.php");
	die();
}
 else {
	echo "Error: ". mysqli_error($conn);
}
?>