<?php

//!GET page_id
if(!isset($page_id) || (isset($page_id) && $page_id == 0)) {
	$page_id = get_the_ID();
}


//<script type="text/javascript" src="'.getCurrentHOST().'/wp-includes/js/jquery/jquery.js?ver=1.7.1"></script>

$header = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de_DE">
<head>
<base href="'.getCurrentHOST().'" />
<title>'.getMetaTitle(array()).'</title>
<meta name="resource-type" content="document" />
<meta http-equiv="Content-Type" content="'.get_bloginfo('html_type').'" charset="UTF-8" />
<meta http-equiv="content-language" content="de_DE" />
<meta name="author" content="'.getOptionWord('meta_author').'" />
<meta name="copyright" content="'.getOptionWord('meta_copyright').'" />
<meta name="contact" content="'.getOptionWord('meta_contact').'" />
<meta name="email" content="'.getOptionWord('meta_email').'" />
<meta name="description" content="'.getMetaDescription(array()).'" />
<meta name="keywords" content="'.getMetaKeywords(array()).'" />
'.setMetaNoIndex().'
<meta name="viewport" content="width='.(getColumnWidth(array()) + 60).'">
<link rel="stylesheet" href="'.getStylesheetDirectoryURI().'/style.css?'.rand().'" />
<link rel="pingback" href="'.get_bloginfo('pingback_url').'" />
<link rel="canonical" href="'.getCurrentURL().'" />
'.setHeaderScripts(array()).'
</head>
<body class="'.setBodyClass().'">
	'.getFacebookBase().'
	<div id="header">
		<div id="header_inner" class="box relative">
			<div class="left header_inner relative">
				<div class="header_inner_object null">
					<a href="'.getCurrentHost().'" title=""><img src="'.getOptionFile("header_logo", "", "url").'"</a>
				</div>
			</div>
			<div class="right header_inner relative">
			    <div class="header_inner_object">
			    	'.createMenus(array(
			    		'menu' 		=> '01_Header',
			    		/* 'invert'	=> true, */
			    		'levels'	=> 1,
			    		'divider'	=> '<div class="left divider">|</div>',
			    	)).'
					'.clearer().'
				</div>
			</div>
			'.clearer().'
		</div>
	</div>
	'.createSubnav(array(
		'menu' 		=> '01_Header',
		/* 'invert'	=> true,		 */
	)).'
	<div id="content" class="content relative">
		<div id="content_inner" class="relative">
			'.createAdminGrid().'
			<div id="maincontent">
';


echo $header;

?>