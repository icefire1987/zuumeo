<?php

function getRealFrontpageID() {
	$q = '
	SELECT 
	 	option_value
	FROM 
	 	'.TABLE_PREFIX.'options
	WHERE
		option_name = "page_on_front"
	';
	$result = mysql_query($q);
	$real_siteurl = mysql_fetch_array($result);
	$real_siteurl = $real_siteurl['option_value'];
	
	return $real_siteurl;
}