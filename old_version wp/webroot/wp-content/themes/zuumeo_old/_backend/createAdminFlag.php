<?php

function createAdminFlag($lang) {
	$return = '<img src="'.get_stylesheet_directory_uri().'/_backend/_images/_flags/'.$lang.'.png" style="margin: 0px 7px 0px 0px; font-size: 0px;" />';
	
	return $return;
}