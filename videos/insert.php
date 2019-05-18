<?php
include"../header.php";

$jugador = $_POST['jugador'];
$juego = $_POST['equipo'];
$turno = $_POST['turno'];
$camara = $_POST['camara'];

$_FILES['video']['name']; //este es el nombre del archivo que acabas de subir
$_FILES['video']['type']; //este es el tipo de archivo que acabas de subir
$_FILES['video']['tmp_name'];//este es donde esta almacenado el archivo que acabas de subir.
$_FILES['video']['size']; //este es el tamaño en bytes que tiene el archivo que acabas de subir.
$tamaño=$_FILES['video']['error']; //este almacena el codigo de error que resultaría en la subida.

$id_temporada;

$sql = "SELECT id_temporada FROM calendario WHERE id='$juego'";
$result = mysqli_query($conn, $sql);
if($result){
	while ($row = mysqli_fetch_assoc($result)) {
		$id_temporada = $row['id_temporada'];
	}
}
//$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");

$carpetaDestino="videos/".$id_temporada."/".$juego."/".$jugador."/".$camara;
# si es un formato de imagen
if($_FILES["video"]["type"]=="video/flv" || $_FILES["video"]["type"]=="video/avi" || $_FILES["video"]["type"]=="video/mkv" || $_FILES["video"]["type"]=="video/mp4"){
	if(file_exists($carpetaDestino)){
		$carpetaDestino = $carpetaDestino."/";
		$origen1=$_FILES["video"]["tmp_name"];
		$destino1=$carpetaDestino.$_FILES["video"]["name"];
		# movemos el archivo
		if(@move_uploaded_file($origen1, $destino1)){
			$nombre1 = $_FILES['video']['name'];

			$sql="INSERT INTO `video`(`direccion`, `id_jugador`, `id_calendario`, `id_turno`, `camara`) VALUES ('$destino1','$jugador', '$juego', '$turno', '$camara')";

			if (mysqli_query($conn, $sql)) {
				echo '<meta http-equiv="Refresh" content="0;URL=index.php">';
			}
			else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}else{
			echo "No se ha podido mover el archivo: ".$_FILES["video"]["name"];
		}
	}else{
		mkdir($carpetaDestino, 0777, true);

		$carpetaDestino = $carpetaDestino."/";
		$origen1=$_FILES["video"]["tmp_name"];
		$destino1=$carpetaDestino.$_FILES["video"]["name"];
		# movemos el archivo
		if(@move_uploaded_file($origen1, $destino1)){
			$nombre1 = $_FILES['video']['name'];

			$sql="INSERT INTO `video`(`direccion`, `id_jugador`, `id_calendario`, `id_turno`, `camara`) VALUES ('$destino1','$jugador', '$juego', '$turno', '$camara')";

			if (mysqli_query($conn, $sql)) {
				echo '<meta http-equiv="Refresh" content="0;URL=index.php">';
			}
			else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}else{
			echo "No se ha podido mover el archivo: ".$_FILES["video"]["name"];
		}
	}
}else{
	echo "Tipo de archivo no soportado";
}

?>