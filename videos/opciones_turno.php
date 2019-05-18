<?php
include"../connection.php";
$jugador = $_REQUEST['j'];
$juego = $_REQUEST['c'];
$opciones = "<option></option>";
$sql = "SELECT `id`, `nro_turno`, `posicion`, `inning` FROM `turnos` WHERE `id_jugador`='$jugador' AND `id_calendario`='$juego'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		if($row['pocision'] != "pi"){
			$opciones = $opciones."<option value=".$row['id'].">Inning ".$row['inning']." turno ".$row['nro_turno']."</option>";
		}
		else{
			$opciones = $opciones."<option value=".$row['id'].">Inning ".$row['inning']."</option>";
		}        
	}
}
echo $opciones;
?>