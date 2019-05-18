<?php
include"../header.php";
?>
<br>
	<div class="container"><br>
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<div class="row justify-content-between">
						<div class="col-lg-3">
							<h3 class="text-center">New Video</h3>
						</div>
						<div class="col-xs-1 col-lg-1">
						</div>
					</div>
				</div>
				<form name="nuevoEquipo" id="nuevoEquipo" action="insert.php" method="post" enctype="multipart/form-data">
				<div class="card-body">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-3 form-group">
								<label for="nombre">Game</label>
								<select class="form-control" name="equipo" id="equipo" required>
									<option></option>
									<?php
									$sql = "SELECT lo1.id, lo1.nro_juego, lo2.nombre FROM calendario lo1 INNER JOIN equipo lo2 ON lo1.equipo=lo2.id where lo1.estado=1 ORDER BY lo1.nro_juego";
									$result = mysqli_query($conn, $sql);
									if (mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_assoc($result)) {
											echo "<option value=".$row['id'].">#".$row['nro_juego']." vs ".$row['nombre']."</option>";
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 form-group">
								<label for="jugador">Player</label>
								<select class="form-control" name="jugador" id="jugador"  required>
									<option></option>
									<?php
									$sql = "SELECT id, nombre, apellido, numero FROM jugador WHERE estado=1";
									$result = mysqli_query($conn, $sql);
									if (mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_assoc($result)) {
											echo "<option value=".$row['id'].">".$row['numero']." - ".$row['nombre']." ".$row['apellido']."</option>";
										}
									}
									?>
								</select>
							</div>
							<div class="col-lg-6 form-group">
								<label for="turno">Turn</label>
								<select class="form-control" name="turno" id="turno"  required>
									<option></option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 form-group">
								<label for="video">Insert Video</label>
								<input type="file" name="video" id="video" class="form-control" required>
							</div>
							<div class="col-lg-6 form-group">
								<label for="camara">Camera</label>
								<select class="form-control" name="camara" id="camara"  required>
									<option></option>
									<option value=1>VIP</option>
									<option value=2>Home Club</option>
									<option value=3>Visitor</option>
									<option value=4>Spray Shard</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-1 col-lg-1">
							   <button type="submit" class="btn btn-outline-primary">Save Video</button>               
							</div>
						</div>
					</div>
				</div>  
				</form> 
			</div>     
		</div>
	</div>
	<br>
	<br>
	<br>
	<script>
	let jugador = document.getElementById("jugador");
	let equipo = document.getElementById("equipo");

	jugador.addEventListener("change", function(){
		let xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("turno").innerHTML = xmlhttp.responseText;
			}
		};
		xmlhttp.open("GET", "opciones_turno.php?j="+ jugador.options[jugador.selectedIndex].value + "&c="+ equipo.options[equipo.selectedIndex].value, true);
		xmlhttp.send();
	});
	equipo.addEventListener("change", function(){
		let xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("jugador").innerHTML = xmlhttp.responseText;
			}
		};
		xmlhttp.open("GET", "opciones_jugador.php?c="+ equipo.options[equipo.selectedIndex].value, true);
		xmlhttp.send();
	});    
	</script>
<?php
include"../footer.php";
?>