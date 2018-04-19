<?php

if(isset($_POST['empty_directory'])) {
	$basepath = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
	include_once($basepath."/wp-config.php");
	
	if(is_user_logged_in()) {
		//removeDirectory("asddadsa");
		
		//!return to javascript
		echo '|||';
	}
}

?>