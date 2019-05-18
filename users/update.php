<?php
include"../header.php";
$sql = "UPDATE usuario SET nombre='$_POST[nombre]', apellido='$_POST[apellido]', correo='$_POST[correo]', clave='$_POST[pass1]', nivel=$_POST[nivel] WHERE id=$_POST[id]";

if (mysqli_query($conn, $sql)) {
	header("location: index.php");
	die();
} else {
	echo "Error " . mysqli_error($conn);
}

?>