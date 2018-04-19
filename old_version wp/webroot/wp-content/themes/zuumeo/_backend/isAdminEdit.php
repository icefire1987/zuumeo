<?php

function isAdminEdit() {
	if(
		(
		is_admin() 
		&& 
		(isAdminPage("post") || isAdminPage("edit") || (isAdminPage("admin") && isset($_GET['page']) && $_GET['page'] == "acf-options-seiten"))
		) 
	|| 
		(
		!is_admin() 
		&& 
		isAdmin() 
		&& 
		isset($_POST['ajax'])
		)
	) {
		return true;
		
	} else {
		return false;
	}
}