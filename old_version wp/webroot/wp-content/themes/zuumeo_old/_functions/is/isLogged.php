<?php

function isLogged() {
	if(is_user_logged_in()) {
		return true;
	}
}

?>