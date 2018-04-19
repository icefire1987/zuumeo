<?php

add_action('login_form', 'setRedirectAfterLogin');
function setRedirectAfterLogin() {
	 global $redirect_to;
	 if (!isset($_GET['redirect_to'])) {
		  $redirect_to = '/wp-admin/index.php';
	 }
}

?>