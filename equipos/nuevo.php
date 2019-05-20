<?php
include"../header.php";
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
							<h3 class="text-center">New Team</h3>
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
								<label for="nombre">Team Name</label>
								<input type="text" name="nombre" id="nombre" class="form-control" pattern="[A-Za-z- ]{5,20}" title="Solo letras y espacios. De 5 a 20 caracteres" required >
							</div>
							<div class="col-lg-3 form-group">
								<label for="alias">Team Alias</label>
								<input type="text" name="alias" id="alias" class="form-control" pattern="[A-Za-z- ]{3,10}" title="Solo letras y espacios. De 3 a 10 caracteres" required>
							</div>
						</div>
						</div>
						<div class="row">
							<div class="col-xs-1 col-lg-1">
							   <button type="submit" class="btn btn-primary">Save Team</button>               
							</div>
						</div>
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