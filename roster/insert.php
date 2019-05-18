<?php

include"../header.php";

$camisa=archivo('camisa', '../img/jugadores');
$foto_perfil=archivo('foto_perfil', '../img/jugadores');

if($camisa!='' && $foto_perfil!=''){
	$sql = "INSERT INTO jugador (nombre, apellido, fecha_nacimiento, lugar_nacimiento, posicion, lanza, batea, estado, numero, R32, imagen, foto_perfil) VALUES ('$_POST[nombre]', '$_POST[apellido]', '$_POST[fecha]', '$_POST[lugar]', '$_POST[posicion]', '$_POST[lanza]', '$_POST[batea]', 1, '$_POST[numero]', 0, '$camisa', '$foto_perfil')";
	if (mysqli_query($conn, $sql)) {
		header("location: index.php");
		die();
	}
	 else {
		echo "Error: ". mysqli_error($conn);
	}
}

function archivo($archivo, $directorio){
	//Validamos que el archivo exista
	if(isset($_FILES[$archivo]) && $_FILES[$archivo]["name"]) {
		$source = $_FILES[$archivo]["tmp_name"]; //Obtenemos un nombre temporal del archivo
		//Filtrado según el tipo de archivo
		if($_FILES[$archivo]["type"]=="image/jpeg" || $_FILES[$archivo]["type"]=="image/pjpeg" || $_FILES[$archivo]["type"]=="image/gif" || $_FILES[$archivo]["type"]=="image/png"){

			//Validamos si la ruta de destino existe, en caso de no existir la creamos
			if(!file_exists($directorio)){
				mkdir($directorio, 0777) or die("No se puede crear el directorio de extracción");	
			}
			else{
				if(move_uploaded_file($source, $directorio.'/'.$_FILES[$archivo]["name"])){
					return $_FILES[$archivo]["name"];
				}
				else{
					echo 'Ha ocurrido un error con el archivo '.$_FILES[$archivo]["name"].', por favor inténtelo de nuevo.';
				}
			}
		}else{
			echo 'El tipo del archivo de nombre '.$_FILES[$archivo]["name"].', no está permitido';
		}
	}else{
		echo 'No se encuentra el archivo enviado.';
	}
}
?>

