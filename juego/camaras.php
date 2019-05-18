<?php 
include "../header.php";
$id=@$_GET['id'];

$sql="UPDATE control SET juego_actual='$id'";

if (mysqli_query($conn, $sql)) {
} else {
	echo "Error updating record: " . mysqli_error($conn);
}
?></div>
<body><br>
<div class="container">
	<div class="row col-lg-12">
		<h1 class="text-center">Game Play</h1>	
	</div>
	<br><br><br>
	<div class="row">
		<div class="col-lg-3"></div>
		<div id="comenzar" class="col-lg-6">
			<button type="button" class="btn btn-success btn-lg btn-block" onclick="loadDoc()"><h1>Let the play Begins</h1></button>
		</div>
		<div class="col-lg-3"></div>
	</div>
	<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6"><a id="link" href="finish.php?id=<?php echo $id; ?>"><button type="button" class="btn btn-danger btn-lg btn-block"><h1>End Game</h1></button></a></div>
		<div class="col-lg-3"></div>
	</div>
</div>
</body></div>
<?php
include "../footer.php";
?>