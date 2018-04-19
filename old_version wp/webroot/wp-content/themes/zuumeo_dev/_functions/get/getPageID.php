<?php

function getPageID() {
	if(isAdmin() && isset($_POST['post_id'])) {
		$page_id = $_POST['post_id'];
	
	} else {
		global $page_id;
	}
	
	return $page_id;
}