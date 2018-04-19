<?php

/*
Template Name: Facebook
*/

$basepath = $_SERVER["DOCUMENT_ROOT"];
include($basepath."/wp-config.php");
include("page-includes.php");

$content = createPageModules(array());

include("header_facebook.php");
include("footer_facebook.php");

echo '
	'.$header.'
	<div style="width:'.getColumnWidth(array()).'px; margin: 0 auto;">
		'.$content.'
	</div>
	'.$footer.'
';


?>