<?php
include"../header.php";
?>
<body>
	<div class="container"><br>
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<div class="row justify-content-between">
						<div class="col-xs-1 col-lg-1">
							<a href="index.php">
								<button type="button"  class="btn btn-warning" formnovalidate>
									<i class="fas fa-home"></i> Start
								</button>
							</a>
						</div>
						<div class="col-lg-3">
							<h3 class="text-center">New Game</h3>
						</div>
						<div class="col-xs-1 col-lg-1">
						</div>
					</div>
				</div>
				<form name="nuevoEquipo" id="nuevoEquipo" action="insert.php" method="post">
				<div class="card-body">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-3 form-group">
								<label for="nombre">Visiting Team</label>
								<select class="form-control" name="equipo" id="equipo" required>
									<option></option>
									<?php
									$sql1 = "SELECT id, nombre FROM equipo where estado=1";
									$result1 = mysqli_query($conn, $sql1);
									if (mysqli_num_rows($result1) > 0){
										while($row1 = mysqli_fetch_assoc($result1)) {
											echo"<option value=".$row1['id'].">".$row1['nombre']."</option>";
										}
									}
									?>
								</select>
							</div>
							<div class="col-lg-3 form-group">
								<label for="fecha">Game Date</label>
								<input type="date" name="fecha" id="fecha" class="form-control" min="2017-01-01" required>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 form-group">
								<label for="nombre">Season</label>
								<select class="form-control" name="temporada" id="temporada">
									<option></option>
									<?php
									$sql1 = "SELECT id, descripcion FROM temporada";
									$result1 = mysqli_query($conn, $sql1);
									if (mysqli_num_rows($result1) > 0){
										while($row1 = mysqli_fetch_assoc($result1)) {
											echo"<option value=".$row1['id'].">".$row1['descripcion']."</option>";
										}
									}
									?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 form-group">
								<label for="nro_juego">Game Number</label>
								<input type="number" name="nro_juego" id="nro_juego" class="form-control" required>
							</div>
							<div class="col-lg-3 form-group">
								<label for="instancia_temporada">Season Instance</label>
								<select class="form-control" name="instancia_temporada" id="instancia_temporada" required>
									<option></option>
									<option value="R">Regular</option>
									<option value="PT">Post-Season</option> 
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-1 col-lg-1">
							   <button type="submit" class="btn btn-primary">Add Game</button>               
							</div>
						</div>
					</div>
				</div>	
				</form>	
			</div>     
		</div>
		<br><br><br>
	</div>
</body>
<?php
include"../footer.php";
?>