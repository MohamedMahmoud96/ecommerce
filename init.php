<?php


	ini_set('display_error', 'On');
	error_reporting(E_ALL);

	include "admin/connect.php";
	$sessionUser ="";
	if(isset($_SESSION['user'])){

		$sessionUser = $_SESSION['user'];
		$sessionID	 =$_SESSION['memberID'];
	}
	
	$css = 'layout/css/';
	$js = 'layout/js/';
	$tpl = "includes/Templates/";	
	$eng = "includes/languages/";
	$func ="includes/functions/";

	
	
	// include important files
	include $eng . "english.php";
	include $func . "function.inc";
	include $tpl . "header.php";

?>
	
	
	
	 


	
	