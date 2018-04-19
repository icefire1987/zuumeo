<?php

function clearer($h = 0, $id = "") {
	$clearer_id = '';
	if($id != "") {
		$clearer_id = 'id="'.$id.'"';
	}
	
	if($h == "") {
		$h = 0;
	}
	
	$return = '<div class="clearer" '.$clearer_id.' style="height:'.$h.'px;"></div>';
	
	return $return;
}

?>