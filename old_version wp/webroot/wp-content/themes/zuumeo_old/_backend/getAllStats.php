<?php

function getAllStats($args) {
	(isset($args['post_type'])) 	? $post_type = $args['post_type'] 	: $post_type = 'page';
	(isset($args['operator'])) 		? $operator = $args['operator'] 	: $operator = '=';
	(isset($args['order_by'])) 		? $order_by = $args['order_by'] 	: $order_by = 'p.ID';
	(isset($args['order'])) 		? $order = $args['order'] 			: $order = 'ASC';
	
	if($operator == "=") {
		$where_post_type = 'AND s.post_type = "'.$post_type.'"';
	} else {
		$where_post_type = 'AND s.post_type LIKE "%'.$post_type.'"';
	}
	
	$q = '
	SELECT
	    s.post_id,
	    s.post_title,
	    s.post_type,
	    s.ga_uniquepageviews,
	    s.facebook_total,
	    p.post_date
	FROM
	    '.TABLE_PREFIX.'individole_statistics AS s
	LEFT JOIN
		'.TABLE_PREFIX.'posts AS p
	ON
		(p.ID = s.post_id)
	WHERE
		p.post_status = "publish"
	    '.$where_post_type.'
	ORDER BY
		'.$order_by.' '.$order.'
	';
	$result = mysql_query($q);
	
	$posts = array();
	$now = time(); // or your date as well
	while($row = mysql_fetch_array($result)) {
		$your_date = strtotime($row['post_date']);
		$days = floor(($now - $your_date) / (60*60*24));
		
		if($days > 0) {
			$uniquepageviews_per_day = $row['ga_uniquepageviews'] / $days;
		} else {
			$uniquepageviews_per_day = $row['ga_uniquepageviews'];
		}
		
		$posts[] = array(
			'id'						=> $row['post_id'],
			'title'						=> $row['post_title'],
			'post_type'					=> $row['post_type'],
			'date'						=> formatDate(array('date' => $row['post_date'], 'lang' => 'de')),
			'fb_likes'					=> $row['facebook_total'],
			'uniquepageviews'			=> $row['ga_uniquepageviews'],
			'uniquepageviews_per_day'	=> number_format($uniquepageviews_per_day, 2, '.', ' '),
		);
	}
	
	return $posts;
}

?>