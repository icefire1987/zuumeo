<?php

function getCurrentMainDomain(){
	global $words;
	
	return $words['maindomain'][getCurrentLanguage(array())];
}

?>