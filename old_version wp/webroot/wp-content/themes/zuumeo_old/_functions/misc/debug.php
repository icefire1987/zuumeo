<?php

function debug($values) {
	if(isSuperAdmin()) {
		new dbug($values);
	}
}

?>