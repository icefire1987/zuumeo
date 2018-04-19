<?php

function getJSScripts() {
	$return = '';
	foreach(glob(get_stylesheet_directory().'/_javascript/*.js') AS $file) {
		$return .= '<script type="text/javascript" src="'.get_stylesheet_directory_uri().''.str_replace(get_stylesheet_directory(), "", $file).'"></script>
		';
	}
	
	return $return;
}

?>