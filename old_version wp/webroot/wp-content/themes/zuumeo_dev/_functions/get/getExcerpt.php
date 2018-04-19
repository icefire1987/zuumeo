<?php

function getExcerpt($args) {
	if(isset($args['limit'])) {
		$words = $args['limit'];
	} else {
		$words = getOptionNumber('excerpt_length');
	}
	
	$text = $args['text'];
	
	$text = strip_shortcodes( $text );
	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]>', $text);
	$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
	$text = wp_trim_words( $text, $words, $excerpt_more );
	
	return apply_filters('the_excerpt', $text);
}