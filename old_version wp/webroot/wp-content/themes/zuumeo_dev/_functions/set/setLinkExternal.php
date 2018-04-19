<?php

function setLinkExternal($link) {
	if(isLinkExternal($link)) {
		return ' target="_blank" ';
	}
}

?>