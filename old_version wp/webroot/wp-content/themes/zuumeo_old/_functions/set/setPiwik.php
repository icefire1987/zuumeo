<?php

function setPiwik() {
	if(getOptionNumber('piwik_status') == 1 && !isPreview()) {
		$return = '
			<!-- Piwik --> 
				<script type="text/javascript">
				var pkBaseURL = (("https:" == document.location.protocol) ? "https://piwik.seoprime-preview.de/" : "http://piwik.seoprime-preview.de/");
				document.write(unescape("%3Cscript src=\'" + pkBaseURL + "piwik.js\' type=\'text/javascript\'%3E%3C/script%3E"));
				</script><script type="text/javascript">
				try {
				var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 2);
				piwikTracker.trackPageView();
				piwikTracker.enableLinkTracking();
				} catch( err ) {}
				</script><noscript><p><img src="http://piwik.seoprime-preview.de/piwik.php?idsite=2" style="border:0" alt="" /></p></noscript>
			<!-- End Piwik Tracking Code -->
		';
		
		return $return;
	}
}

?>