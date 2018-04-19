<?php

function getStylesheetDirectoryURI(){
	$return = formatDomain(get_stylesheet_directory_uri());
	
	return $return;
}

?>