<?php

function getCacheStatus() {
	if(getIndividoleOption("cache_status") && getIndividoleOption("cache_status") == 1) {
		return true;
	
	} else {
		return false;
	}
}