<?php

add_shortcode('share_mailto', 'formatMailTo');

function formatMailTo($args) {
	$array_setPagelink = array('text' => strip_tags(getSentence('share_mailto_body')));
	
	if(isset($args['url'])) {
		$array_setPagelink['url'] = $args['url'];
	}
	
	
	$return = 'mailto:?subject='.getOptionWord('share_mailto_subject').'&body='.setPagelink($array_setPagelink);
	
	
	//mailto:?subject=SELTERS%20auf%20der%20Prowein%202012&body=Ich moechte gern einen interessanten Link mit Ihnen teilen:%0A%0ASELTERS auf der ProWein vom 04. bis 06. Maerz 2012 in Duesseldorf.%0A%0ALassen auch Sie sich von Experten innerhalb einer SELTERS- %26 Weinverkostung erlaeutern weshalb Original SELTERS als der Ursprung guten Geschmackes gilt, welche SELTERS-Varietaet mit welchem Wein ein ideal-harmonisches Genusspaar bildet und erleben Sie das Thema %22Wasser %26 Wein%22 in seinen Facetten auf vielfaeltig neue Art.%0A%0AMehr Informationen finden Sie unter: www.selters-prowein
	
	return $return;
}

?>