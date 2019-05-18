<?php 
	include "../header.php";
	if (isset($_GET ['jugador'])) {
		$datos = $_GET ['jugador'];
		$sql = "SELECT `id`, `nombre`, `apellido` FROM `jugador`";
		$result = mysqli_query ($conn, $sql);
		$jugadores = array();
		if ($result) {
			while ($row = mysqli_fetch_assoc ($result)) {
				$jugadores [] = $row;
			}
		}
		$sugerencia = array();
		$sugerencia ['listaResultados'] = "";
		$sugerencia ['nroResultados'] = 0;
		if ($datos !== "") {
			$datos = strtolower($datos);
			$len = strlen ($datos);
			foreach ($jugadores as $jugador) {
				if (stristr($datos, substr ($jugador['nombre'], 0, $len)) || stristr($datos, substr ($jugador['apellido'], 0, $len))) {
					$detalles='<a href="detalles.php?id='.$jugador['id'].'" role="button">
					<button type="button" class="btn btn-warning">
					<i class="far fa-edit"></i>
					</button>
					</a>';
					$sugerencia ['listaResultados'] = $sugerencia ['listaResultados']."<tr>
					<td class='col-xs-2' id='acc'>".$jugador['id']."</td>
					<td class='col-xs-2' id='acc'>".$jugador['nombre']."</td>
					<td class='col-xs-2' id='acc'>".$jugador['apellido']."</td>
					<td class='col-xs-2' id='acc'>".$detalles."</td>
					</tr>";
					$sugerencia ['nroResultados']++;
				}
			}
		}
		echo json_encode($sugerencia);
	}
?>