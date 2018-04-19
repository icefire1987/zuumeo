<?php

function setMetaNoIndex() {
	if(isMetaNoIndex()) {
		$return = '<meta name="robots" content="noindex, nofollow">';
		
		return $return;
	}
}

?>