<?php

add_shortcode('mail', 'formatMailAddressAntiSpam');

function formatMailAddressAntiSpam($args){
	$mail_formatted = str_replace("@", " [at] ", $args['mail']);
	
	$output = '<span class="email">'.$mail_formatted.'</span>';
	
	return $output;
}

?>