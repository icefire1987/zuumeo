<?php

function adminShowDebug() {
	global $final_debug;
	
	if(isSuperAdmin() && !empty($final_debug)) {
		echo '
			<div id="debug" style="position: absolute; z-index:99990; top:0px; right: 0px;">'.implode("", $final_debug).'</div>
		';
	}
}

?>