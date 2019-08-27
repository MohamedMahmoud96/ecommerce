<?php
	include "connect.php";
	include	"includes/functions/function.inc";

	//Scripts
	$css = pathUrl() .'/admin/layout/css/';
	$js  = pathUrl() . '/admin/layout/js/';
	// handel files
	$tpl  = pathFolder() . "/admin/includes/Templates/";	
	$lang = pathFolder() . "/admin/includes/languages/";

	// include important files
	include $lang . "english.php";
	
	if(!isset($noheader)){include $tpl. "header.inc";}
	if(!isset($noNavbar)){include $tpl. 'nav&slid.inc';}
	
	

	
	
	
	 


	
	