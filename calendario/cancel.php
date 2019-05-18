<?php
include"../header.php";

$sql = "UPDATE `calendario` SET estado=2 WHERE id='$_GET[id]'";

if (mysqli_query($conn, $sql)) {
	header("location: index.php");
	die();
} else {
	echo "Error: " . mysqli_error($conn);
}

?>