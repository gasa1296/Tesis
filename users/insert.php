<?php
include"../header.php";
$sql = "INSERT INTO usuario(nombre, apellido, correo, clave, estado, nivel) VALUES ('$_POST[nombre]', '$_POST[apellido]', '$_POST[correo]', '$_POST[pass1]', 1, $_POST[nivel])";
if (mysqli_query($conn, $sql)) {
	header("location: index.php");
	die();
} else {
	echo "Error " . mysqli_error($conn);
}
?>