<?php

function isSuperAdmin() {
	if(is_user_logged_in()) {
		global $current_user;
		
		if(isset($current_user->caps['administrator']) && $current_user->caps['administrator'] == 1) {
			return true;
			
		} else {
			return false;
		}
	
	} else {
		return false;
	}
}

?>