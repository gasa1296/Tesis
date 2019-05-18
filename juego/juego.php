<?php
include"../header.php";

$juego_id = $_GET['id'];
?>
<body>
	<br>
	<br>
	<div id="lista_juegos" class="container">
		<div class="row justify-content-center">
			<div class="card">
				<div class="card-header" id="headingOne">
					<h3 class="text-center">Game History</h3>
				</div>
				<div class="card-body">
					<table class="table table-fixed table-hover table-border table-responsive" >
						<thead>
							<tr id="tabla_encabezado_1">
								<th scope="col-xs-2">Player</th>
							</tr>
						</thead>
						<tbody id="tabla_1">
							<?php
							$sql="SELECT DISTINCT id_jugador FROM turnos WHERE id_calendario=$_GET[id]";  
							$result = mysqli_query($conn, $sql);
							if ($result){
								while($row = mysqli_fetch_assoc($result)) {
									echo"<tr>";
									$sql1="SELECT jugador.nombre, jugador.apellido, turnos.posicion, jugador.numero FROM video INNER JOIN turnos ON video.id_turno = turnos.id INNER JOIN jugador ON turnos.id_jugador=jugador.id WHERE turnos.id_jugador = $row[id_jugador] AND turnos.id_calendario=$_GET[id]";
									$result1 = mysqli_query($conn, $sql1);
									$row1 = mysqli_fetch_assoc($result1);
									echo"<td class='col-xs-2'>".$row1['numero']." - ".$row1['nombre']." ".$row1['apellido']."</td>";
									
									$sql2="SELECT * FROM video INNER JOIN turnos ON video.id_turno = turnos.id WHERE turnos.id_calendario=$_GET[id] AND turnos.id_jugador = $row[id_jugador]";
									$result2 = mysqli_query($conn, $sql2);
									if ($result2){
										while($row2 = mysqli_fetch_assoc($result2)) {
											echo"<td class='col-xs-2'> Inning: ".$row2['inning']."<br> Start: ".$row2['tiempo_inicio']."</td>";
										}
									}
									echo "</tr>";
								}
							}?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<br>
	</div>
	<br>
	<br>
	<br>
</body>
<?php
include"../footer.php";
?>