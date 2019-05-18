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
							<!--ver por equipos -->
							<div class="col-lg-2">
							</div>
							<!--titulo-->
							<div class="col-lg-5">
								<h3 class="text-center">Game List</h3>
							</div>
							<!--nuevo juego-->
							<div class="col-lg-2">
								<div class="submenu">
									<a href="nuevo.php" >
										<button type="button" class="btn btn-success">
											<i class="fas fa-plus"></i> New Game
										</button>
									</a>						
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-wrapper-scroll-y">
							<table class="table table-hover table-border">
								<thead>
									<tr>
										<th scope="col-xs-2">#</th>
										<th scope="col-xs-2">Vs</th>
										<th scope="col-xs-2">Date</th>
										<th scope="col-xs-2">Season</th>
										<th scope="col-xs-2">Instance</th>
										<th scope="col-xs-2">Status</th>
										<th scope="col-xs-2">Options</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sql = "SELECT lo1.id, lo1.nro_juego, lo2.nombre, lo1.fecha, lo1.id_temporada, lo1.instancia_temporada, lo1.estado FROM calendario lo1 INNER JOIN equipo lo2 ON lo1.equipo=lo2.id where lo1.estado=0 AND lo1.id_temporada=1 ORDER BY lo1.id";
									$result = mysqli_query($conn, $sql);
									if (mysqli_num_rows($result) > 0){
										while($row = mysqli_fetch_assoc($result)) {
											$modificar='<a href="editar.php?id='.$row['id'].'"  role="button">
												<button type="button" class="btn btn-warning">
													<i class="far fa-edit"></i>
												</button>
											</a>';
											$eliminar='<a href="#confirmacion' . $row['id'] . '"  role="button" data-toggle="modal">
												<button type="button" class="btn btn-danger">
													<i class="fas fa-ban"></i>
												</button>
											</a>';
											echo"<tr>           
													<td class='col-xs-2' id='acc'>".$row['nro_juego']."</td>
													<td class='col-xs-2' id='acc'>".$row['nombre']."</td> 
													<td class='col-xs-2' id='acc'>".$row['fecha']."</td>
													<td class='col-xs-2' id='acc'>".$row['id_temporada']."</td>
													<td class='col-xs-2' id='acc'>".$row['instancia_temporada']."</td>";
											if($row['estado'] == 0){
												echo "<td class='col-xs-2' id='acc'>Pendig</td>";
											}
											else{
												echo "<td class='col-xs-2' id='acc'>Accomplished</td>";
											}
											echo "<td class='col-xs-2' id='acc'>".$modificar."  ".$eliminar."</td></tr>";

											echo'<div class="modal fade" id="confirmacion' . $row['id'] . '">
													<div class="modal-dialog">
														<div class="modal-content">
															<!--Header del Modal-->
															<div class="modal-header">
																<h3>Cancel Game</h3>
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															</div>
															<!--Body del Modal-->
															<div class="modal-body">
																<h3 class="text-center">Are you sure?</h3>
															</div>
															<div class="modal-footer">
															<form action="cancel.php?id=' . $row['id'] . '">
																<div class="form-group">
																	<input type="text" name="id" id value="'.$row['id'].'" hidden>
																	<button type="submit" class="btn btn-danger">Yes</button>
																	<button type="button" class="btn btn-light" class="close" data-dismiss="modal" aria-hidden="true">No</button>
																</div>
															</form>
															</div>
														</div>
													</div>
												</div>';
										}
									} else {
										echo "<td>0 result</td>";
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
	<br>
</body>
<?php
include"../footer.php";
?>