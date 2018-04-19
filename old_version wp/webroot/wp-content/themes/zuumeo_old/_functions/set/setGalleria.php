<?php

function setGalleria(){
	$return = '
		<link rel="stylesheet" href="'.getStylesheetDirectoryURI().'/_galleria/themes/classic/galleria.classic.css?'.rand().'" />
		<script src="'.getStylesheetDirectoryURI().'/_galleria/galleria-1.2.8.min.js"></script>
		<script type="text/javascript">
			Galleria.loadTheme("'.getStylesheetDirectoryURI().'/_galleria/themes/classic/galleria.classic.js");
		</script>
	';
	
	return $return;
}

?>