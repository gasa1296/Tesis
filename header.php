<?php 
include "../connection.php";
include "../sessionsheader.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>El Videoroom - Magallanes BBC</title>

	<link href="../vendor/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../vendor/fontawesome/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../vendor/main.css">

	<script src="../vendor/jquery.min.js"></script>
	<script src="../vendor/bootstrap.min.js"></script>
	<script type="text/javascript" src="../vendor/fontawesome/js/all.min.js"></script>
	<script src="../vendor/main.js"></script>
</head>
<header>
<!-- Navigation -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		 	<div class="container">
				<a class="navbar-brand" href="../inicio"><img src="../img/favicon.png" id="logo_sistema"> Videoroom</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
					</button>
				 	<div class="collapse navbar-collapse" id="navbarResponsive">
				 		<ul class="navbar-nav ml-auto">
						 		<li class="nav-item">
						 			<a class="nav-link" href="../inicio">Home
								 			<span class="sr-only">(current)</span>
								 		</a>
								 	</li>
									 <li class="nav-item"><a class="nav-link" href="../juego">Game Day</a></li>
										<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Mantenimiento
										</a>
										<div class="dropdown-menu" aria-labelledby="navbarDropdown">
											<a class="dropdown-item" href="../roster">Roster</a>
											<a class="dropdown-item" href="../calendario">Schedule</a>
											<a class="dropdown-item" href="../inicio/buscar.php">Search</a>
											<a class="dropdown-item" href="../equipos">Teams</a>
											<a class="dropdown-item" href="../users">Users</a>
										</div>
								</li>	               	
								<li class="nav-item"><a class="nav-link" href="../logout.php">Log Out</a></li>
							</ul>
				 	</div>
			</div>
	</nav>	
</header>