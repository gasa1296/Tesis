<?php

include"../header.php";

?>
<body>
<br>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="card" id="lista">
					<div class="card-header">
						<div class="row justify-content-between">
							<div class="col-lg-2">
							</div>
							<div class="col-lg-5">
								<h3 class="text-center">Player List</h3>
							</div>
							<div class="col-lg-2">
								<div class="submenu">
									<a href="nuevo.php" >
										<button type="button" class="btn btn-success">
											<i class="fas fa-plus"></i> New Players
										</button>
									</a>						
								</div>
							</div>
						</div>
						<div class="row justify-content-between">
							<div class="col">
								<ul class="nav nav-tabs card-header-tabs pull-right"  id="myTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="pitchers-tab" data-toggle="tab" href="#pitchers" role="tab" aria-controls="pitchers" aria-selected="true">Pitchers</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="catchers-tab" data-toggle="tab" href="#catchers" role="tab" aria-controls="catchers" aria-selected="false">Catchers</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="infielders-tab" data-toggle="tab" href="#infielders" role="tab" aria-controls="infielders" aria-selected="false">Infielders</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="outfielders-tab" data-toggle="tab" href="#outfielders" role="tab" aria-controls="outfielders" aria-selected="false">Outfielders</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="card-body" id="lista_jugadores">	
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="pitchers" role="tabpanel" aria-labelledby="pitchers-tab">	
								<table class="table table-hover table-border">
									<thead>
										<tr>
											<th class="col-xs-1"> First Name </th>
											<th class="col-xs-1"> Last Name </th>
											<th class="col-xs-1"> Number </th>
											<th class="col-xs-1"> Bat </th>
											<th class="col-xs-1"> Throw </th>
											<th class="col-xs-1"> Birth Date </th>
											<th class="col-xs-1"> Status </th>
											<th class="col-xs-1"> Option</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql = "SELECT * FROM jugador WHERE posicion ='P' AND estado=1";
											$result = mysqli_query($conn, $sql);
											if ($result && mysqli_num_rows($result) > 0) {
												while($row = mysqli_fetch_assoc($result)) {
													$modificar='<a href="editar.php?id='.$row['id'].'" role="button"><button type="button" class="btn btn-warning"><i class="far fa-edit"></i></button></a>';
													echo"<tr><td class='col-xs-1'>".$row['nombre']."</td><td class='col-xs-1'>".$row['apellido']."</td><td class='col-xs-1'>".$row['numero']."</td><td class='col-xs-1'>".$row['batea']."</td><td class='col-xs-1'>".$row['lanza']."</td><td class='col-xs-1'>".$row['fecha_nacimiento']."</td><td class='col-xs-1'>".$row['estado']."</td><td class='col-xs-1'>".$modificar."</td><td class='col-xs-1'><a class='btn ".colorBoton($row['R32'])."' role='button' href='r32.php?id=".$row['id']."'><b>R</b>32</a></td></tr>";
												}
											} else {
												echo "<tr>0 results</tr>";
											}
										?>
									</tbody>
								</table> 
							</div>
							<div class="tab-pane fade" id="catchers" role="tabpanel" aria-labelledby="catchers-tab">
								<table class="table table-hover table-border">
									<thead>
										<tr>
											<th class="col-xs-1"> First Name </th>
											<th class="col-xs-1"> Last Name </th>
											<th class="col-xs-1"> Number </th>
											<th class="col-xs-1"> Bat </th>
											<th class="col-xs-1"> Throw </th>
											<th class="col-xs-1"> Birth Date </th>
											<th class="col-xs-1"> Status </th>
											<th class="col-xs-1"> Option</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql = "SELECT * FROM jugador WHERE posicion ='C' AND estado=1";
											$result = mysqli_query($conn, $sql);
											$result = mysqli_query($conn, $sql);
											if ($result && mysqli_num_rows($result) > 0) {
												while($row = mysqli_fetch_assoc($result)) {
													$modificar='<a href="editar.php?id='.$row['id'].'" role="button"><button type="button" class="btn btn-warning"><i class="far fa-edit"></i></button></a>';
													echo"<tr><td class='col-xs-1'>".$row['nombre']."</td><td class='col-xs-1'>".$row['apellido']."</td><td class='col-xs-1'>".$row['numero']."</td><td class='col-xs-1'>".$row['batea']."</td><td class='col-xs-1'>".$row['lanza']."</td><td class='col-xs-1'>".$row['fecha_nacimiento']."</td><td class='col-xs-1'>".$row['estado']."</td><td class='col-xs-1'>".$modificar."</td><td class='col-xs-1'><a class='btn ".colorBoton($row['R32'])."' role='button' href='r32.php?id=".$row['id']."'><b>R</b>32</a></td></tr>";
												}
											} else {
												echo "<tr>0 results</tr>";
											}
										?>
									</tbody>
								</table>
							</div>
							<div class="tab-pane fade" id="infielders" role="tabpanel" aria-labelledby="infielders-tab">
								<table class="table table-hover table-border">
									<thead>
										<tr>
											<th class="col-xs-1"> First Name </th>
											<th class="col-xs-1"> Last Name </th>
											<th class="col-xs-1"> Number </th>
											<th class="col-xs-1"> Bat </th>
											<th class="col-xs-1"> Throw </th>
											<th class="col-xs-1"> Birth Date </th>
											<th class="col-xs-1"> Status </th>
											<th class="col-xs-1"> Option</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql = "SELECT * FROM jugador WHERE posicion ='IF' AND estado=1";
											$result = mysqli_query($conn, $sql);
											if ($result && mysqli_num_rows($result) > 0) {
												while($row = mysqli_fetch_assoc($result)) {
													$modificar='<a href="editar.php?id='.$row['id'].'" role="button"><button type="button" class="btn btn-warning"><i class="far fa-edit"></i></button></a>';
													echo"<tr><td class='col-xs-1'>".$row['nombre']."</td><td class='col-xs-1'>".$row['apellido']."</td><td class='col-xs-1'>".$row['numero']."</td><td class='col-xs-1'>".$row['batea']."</td><td class='col-xs-1'>".$row['lanza']."</td><td class='col-xs-1'>".$row['fecha_nacimiento']."</td><td class='col-xs-1'>".$row['estado']."</td><td class='col-xs-1'>".$modificar."</td><td class='col-xs-1'><a class='btn ".colorBoton($row['R32'])."' role='button' href='r32.php?id=".$row['id']."'><b>R</b>32</a></td></tr>";
												}
											} else {
												echo "<tr>0 results</tr>";
											}
										?>
									</tbody>
								</table>
							</div>
							<div class="tab-pane fade" id="outfielders" role="tabpanel" aria-labelledby="outfielders-tab">
								<table class="table table-hover table-border">
									<thead>
										<tr>
											<th class="col-xs-1"> First Name </th>
											<th class="col-xs-1"> Last Name </th>
											<th class="col-xs-1"> Number </th>
											<th class="col-xs-1"> Bat </th>
											<th class="col-xs-1"> Throw </th>
											<th class="col-xs-1"> Birth Date </th>
											<th class="col-xs-1"> Status </th>
											<th class="col-xs-1"> Option</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql = "SELECT * FROM jugador WHERE posicion ='OF' AND estado=1";
											$result = mysqli_query($conn, $sql);
											if ($result && mysqli_num_rows($result) > 0) {
												while($row = mysqli_fetch_assoc($result)) {
													$modificar='<a href="editar.php?id='.$row['id'].'" role="button"><button type="button" class="btn btn-warning"><i class="far fa-edit"></i></button></a>';
													echo"<tr><td class='col-xs-1'>".$row['nombre']."</td><td class='col-xs-1'>".$row['apellido']."</td><td class='col-xs-1'>".$row['numero']."</td><td class='col-xs-1'>".$row['batea']."</td><td class='col-xs-1'>".$row['lanza']."</td><td class='col-xs-1'>".$row['fecha_nacimiento']."</td><td class='col-xs-1'>".$row['estado']."</td><td class='col-xs-1'>".$modificar."</td><td class='col-xs-1'><a class='btn ".colorBoton($row['R32'])."' role='button' href='r32.php?id=".$row['id']."'><b>R</b>32</a></td></tr>";
												}
											} else {
												echo "<tr>0 results</tr>";
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<?php
include"../footer.php";

function nombreestado($estado){
	switch ($estado) {
	case 0:
		$estado='Inactivo';
		break;
	case 1:
		$estado='Activo';
	}
	return $estado;
}
function colorBoton($R32){
	if ($R32==1){
		$color='btn-success';
	}else{
		$color='btn-light';
	}
	return $color;
}
?>