<?php
include"../header.php";
?>
<body>
	<br>
	<div class="container">
		<div class="row justify-content-end">
			<div class="col">
				<h1 class="text-center">Games</h1>
			</div>
		</div>
		<div class="row justify-content-around">
			<div class="col-lg-5">
				<div class="list-group" id="lista">
					<h3 class="text-center list-group-item list-group-item-dark">Pending Games</h3>
					<?php
						$temporada_actual;
						$sql ="SELECT `temporada_actual` FROM `control`";
						$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
						$temporada_actual = $row['temporada_actual'];
						$sql = "SELECT calendario.id, calendario.nro_juego, equipo.nombre, calendario.fecha FROM calendario INNER JOIN equipo ON calendario.equipo=equipo.id where calendario.estado=0 AND calendario.id_temporada='$temporada_actual' ORDER BY calendario.id";
						$result = mysqli_query($conn, $sql);
						if (mysqli_num_rows($result) > 0){
							while($row = mysqli_fetch_assoc($result)) {
								echo"<a href='camaras.php?id=" .$row['id']."' class='list-group-item list-group-item-action '>Game: ".$row['nro_juego']." Vs. ".$row['nombre']." Date: ".$row['fecha']."</a>";
							}
						}else{
							echo "<a class='list-group-item list-group-item-action'>0 results</a>";
						}
					?>
				</div>
			</div>
			<div class="col-lg-5">
				<div class="list-group" id="lista">
					<h3 class="text-center list-group-item list-group-item-dark">Finished Games</h3>
					<?php
						$sql = "SELECT calendario.id, calendario.nro_juego, equipo.nombre, calendario.fecha FROM calendario INNER JOIN equipo ON calendario.equipo=equipo.id where calendario.estado=1 AND calendario.id_temporada='$temporada_actual' ORDER BY calendario.id";
						$result = mysqli_query($conn, $sql);
						if (mysqli_num_rows($result) > 0){
							while($row = mysqli_fetch_assoc($result)) {
								echo"<a href='juego.php?id=" .$row['id']."' class='list-group-item list-group-item-action '>Game: ".$row['nro_juego']." Vs. ".$row['nombre']." Date: ".$row['fecha']."</a>";
							}
						}
						else{
							echo "<a class='list-group-item list-group-item-action'>0 results</a>";
						}
					?>
				</div>
			</div>              
		</div>
	</div>
	<br>
	<br>
	<br>
	<br>
</body>
<?php
include"../footer.php";
?>