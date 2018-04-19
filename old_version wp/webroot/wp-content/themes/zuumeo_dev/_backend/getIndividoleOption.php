<?php

function getIndividoleOption($option){
	global $ind_options;
	
	if(isset($ind_options['individole_'.$option])) {
		return $ind_options['individole_'.$option];
		
	} else {
		return false;
	}
}

?>