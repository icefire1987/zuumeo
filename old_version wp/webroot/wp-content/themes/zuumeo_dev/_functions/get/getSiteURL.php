<?php

function getSiteURL() {
	global $wpdb;
	
	$q = '
	SELECT
    	option_value
	FROM
	    '.$wpdb->prefix.'options
	WHERE
    	option_name = "siteurl"
	';
	$result = mysql_query($q);
	
	$return = mysql_result($result, 0, "option_value");
	
	return $return;
}

?>