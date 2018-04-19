<?php

function setHeaderScripts($args) {
	(isset($args['favicon'])) 		? $favicon = $args['favicon'] 		: $favicon = true;
	(isset($args['galleria'])) 		? $galleria = $args['galleria'] 	: $galleria = true;
	(isset($args['css_phone'])) 	? $css_phone = $args['css_phone'] 	: $css_phone = true;
	(isset($args['jwplayer'])) 		? $jwplayer = $args['jwplayer'] 	: $jwplayer = true;
	(isset($args['shadowbox'])) 	? $shadowbox = $args['shadowbox'] 	: $shadowbox = true;
	(isset($args['expand'])) 		? $expand = $args['expand'] 		: $expand = true;
	(isset($args['retina'])) 		? $retina = $args['retina'] 		: $retina = true;
	
	
	$d = getStylesheetDirectoryURI();
	
	
	//!Favicon
	$script_favicon = '
		<link rel="shortcut icon" type="image/ico" href="'.$d.'/_images/favicon.ico" />
	';
	
	
	//!jQuery
	$script_jquery = '
		<script type="text/javascript" src="'.$d.'/_javascript/document_ready/jquery-1.9.1.min.js"></script>
	';
	
	if(isAdmin()) {
		ob_start();
		wp_head();
		$wp_head = ob_get_contents();
		ob_end_clean(); 
		
		$script_jquery .= $wp_head;
	}
	
	
	//!Galleria
	$script_galleria = '
		<link rel="stylesheet" href="'.$d.'/_galleria/themes/classic/galleria.classic.css" />
		<script type="text/javascript" src="'.$d.'/_galleria/galleria-1.2.9.min.js"></script>
		<script type="text/javascript">
		    Galleria.loadTheme("'.$d.'/_galleria/themes/classic/galleria.classic.js");
		</script>
	';
	
	
	//!EXTRA-CSS
	$script_css_phone = '
		<link rel="stylesheet" href="'.$d.'/style-phone.css" />
	';
	
	
	//!JWPlayer
	$script_jwplayer = '
		<script type="text/javascript" src="'.$d.'/_jwplayer/jwplayer.js"></script>
		<script type="text/javascript" src="'.$d.'/_jwplayer/swfobject.js"></script>
	';
	
	
	//!Shadowbox
	$script_shadowbox = '
		<link rel="stylesheet" type="text/css" href="'.$d.'/_shadowbox/shadowbox.css" />
		<script src="'.$d.'/_shadowbox/shadowbox.js" type="text/javascript"></script>
		<script type="text/javascript">Shadowbox.init({
			overlayOpacity : '.getOptionNumber("shadowbox_overlay_opacity").',
			overlayColor : "'.getOptionColor("shadowbox_overlay_color").'",
		});</script>
	';
	
	
	//!Retina
	$script_retina = '
		<script type="text/javascript">
document.cookie=\'devicePixelRatio=\'+((window.devicePixelRatio === undefined) ? 1 : window.devicePixelRatio)+\'; path=/\'; Shadowbox.init({ });</script>
		<noscript><style type="text/css" id="devicePixelRatio" media="only screen and (-moz-min-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2/1), only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2)">#devicePixelRatio{background-image:url("'.getCurrentHOST().'/retinaimages.php?devicePixelRatio=2")}</style></noscript>
	';
	
	
	//!EXPAND
	$script_expand = '
		<script type="text/javascript"><!--
  			function expand(param) {
  				jQuery("div#te"+param).stop().slideToggle(350, function() {
  					if( jQuery("div#te"+param).is(":visible") ) {
  						jQuery("a#te"+param).hide();
  						
  					} else {
  						jQuery("a#te"+param).show();
  					}    
  				});
  			}

  			function expander_hide(param) {
  				jQuery("div#te"+param).hide();
  				jQuery("a#te"+param).show();
  			}
  		//--></script>
	';
			
	
	$scripts = array();
	
	$scripts[] = setFacebookMeta();
	$scripts[] = createDynamicCSS(array());
	
		
	if($favicon == true) {
		$scripts[] = $script_favicon;
	}
		
	$scripts[]  = $script_jquery;
		
	if($galleria == true) {
		$scripts[] = $script_galleria;
	}
		
	if(isPhone() && $css_phone == true && RESPONSIVE == true) {
		$scripts[] = $script_css_phone;
	}
	
	if($jwplayer == true) {
		$scripts[] = $script_jwplayer;
	}
	
	if($shadowbox == true) {
		$scripts[] = $script_shadowbox;
	}
	
	if($retina == true) {
		$scripts[] = $script_retina;
	}
	
	if($expand == true) {
		$scripts[] = $script_expand;
	}
	
	$scripts[] = getJSScripts();
	
	return implode("", $scripts);
}

?>