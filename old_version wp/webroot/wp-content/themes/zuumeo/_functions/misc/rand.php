<?php

add_shortcode('rand', 'randomNumber');

function randomNumber() {
	return rand(9999, 9999999);
}

?>