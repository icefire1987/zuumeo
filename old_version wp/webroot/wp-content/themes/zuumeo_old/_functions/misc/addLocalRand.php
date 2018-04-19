<?php

function addLocalRand() {
	if(isLocal()) {
		return '?'.rand();
	}
}

?>