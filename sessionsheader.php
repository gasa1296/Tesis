<?php
session_start();
if($_SESSION['currentuserx']!=1){
	header("Location:../index.php?status=error&msg=Usted debe iniciar sesion primero");
}?>