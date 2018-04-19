<?php


function endsWith2($haystack, $needle) {
	$length = strlen($needle);
	$start  = $length * -1; //negative
	return (substr($haystack, $start) === $needle);
}



//!INCLUDE all functions
$functions_folders = array('_functions/init', '_functions/options', '_backend', '_functions', '_formulare');


foreach($functions_folders AS $functions_folder) {
	$base = get_stylesheet_directory().'/'.$functions_folder.'/';
	
	foreach(glob($base.'*') AS $file) {
		if(str_replace($base, "", $file) != "_tiny_mce") {
			if (is_dir($file)) {
				foreach(glob($file.'/*') AS $folder_file) {
					if(endsWith2($folder_file, ".php")) {
						include_once($folder_file);	
					}
				}
			
			} else {
				if(endsWith2($file, ".php")) {
					include_once($file);
				}
			}
		}
	}
}


//!MOBILE detect
$detect = new Mobile_Detect();

?>