<?php

// Add the filter
add_filter('upload_mimes', 'addMimeTypes');
 
// Function to add mime types
function addMimeTypes ( $mime_types=array() ) {
	$return = array();
	
	$mime_types = array(
		'WebM' 	=> 'video/webm',
		'webm' 	=> 'video/webm',
		'mp4' 	=> 'video/mp4',
		'f4v' 	=> 'video/x-flv',
		'vcf'	=> 'text/x-vcard',
        'jpg'	=> 'image/jpeg',
        'jpeg'	=> 'image/jpeg',
        'png'	=> 'image/png',
        'gif'	=> 'image/gif',
        'pdf'	=> 'application/pdf',
        'doc'	=> 'application/msword',
        'gif'	=> 'image/gif',
        'zip'	=> 'application/zip',
        'swf'	=> 'application/x-shockwave-flash',
        'xlsx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xltx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'potx'  => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'ppsx'  => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'pptx'  => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'sldx'  => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
        'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'dotx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'xlam'  => 'application/vnd.ms-excel.addin.macroEnabled.12',
        'xlsb'  => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
	);
	
	foreach($mime_types as $mime_type_key => $mime_type_value) {
		$return[$mime_type_key] = $mime_type_value;
	}
 
	return $return;
}

?>