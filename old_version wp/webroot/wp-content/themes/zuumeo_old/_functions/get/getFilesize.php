<?php

function getFilesize($id) {
	if(is_numeric($id)) {
		$fileinfo = wp_get_attachment_image_src($id, 'full');
		$path = str_replace(site_url(), $_SERVER["DOCUMENT_ROOT"], $fileinfo[0]);
	
	} else {
		$path = $id;
	}
	
	$return = number_format((filesize($path)/1024)/1024, 2, ",", ".").' MB';
	
	return $return;
}

?>