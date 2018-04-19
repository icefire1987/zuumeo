<?php

function mytrim($text){
	$pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/"; 
	return preg_replace($pattern, '', $text);
}

?>