<?php 
function mes($numeroMes){
	switch ($numeroMes){
		case 1:
			$numeroMes = "January";
			break;
		case 2:
			$numeroMes = "February";
			break;
		case 3:
			$numeroMes = "March";
			break;
		case 4:
			$numeroMes = "April";
			break;
		case 5:
			$numeroMes = "May";
			break;
		case 6:
			$numeroMes = "June";
			break;
		case 7:
			$numeroMes = "July";
			break;
		case 8:
			$numeroMes = "August";
			break;
		case 9:
			$numeroMes = "September";
			break;
		case 10:
			$numeroMes = "October";
			break;
		case 11:
			$numeroMes = "November";
			break;
		default:
			$numeroMes = "December";
			break;
	}
	return $numeroMes;
}
?>