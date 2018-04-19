<?php

function setGoogleAnalytics() {
	if(!isAdmin() && getOptionAdmin('ga_code')) {
		$return = "
		 <script type='text/javascript'>
		 	var _gaq = _gaq || [];
		 	_gaq.push(['_setAccount', '".getOptionAdmin('ga_code')."']);
		 	_gaq.push(['_setDomainName', '".str_replace("www.", "", $_SERVER['HTTP_HOST'])."']);
		 	_gaq.push(['_setAllowLinker', true]);
		 	_gaq.push(['_trackPageview']);
		 	
		 	(function() {
		 	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		 	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		 	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		 	})();
		 </script>
		";
		
		return $return;
	}
}

?>