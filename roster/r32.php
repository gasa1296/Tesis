<?php

include"../header.php";

$sql = "UPDATE `jugador` SET `R32`=!R32 WHERE `id`=$_GET[id]";
if (mysqli_query($conn, $sql)) {
	header("location: index.php");
	die();
}
 else {
	echo "Error: ". mysqli_error($conn);
}

?>