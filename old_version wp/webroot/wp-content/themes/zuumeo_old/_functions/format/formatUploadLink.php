<?php

function formatUploadLink($link) {
	$uploads = wp_upload_dir();
	
	$link = str_replace("[upload_url]", $uploads['baseurl'], $link);
	
	return $link;
}

?>