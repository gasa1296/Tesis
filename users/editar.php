<?php
include"../header.php";

$id=@$_GET['id'];

$sql = "SELECT * FROM usuario WHERE id='$id'";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
}
?>
<body>
	<br>
	<!-- Page Content -->
	<div class="container">
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
							<h3 class="text-center">Edit User</h3>
						</div>
						<div class="col-xs-1 col-lg-1">
						</div>
					</div>
				</div>
				<form name="nuevousuario" id="nuevousuario" action="update.php" method="post">
				<div class="card-body">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-3 form-group">
								<label for="nombre">First Name</label>
								<input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $row['nombre'] ?>" required>
								<input type="text" name="id" value="<?php echo $id; ?>" hidden>
							</div>
							<div class="col-lg-3 form-group">
								<label for="apellido">Last Name</label>
								<input type="text" name="apellido" id="apellido" class="form-control" value="<?php echo $row['apellido']; ?>" required>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 form-group">
								<label for="correo">Email</label>
								<input type="email" name="correo" id="correo" class="form-control" value="<?php echo $row['correo']; ?>" required>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 form-group">
								<label for="pass1">Password</label>
								<input type="password" name="pass1" id="pass1" class="form-control" value="<?php echo $row['clave']; ?>" required>
							</div>
							<div class="col-lg-3 form-group">
								<label for="pass2">Repeat Password</label>
								<input type="password" name="pass2" id="pass2" class="form-control" value="<?php echo $row['clave']; ?>" required>
							</div>
							<div class="col-lg-3 form-group">
								<label for="pass2">Access</label>
								<select name="nivel" id="nivel" class="form-control">
									<option value=<?php echo $row["nivel"]; ?>></option>
									<option value=1>Admin</option>
									<option value=0>Player</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-1 col-lg-1">
							   <button type="submit" class="btn btn-primary">Save User</button>               
							</div>
						</div>
					</div>
				</div>	
				</form>	
			</div>     
		</div>
	</div><!-- /.container -->
	<br><br><br>
</body>
<script>
	let pass1 = document.getElementById("pass1");
	let pass2 = document.getElementById("pass2");
	pass1.addEventListener("focusout", function(){
		if(pass1.value != pass2.value && pass2.value != ""){
			alert("Ambas contraseñas deben ser iguales");
		}
	});
	pass2.addEventListener("focusout", function(){
		if(pass1.value != pass2.value && pass1.value != ""){
			alert("Ambas contraseñas deben ser iguales");
		}
	});
</script>
<?php
include"../footer.php";
?>