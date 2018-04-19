<?php

function resizeApp() {
	$return = '
		<div id="fb-root"></div>

		<script type="text/javascript">
			window.fbAsyncInit = function() {
				FB.init({
					appId: "",
					status: true,
					cookie: true,
					xfbml: true
				});
				
				FB.Canvas.setAutoGrow(400);
				FB.Canvas.scrollTo(0, 0);
			};
			
			(function() {
				var e = document.createElement("script");
				e.async = true;
				e.src = document.location.protocol + "//connect.facebook.net/'.getCurrentLanguageCode().'/all.js";
				document.getElementById("fb-root").appendChild(e);
			}());
		</script>
	';
	


	return $return;
}

?>