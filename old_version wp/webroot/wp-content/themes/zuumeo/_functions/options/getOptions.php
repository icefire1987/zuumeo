<?php

function getOptions() {
	$return = array();
	
	global $configs_acf_options;
	
	foreach($configs_acf_options AS $configs_acf_key => $configs_acf_value) {
	    $return[$configs_acf_key] = array();
	}
	   
	   
	$q = '
	SELECT 
	   o.option_name,
	   o.option_value
	FROM 
	    '.TABLE_PREFIX.'options AS o
	WHERE 
	    o.option_name LIKE "options_options_%"
	ORDER BY
	    o.option_name ASC
	';
	$result = mysql_query($q);
	
	
	$types = array();
	while($row = mysql_fetch_array($result)) {
	    $option_name 	= $row['option_name'];
	    $option_name	= str_replace("options_options_", "", $row['option_name']);
	    
	    $option_var 	= explode("_", $option_name);
	    $option_value 	= $row['option_value'];
	    
	    $types[$option_var[0]][$option_name] = $option_value;
	}
	
	foreach($types AS $type => $v) {
		$count = $v[$type];
		
		for($i = 0; $i<$count; $i++) {
			if(function_exists("pll_the_languages")) {
				global $polylang;
				
				
				
				foreach($polylang->model->get_languages_list() AS $language) {
					if($type == "files") {
						if($v[$type.'_'.$i.'_options_content_0_'.$language->slug.'_0_normal'] > 0) {
							$value = $v[$type.'_'.$i.'_options_content_0_'.$language->slug.'_0_normal'];
						} else {
							$value = $v[$type.'_'.$i.'_options_content_0_standard_0_normal'];
						}
					
					} else {
						$value = $v[$type.'_'.$i.'_options_content_0_'.$language->slug];
					}
					
					$return[$type][$language->slug][$v[$type.'_'.$i.'_0_options_var']] = $value;
				}
				
			} else {
				if($type == "files") {
					$value = $v[$type.'_'.$i.'_options_content_0_normal'];
					
				} else {
					$value = $v[$type.'_'.$i.'_options_content'];
				}
				
				$return[$type][$v[$type.'_'.$i.'_0_options_var']] = $value;
			}
		}
		
		if($type == "files") {
			//var_dump($return);
		}
	}
	
	//debug($return);
	
	return $return;
}

?>