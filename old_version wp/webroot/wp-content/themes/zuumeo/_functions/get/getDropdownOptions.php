<?php

function getDropdownOptions($dropdown_id) {
	$loop_args_dropdown = array( 
		'post_type' 		=> 'dropdowns', 
		'posts_per_page' 	=> 1,
		'post__in'			=> array($dropdown_id),
	);
	
	$loop_dropdown = new WP_Query( $loop_args_dropdown );
	$temp_dropdown = '';
	
	while ( $loop_dropdown->have_posts() ) : $loop_dropdown->the_post();
		$dropdown_options = get_field('dropdown_options');
		
		//debug($dropdown_options);
		
		foreach($dropdown_options as $dropdown_option) {
			$dropdown_option_title = $dropdown_option['dropdown_title'];
		 	
		 	$temp_dropdown .= '
		 		<option value="'.$dropdown_option_title.'">'.$dropdown_option_title.'</option>
		 	';
		}
	endwhile;
	
	return $temp_dropdown;
}

?>