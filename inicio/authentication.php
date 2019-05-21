<?php
include "../connection.php";
session_start();

$sql="SELECT * FROM usuario where correo='$_POST[correo]' and estado=1";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);
if($_POST['correo']==$row['correo'] && isset($_POST['correo']) && $_POST['correo']!=""){
	if($_POST['clave'] == $row['clave'] && isset($_POST['clave']) && $_POST['clave']!=""){
		$_SESSION['currentuserx']=1;
		$_SESSION['id']=$row['id'];
		$_SESSION['correo']=$row['correo'];
		$_SESSION['nombre']=$row['nombre'];
		$_SESSION['apellido']=$row['apellido'];
		$_SESSION['jugador']=$row['id_jugador'];
		$_SESSION['nivel']=$row['nivel'];
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		header("location: index.php");
	}else{
		header("location:../index.php?status=error&msg=Clave incorrecta");
	}
}else{
	header("location:../index.php?status=error&msg=Usuario incorrecto");
}
?>
