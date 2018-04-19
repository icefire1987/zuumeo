<?php

$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<base href="'.getCurrentHOST().'" />
<title>'.getMetaTitle(array()).'</title>
<meta name="resource-type" content="document" />
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<meta http-equiv="content-language" content="de_DE" />
<link rel="stylesheet" href="'.getStylesheetDirectoryURI().'/style.css" />
<link rel="stylesheet" href="'.getStylesheetDirectoryURI().'/style-facebook.css" />
<script type="text/javascript" src="'.getStylesheetDirectoryURI().'/_javascript/document_ready/jquery-1.8.2.min.js"></script>
'.getJSScripts().'
'.setGalleria().'
'.createDynamicCSS(array()).'
</head>
<body>
';

?>

	