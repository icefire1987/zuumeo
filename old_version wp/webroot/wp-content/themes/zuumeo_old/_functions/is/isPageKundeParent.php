<?php

function isPageKundeParent() {
	if(isPageKunde()) {
		global $page_parent;
		
		if($page_parent > 0) {
			return $page_parent;
		}
	}
}