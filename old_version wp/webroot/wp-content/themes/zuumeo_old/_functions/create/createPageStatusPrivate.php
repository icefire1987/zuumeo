<?php

function createPageStatusPrivate($args) {
	(isset($args['class'])) ? $class = $args['class'] : $class = '';
	
	if(isset($args['status'])) {
		$status = $args['status'];
	
	} else {
		global $page_id;
	
		$status = get_post_status($page_id);
	}
	
	if($status == 'private' && isLogged()) {
		$return = '<div class="private_page '.$class.'" '.createAltTitleTag("Dieser Inhalt ist unveröffentlicht und nur sichtbar, wenn man im Backend eingeloggt ist.").'></div>';

		return $return;
	}
}

?>