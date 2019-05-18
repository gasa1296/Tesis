<?php
include"../connection.php";
$juego = $_REQUEST['c'];
$opciones = "<option></option>";
$sql = "SELECT DISTINCT lo1.id_jugador, lo2.apellido, lo2.nombre, lo2.numero FROM turnos lo1 INNER JOIN jugador lo2 ON lo1.id_jugador=lo2.id where lo1.id_calendario='$juego'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		$opciones = $opciones."<option value=".$row['id_jugador'].">".$row['numero']." - ".$row['nombre']." ".$row['apellido']."</option>";        
	}
}
echo $opciones;
?>