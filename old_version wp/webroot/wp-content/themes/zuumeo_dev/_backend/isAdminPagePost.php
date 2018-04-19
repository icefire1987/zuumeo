<?php

function isAdminPage($page = "") {
	if(is_admin() && $page != "") {
		global $pagenow;
		
		//echo('<br>'.$page.'_'.$pagenow);
		
		if($page.'.php' == $pagenow) {
			return true;
		
		} else {
			return false;
		}
		
	} else {
		return false;
	}
}