<?php

function getCacheTime($type="desktop") {
	if(getIndividoleOption("cache_time_".$type)) {
		return getIndividoleOption("cache_time_".$type);
	
	} else {
		return false;
	}
}