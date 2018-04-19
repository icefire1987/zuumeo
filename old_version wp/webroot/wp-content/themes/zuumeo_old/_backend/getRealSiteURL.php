<?php

function getRealSiteURL() {
	$q = '
	SELECT 
	 	option_value
	FROM 
	 	'.TABLE_PREFIX.'options
	WHERE
		option_name = "siteurl"
	';
	$result = mysql_query($q);
	$real_siteurl = mysql_fetch_array($result);
	$real_siteurl = $real_siteurl['option_value'];
	
	return $real_siteurl;
}