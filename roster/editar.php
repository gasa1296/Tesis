<?php
include"../header.php";

$sql = "SELECT * FROM jugador WHERE id=$_GET[id]";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<br>
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
				<div class="col-lg-3 form-group">
					<input type="hidden" name="id" value=<?php echo $_GET['id'];?>>
					<label for="nombre">First Name</label>
					<input class="form-control" id="nombre" name="nombre" placeholder="First Name" pattern="[A-Za-z]{2,10}" title="Solo letras. De 2 a 10 caracteres" value="<?php echo $row["nombre"]; ?>">
				</div>
				<div class="col-lg-3 form-group">
					<label for="apellido">Last Name</label>
					<input class="form-control" id="apellido" name="apellido" placeholder="Last Name" pattern="[A-Za-z]{2,10}" title="Solo letras. De 2 a 10 caracteres" value="<?php echo $row["apellido"]; ?>">
				</div>
				<div class="col-lg-6 form-group">
                    <label for="foto_perfil">Player's Photo</label><br>
                    <input type="file" name="foto_perfil" id="foto_perfil">
                </div>
			</div>
			<div class="row">
			</div>
			<div class="row">
				<div class="col-lg-3 form-group">
					<label for="fecha">Birth Date</label>
					<input type="date" class="form-control" id="fecha" name="fecha" placeholder="Birth Date" min="1975-01-01" max="2018-01-01" value="<?php echo $row["fecha_nacimiento"]; ?>">
				</div>
				<div class="col-lg-3 form-group">
					<label for="lugar">Birth place</label>
					<input type="text" class="form-control" id="lugar" name="lugar" placeholder="Birth place" minlength="5" maxlength="20" value="<?php echo $row["lugar_nacimiento"]; ?>">
				</div>
				<div class="col-lg-6 form-group">
					<label for="camisa">Image's Number</label><br>
					<input type="file" name="camisa" id="camisa" placeholder="Camisa">
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3 form-group">
					<label for="numero">Number</label>
					<input type="number" class="form-control" name="numero" id="numero" value="<?php echo $row["numero"]; ?>"required>
				</div>
				<div class="col-lg-3 form-group">
					<label for="posicion">Posición</label>
					<select class="form-control" id="posicion" name="posicion">
						<option value="P" <?php if($row['posicion']=='P'){echo'selected';} ?>>Pitcher</option>
						<option value="C" <?php if($row['posicion']=='C'){echo'selected';} ?>>Catcher</option>
						<option value="IF" <?php if($row['posicion']=='IF'){echo'selected';} ?>>Infielder</option>
						<option value="OF" <?php if($row['posicion']=='OF'){echo'selected';} ?>>Outfielder</option>
					</select>
				</div>
				<div class="col-lg-3 form-group">
					<label for="lanza">Lanza</label>
					<select class="form-control" name="lanza" id="lanza">
						<option value="D" <?php if($row['lanza']=='D'){echo'selected';} ?>>Right</option>
						<option value="Z" <?php if($row['lanza']=='Z'){echo'selected';} ?>>Left</option>
						<option value="A" <?php if($row['lanza']=='A'){echo'selected';} ?>>Ambidextrous</option>   
					</select>
				</div>
				<div class="col-lg-3 form-group">
					<label for="batea">Batea</label>
					<select class="form-control" name="batea" id="batea">
						<option value="D" <?php if($row['batea']=='D'){echo'selected';} ?>>Right</option>
						<option value="Z" <?php if($row['batea']=='Z'){echo'selected';} ?>>Left</option>
						<option value="A" <?php if($row['batea']=='A'){echo'selected';} ?>>Ambidextrous</option>   
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