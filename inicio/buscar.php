<?php 
include"../header.php";
?>
<body>
	<br>
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col">
								<h4>Search</h4>
							</div>
							<div class="col">
								<form class="form-inline my-2 my-lg-0">
									<input class="form-control mr-sm-2" id="busqueda" type="search" placeholder="Buscar" aria-label="Search" onkeyup="buscar();">
								</form>
								<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
									<span class="navbar-toggler-icon"></span>
								</button>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="row justify-content-center">
							<div class="col">
								<table class="table">
									<thead>
										<tr>
											<th scope="col-xs-2">id</th>
											<th scope="col-xs-2">First Name</th>
											<th scope="col-xs-2">Last Name</th>
											<th scope="col-xs-2">Options</th>
										</tr>
									</thead>
									<tbody id="lista_jugadores">
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row justify-content-center">
							<div class="col-lg-2">
								<p id="nro_resultados"></p>
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
include"../footer.php";
?>