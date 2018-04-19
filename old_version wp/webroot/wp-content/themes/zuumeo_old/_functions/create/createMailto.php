<?php

add_shortcode('mailto', 'createMailto');

function createMailto($args) {
	(isset($args['top'])) ? $top = $args['top'] : $bottom = 0;
	
	$return = '
		'.clearer($top).'
		<a href="mailto:'.$args['email'].'" class="mailto">'.$args['email'].'</a>
		'.clearer($bottom).'
	';
	
	return $return;
}

?>