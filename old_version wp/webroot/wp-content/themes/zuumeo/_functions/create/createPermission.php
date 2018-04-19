<?php

add_shortcode('permission', 'createPermission');

function createPermission($args) {
	if(!isPermission()) {
		$return = '
			<form action="" method="post">
			<input type="hidden" name="permission" value="1">
			<div class="selters_button" style="width:'.$args['w'].'px; margin:10px 0px 0px 10px;">
				<div class="selters_button_inner">
					<input type="submit" value="'.$args['text'].'" class="submit">
				</div>
			</div>
			</form>	
		';
	
	} else {
		$return = '';
	}
		
	return $return;
}

?>