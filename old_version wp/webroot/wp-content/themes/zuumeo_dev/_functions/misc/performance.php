<?php

function performance( $visible = false ) {

	 $stat = sprintf(  '%d queries in %.3f seconds, using %.2fMB memory',
		  get_num_queries(),
		  timer_stop( 0, 3 ),
		  memory_get_peak_usage() / 1024 / 1024
		  );

	 echo $visible ? $stat : "<!-- {$stat} -->" ;
}

//add_action( 'wp_footer', 'performance', 20 );

?>