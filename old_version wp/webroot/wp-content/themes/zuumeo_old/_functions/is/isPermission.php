<?php

function isPermission() {
	unset($_SESSION['permission']);
	
	if(isset($_POST['permission']) || isset($_SESSION['permission'])) {
		return true;
		
	} else {
		return false;
	}
}

?>