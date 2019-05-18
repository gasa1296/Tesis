<?php
include"../header.php";

$id=@$_GET['id'];

$sql = "SELECT * FROM calendario WHERE id='$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
}
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
							<h3 class="text-center">Edit Game</h3>
						</div>
						<div class="col-xs-1 col-lg-1">
						</div>
					</div>
				</div>
				<form name="nuevojuego" id="nuevojuego" action="update.php" method="post">
				<div class="card-body">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-3 form-group">
								<label for="nombre">Visiting Team</label>
								<select class="form-control" name="equipo" id="equipo">
									<option value="<?php echo $row['equipo'];?>"></option>
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
								<input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo $row['fecha'];?>">
							</div>
							<input type="text" name="id" id value="<?php echo $id; ?>" hidden>
						</div>
						<div class="row">
							<div class="col-lg-3 form-group">
								<label for="nombre">Season</label>
								<select class="form-control" name="temporada" id="temporada">
									<option value="<?php echo $row['id_temporada'];?>"></option>
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
								<input type="number" name="nro_juego" id="nro_juego" class="form-control" value="<?php echo $row['nro_juego'];?>">
							</div>
							<div class="col-lg-3 form-group">
								<label for="instancia_temporada">Season Instance</label>
								<select class="form-control" name="instancia_temporada" id="instancia_temporada">
									<option value="<?php echo $row['instancia_temporada'];?>"></option>
									<option value="R">Regular</option>
									<option value="PT">Post-Season</option> 
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-1 col-lg-1">
							   <button type="submit" class="btn btn-primary">Save Game</button>               
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
</body>
<?php
include"../footer.php";
?>