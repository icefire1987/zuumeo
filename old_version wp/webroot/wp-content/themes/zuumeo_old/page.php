<?php

$cached_page = getCachedPage();

if($cached_page) {
	echo $cached_page;
	
} else {
	include('page-id.php');
	
	$all_menus = getAllMenus(array());
	$all_image_sizes = getAllImageSources(array());
	
	include('page-includes.php');
	
	$content = createPageModules(array());
	
	$final_content = '
		'.$header.'
		'.$content.'
		'.clearer().'
		'.$footer.'
	';
	
	$final_content = enkode_plaintext_emails($final_content);
	
	echo $final_content;
	
	cachePage($final_content);
}

?>