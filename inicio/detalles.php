<?php
include "../header.php";

include "funcion_mes.php";
if (isset($_GET['id'])){
	$jugador = $_GET ['id'];
}
?>
<body>
	<br>
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col">
								<h4>Player's History</h4>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row justify-content-center">
							<div class="col">
								<?php 
									$id_temporada = array();
									$temporada_descripcion = array();
									$sql = "SELECT DISTINCT temporada.id, temporada.descripcion FROM video 
									INNER JOIN turnos ON video.id_turno = turnos.id 
									INNER JOIN calendario ON turnos.id_calendario=calendario.id 
									INNER JOIN temporada ON calendario.id_temporada=temporada.id 
									WHERE turnos.id_jugador=$jugador";
									$result = mysqli_query($conn, $sql);
									if(mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_assoc($result)){
											$id_temporada [] = $row ['id'];
											$temporada_descripcion [] = $row['descripcion'];
										}
									}
									echo '<div class="row justify-content-start"><div class="col">';

									for($i = 0; $i < count($id_temporada); $i++){
										echo '<div class="row"><div class="col"><p>Season '.$temporada_descripcion[$i].'</p></div></div>';

										$mes = array();
										$sql = "SELECT DISTINCT MONTH(calendario.fecha) as m FROM video 
										INNER JOIN turnos ON video.id_turno = turnos.id 
										INNER JOIN calendario ON turnos.id_calendario=calendario.id 
										WHERE calendario.id_temporada='$id_temporada[$i]' AND turnos.id_jugador=$jugador";
										$result = mysqli_query($conn, $sql);
										if(mysqli_num_rows($result) > 0){
											while($row = mysqli_fetch_assoc($result)){
												$mes [] = $row ['m'];
											}
										}
										$mes1 = $mes;
										for($n = 0; $n < count($mes); $n++){
											$mes1[$n] = mes($mes[$n]);
										}
										echo '<div class="row justify-content-start"><div class="col-lg-1"></div><div class="col">';
										for($m = 0; $m < count($mes); $m++){
											echo '<br><div class="row"><div class="col"><p>'.$mes1[$m].'</p></div></div>';

											$id_juego = array();
											$fecha = array();
											$equipo = array();
											$nro_juego = array();

											$sql = "SELECT DISTINCT calendario.id, calendario.fecha, calendario.nro_juego, equipo.nombre FROM video 
											INNER JOIN turnos ON video.id_turno = turnos.id 
											INNER JOIN calendario ON turnos.id_calendario=calendario.id 
											INNER JOIN equipo ON calendario.equipo=equipo.id 
											WHERE calendario.id_temporada='$id_temporada[$i]' AND MONTH(calendario.fecha)='$mes[$m]' AND turnos.id_jugador=$jugador";
											$result = mysqli_query($conn, $sql);
											if(mysqli_num_rows($result) > 0){
												while($row = mysqli_fetch_assoc($result)){
													$id_juego [] = $row ['id'];
													$fecha [] = $row ['fecha'];
													$equipo [] = $row ['nombre'];
													$nro_juego[] = $row ['nro_juego'];
												}
											}
											echo '<div class="row">';

											for($j = 0; $j < count($id_juego); $j++){
												echo '<div class="col-lg-3 border rounded"><p>'.$fecha[$j].' # '.$nro_juego[$j].' VS '.$equipo[$j].':</p>';

												echo '<div class="row justify-content-start">';

												$sql = "SELECT turnos.inning FROM video 
												INNER JOIN turnos ON video.id_turno = turnos.id  WHERE turnos.id_calendario='$id_juego[$j]' AND turnos.id_jugador=$jugador";
												$result = mysqli_query($conn, $sql);
												if(mysqli_num_rows($result) > 0){
													while($row = mysqli_fetch_assoc($result)){
														echo '<div class="col-lg-6"><p>Inning: '.$row["inning"].'</p></div>';
													}
												}
												echo '</div></div>';
											}
											echo '</div>';
										}
										echo '</div></div>';	
									}
									echo '</div></div>';
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<br>
	<br>
</body>
<?php
include "../footer.php";
?>