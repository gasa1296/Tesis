<?php 
include"../header.php";

include "funcion_mes.php";

?>
<body>
	<div class="container-fluid">
		<div class="row justify-content-start">
			<div class="col-lg-4" id="lista_videos">
				<?php
					$sql = "SELECT DISTINCT(temporada.id), temporada.descripcion FROM video 
					INNER JOIN turnos ON video.id_turno=turnos.id 
					INNER JOIN calendario ON turnos.id_calendario=calendario.id 
					INNER JOIN temporada ON calendario.id_temporada=temporada.id";
					$result = mysqli_query($conn, $sql);
					if($result){
						while($row = mysqli_fetch_assoc($result)){
							?>
							<div class="row">
								<div class="col-sm-1"></div>
								<div class="col-sm-11">
									<div class="row">
										<div class="col">
											<button class="btn btn-link text-white" data-toggle="collapse" href="#juegost<?php echo $row["id"];?>">
												Season <?php echo $row["descripcion"];?>
											</button>
										</div>
									</div>
									<div class="collapse" id="juegost<?php echo $row["id"];?>">
										<?php
											$sql1 = "SELECT DISTINCT MONTH(calendario.fecha) as m FROM video 
											INNER JOIN turnos ON video.id_turno=turnos.id 
											INNER JOIN calendario ON turnos.id_calendario=calendario.id 
											WHERE calendario.id_temporada=$row[id]";
											$result1 = mysqli_query($conn, $sql1);
											if($result1){
												while($row1 = mysqli_fetch_assoc($result1)){
													?>
													<div class="row">
														<div class="col-sm-1"></div>
														<div class="col-sm-11">
															<div class="row">
																<div class="col">
																	<button class="btn btn-link text-white" data-toggle="collapse" href="#juegost<?php echo $row["id"].'m'.$row1["m"];?>">
																		<?php echo mes($row1['m']);?>
																	</button>
																</div>
															</div>
															<div class="collapse" id="juegost<?php echo $row["id"].'m'.$row1["m"];?>">
																<?php
																	$sql2 = "SELECT DISTINCT calendario.id, calendario.fecha, calendario.nro_juego, equipo.nombre FROM video 
																	INNER JOIN turnos ON video.id_turno=turnos.id 
																	INNER JOIN calendario ON turnos.id_calendario=calendario.id 
																	INNER JOIN equipo ON calendario.equipo=equipo.id 
																	WHERE calendario.id_temporada=$row[id] AND MONTH(calendario.fecha)=$row1[m]";
																	$result2 = mysqli_query($conn, $sql2);
																	if($result2){
																		while($row2 = mysqli_fetch_assoc($result2)){
																			?>
																			<div class="row">
																				<div class="col-sm-1"></div>
																				<div class="col-sm-11">
																					<div class="row">
																						<div class="col">
																							<button class="btn btn-link text-white" data-toggle="collapse" href="#jugadorest<?php echo $row["id"].'m'.$row1["m"].'j'.$row2["id"];?>">
																								<?php echo $row2["fecha"].' # '.$row2["nro_juego"].' VS '.$row2["nombre"];?>
																							</button>
																						</div>
																					</div>
																					<div class="collapse" id="jugadorest<?php echo $row["id"].'m'.$row1["m"].'j'.$row2["id"];?>">
																						<?php
																							$sql3 = "SELECT DISTINCT jugador.id, jugador.nombre, jugador.apellido FROM video 
																							INNER JOIN turnos ON video.id_turno=turnos.id 
																							INNER JOIN calendario ON turnos.id_calendario=calendario.id 
																							INNER JOIN jugador ON turnos.id_jugador=jugador.id 
																							WHERE turnos.id_calendario=$row2[id]";
																							$result3 = mysqli_query($conn, $sql3);
																							if($result3){
																								while($row3 = mysqli_fetch_assoc($result3)){
																									?>
																									<div class="row">
																										<div class="col-sm-1"></div>
																										<div class="col-sm-11">
																											<div class="row">
																												<div class="col">
																													<button class="btn btn-link text-white" data-toggle="collapse" href="#turnost<?php echo $row["id"].'m'.$row1["m"].'j'.$row2["id"].'j'.$row3["id"];?>">
																														<?php echo $row3["nombre"].' '.$row3["apellido"]; ?>
																													</button>
																												</div>
																											</div>
																											<div class="collapse" id="turnost<?php echo $row["id"].'m'.$row1["m"].'j'.$row2["id"].'j'.$row3["id"];?>">
																												<?php
																												$sql4 = "SELECT video.direccion, turnos.inning, camaras.nombre FROM video
																												INNER JOIN turnos ON video.id_turno=turnos.id 
																												INNER JOIN camaras ON video.camara=camaras.id
																												WHERE turnos.id_calendario=$row2[id] AND turnos.id_jugador=$row3[id]";
																												$result4 = mysqli_query($conn, $sql4);
																												if($result4){
																													while($row4 = mysqli_fetch_assoc($result4)){
																														?>
																														<div class="col-lg-1"></div>
																														<div class="col-lg-11">
																															<input type="hidden" value="<?php echo $row2["nombre"];?>"><input type="hidden" value="<?php echo $row2["fecha"];?>"><input type="hidden" value="<?php echo $row4["inning"];?>"><input type="hidden" value="<?php echo $row4["nombre"];?>"><input type="hidden" value="<?php echo $row4["direccion"];?>"><button class="btn btn-link text-white" onclick="direct(this)">
																																Camera: <?php echo $row4["nombre"].' Inning: '.$row4["inning"];?>
																															</button>
																														</div>
																														<?php
																													}
																												}
																												?>
																											</div>
																										</div>
																									</div>
																									<?php
																								}
																							}
																						?>
																					</div>
																				</div>
																			</div>
																			<?php
																		}
																	}
																?>											
															</div>
														</div>
													</div>
													<?php
												}
											}
										?>
									</div>
								</div>
							</div>
							<?php
						}
					}
				?>
			</div>
			<div class="col-lg-8">
				<div class="row justify-content-center">
					<div class="col">
						<div class="card" id="panel-video">
							<div class="card-header">
								<div class="row justify-content-center">
									<div class="col">
										<h3 class="text-center" id="titulo"></h3>
									</div>
								</div>
							</div>
							<div class="card-body" id="cuerpo-carta">
								<div class="row justify-content-center align-self-center">
									<div class="col-lg-8 align-self-center" id="video">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.row -->
	</div>
</body>
<?php 
include "../footer.php";?>