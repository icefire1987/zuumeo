<?php

if(isset($_POST['cancel_cache'])) {
	$basepath = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
	include_once($basepath."/wp-config.php");
	
	$_SESSION['ajax_cache_creating'] = 1;
	
	echo 1;
}

?>