<?php
include"../header.php";

$sql = "SELECT * FROM jugador WHERE id=$_GET[id]";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<body>
<div class="container">
	<div class="card border-secondary">
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
					<h3 class="text-center">Edit Player</h3>
				</div>
				<div class="col-xs-1 col-lg-1">
				</div>
			</div>
		</div> 
		<div class="card-body">
		<form name="nuevo_jugador" id="nuevo_jugador" action="update.php" enctype="multipart/form-data" method="post">
			<div class="row">
				<div class="col-lg-4 form-group">
					<input type="hidden" name="id" value=<?php echo $_GET['id'];?>>
					<label for="nombre">First Name</label>
					<input class="form-control" id="nombre" name="nombre" placeholder="First Name" value="<?php echo $row["nombre"]; ?>" required>
				</div>
				<div class="col-lg-4 form-group">
					<label for="apellido">Last Name</label>
					<input class="form-control" id="apellido" name="apellido" placeholder="Last Name" value="<?php echo $row["apellido"]; ?>" required>
				</div>
				<div class="col-lg-4 form-group">
					<label for="numero">Number</label>
					<input type="number" class="form-control" name="numero" id="numero" value="<?php echo $row["numero"]; ?>"required>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 form-group">
					<label for="camisa">Image's Number</label><br>
					<input type="file" name="camisa" id="camisa" placeholder="Camisa" required>
				</div>
				<div class="col-lg-6 form-group">
                    <label for="foto_perfil">Player's Photo</label><br>
                    <input type="file" name="foto_perfil" id="foto_perfil" required>
                </div>
			</div>
			<div class="row">
				<div class="col-lg-3 form-group">
					<label for="fecha">Birth Date</label>
					<input type="date" class="form-control" id="fecha" name="fecha" placeholder="Birth Date" min="1975-01-01" max="2018-01-01" value="<?php echo $row["fecha_nacimiento"]; ?>" required>
				</div>
				<div class="col-lg-4 form-group">
					<label for="lugar">Birth place</label>
					<input type="text" class="form-control" id="lugar" name="lugar" placeholder="Birth place" value="<?php echo $row["lugar_nacimiento"]; ?>"required>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 form-group">
					<label for="posicion">Posición</label>
					<select class="form-control" id="posicion" name="posicion" required>
						<option value="<?php echo $row["posicion"]; ?>" selected>Select</option>
						<option value="P">Pitcher</option>
						<option value="C">Catcher</option>
						<option value="IF">Infielder</option>
						<option value="OF">Outfielder</option>
					</select>
				</div>
				<div class="col-lg-4 form-group">
					<label for="lanza">Lanza</label>
					<select class="form-control" name="lanza" id="lanza" required>
						<option value="<?php echo $row["lanza"]; ?>" selected>Select</option>
						<option value="D">Right</option>
						<option value="Z">Left</option>
						<option value="A">Ambidextrous</option>   
					</select>
				</div>
				<div class="col-lg-4 form-group">
					<label for="batea">Batea</label>
					<select class="form-control" name="batea" id="batea" required>
						<option value="<?php echo $row["batea"]; ?>" selected>Select</option>
						<option value="D">Right</option>
						<option value="Z">Left</option>
						<option value="A">Ambidextrous</option>   
					</select>  
				</div>
			</div>
			<div class="row">
				<div class="col-xs-1 col-lg-1">
				   <button type="submit" class="btn btn-primary">Edit Player</button>               
				</div>
			</div>
		</form>
		</div>
	</div>
</div>
</body>
<?php

include"../footer.php";

?>