<?php

function queryDbug() {
	if(SAVEQUERIES == true && WP_DEBUG == true && isSuperAdmin()) {
		global $wpdb;
		
			
		//debug($wpdb);
				
		// disabled session cache of mySQL
		//if ( QUERY_CACHE_TYPE_OFF )
		//$wpdb->query( 'SET SESSION query_cache_type = 1;' );
		
		$debug_queries  = '';
		$total_time = 0;
		$total_query_time = 0;
		$queries = array();
		if ( $wpdb->queries ) {
			$x = 0;
			$total_time = timer_stop( FALSE, 22 );
			$total_query_time = 0;
			$class = ''; 
			
			
			foreach ( $wpdb->queries as $q ) {
				//debug($q);
				
				if ( $x % 2 != 0 )
					$class = '';
				else
					$class = ' class="alt"';
				
				$q[0] = trim( preg_replace( '/[[:space:]]+/', ' ', $q[0]) );
				$total_query_time += $q[1];
				$debug_queries .= '<li' . $class . '><ul>';
				$debug_queries .= '<li><strong>' . __( 'Time:' ) . '</strong> ' . $q[1] . '</li>';
				if ( isset($q[1]) )
					$debug_queries .= '<li><strong>' . __( 'Query:' ) . '</strong> ' . htmlentities( $q[0] ) . '</li>';
				if ( isset($q[2]) )
					$debug_queries .= '<li><strong>' . __( 'Call from:' ) . '</strong> ' . htmlentities( $q[2] ) . '</li>';
					
				$debug_queries .= '</ul></li>' . "\n";
				
				
				$queries[] = array($q[1], htmlentities( $q[0] ), htmlentities( $q[2] ));
				
				
				$x++;
			}
			
			$debug_queries .= '</ol>' . "\n\n";
		}
		
		
		$summary = '
			<p>num_queries: '.$wpdb->num_queries.'
			<br>total time: '.$total_time.'
			<br>total_query_time: '.$total_query_time.'
			<br>timer_stop: '.timer_stop(0, 3).'
		';
		
		
		$final_queries = array($summary);
		if(!empty($queries)) {
			$q_sorted = sortMultiArray($queries,0);
			
			foreach($q_sorted AS $q) {
				$final_queries[] = '
					<p>Time: '.$q[0].'<br>Query: '.$q[1].'<br>Call from: '.$q[2].'</p>
				';
			}
		}
		
		debug($final_queries);
		
		
	}
}

?>