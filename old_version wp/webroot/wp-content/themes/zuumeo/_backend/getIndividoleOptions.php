<?php

function getIndividoleOptions() {
	$q = '
	SELECT 
		option_name,
		option_value 
	FROM 
		'.TABLE_PREFIX.'options 
	WHERE 
		option_name LIKE "individole_%"
	';
	$result = mysql_query($q);
	
	$return = array();
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$return[$row['option_name']] = $row['option_value'];
	}
	
	return $return;
}

?>