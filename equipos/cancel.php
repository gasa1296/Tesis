<?php
include"../header.php";

$id=@$_GET['id'];

$sql = "UPDATE `equipo` SET estado=0 WHERE id='$id'";

if (mysqli_query($conn, $sql)) {
	header("location: index.php");
	die();
} else {
	echo "Error updating record: " . mysqli_error($conn);
}

?>