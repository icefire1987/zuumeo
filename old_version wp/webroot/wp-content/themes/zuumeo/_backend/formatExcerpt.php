<?php

function getTextExcerpt($args) {
	$default_options = array(
		'length' 			=> 100,
		'use_words' 		=> 1,
		'no_custom' 		=> 1,
		'no_shortcode' 		=> 1,
		'finish_word' 		=> 0,
		'finish_sentence' 	=> 0,
		'ellipsis' 			=> '&hellip;',
		'read_more' 		=> 'Read the rest',
		'add_link' 			=> 0,
		'allowed_tags' 		=> array('_all')
	);
	
	$text = $args['text'];
	
	foreach($default_options AS $key => $value) {
		if(isset($args[$key])) {
			${$key} = $args[$key];
			
		} else {
			${$key} = $value;
		}
	}


	$tokens = array();
	$out = '';
	$w = 0;

	preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $text, $tokens);
	foreach ($tokens[0] as $t) {
		if ($w >= $length && !$finish_sentence) {
			break;
		}
		
		if ($t[0] != '<') {
			if ($w >= $length && $finish_sentence && preg_match('/[\?\.\!]\s*$/uS', $t) == 1) {
				$out .= trim($t);
				break;
			}
			
			if (1 == $use_words) {
				$w++;
			} else {
				$chars = trim($t);
				$c = strlen($chars);
				if ($c + $w > $length && !$finish_sentence) {
					$c = ($finish_word) ? $c : $length - $w;
					$t = substr($t, 0, $c);
				}
				$w += $c;
			}
		}
		$out .= $t;
	}
	
	$return = trim(force_balance_tags($out));
	
	if(isset($args['suffix'])) {
		if(endsWith($return, "</p>")) {
			$return = substr($return, 0, -4);
			$return = $return.$args['suffix'].'</p>';
		
		} else {
			$return = $return.$args['suffix'];
		}
	}
	
	return $return;
}

?>