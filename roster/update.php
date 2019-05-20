<?php
include"../header.php";

if($_FILES['camisa']["name"] != '' && $_FILES['foto_perfil']["name"] != ''){
	$camisa=archivo('camisa', '../img/jugadores');
	$foto_perfil=archivo('foto_perfil', '../img/jugadores');
	if($camisa!='' && $foto_perfil!=''){
		$sql = "UPDATE jugador SET nombre='$_POST[nombre]', apellido='$_POST[apellido]', fecha_nacimiento='$_POST[fecha]', lugar_nacimiento='$_POST[lugar]', lanza='$_POST[lanza]', batea='$_POST[batea]', posicion='$_POST[posicion]', imagen='$camisa', foto_perfil='$foto_perfil' WHERE id='$_POST[id]'";
		if (mysqli_query($conn, $sql)) {
			header("location: index.php");
			die();
		}
		 else {
			echo "Error: ". mysqli_error($conn);
		}
	}
}
else{
	$sql = "UPDATE jugador SET nombre='$_POST[nombre]', apellido='$_POST[apellido]', fecha_nacimiento='$_POST[fecha]', lugar_nacimiento='$_POST[lugar]', lanza='$_POST[lanza]', batea='$_POST[batea]', posicion='$_POST[posicion]' WHERE id='$_POST[id]'";
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

