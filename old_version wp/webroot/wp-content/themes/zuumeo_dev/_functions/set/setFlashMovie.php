<?php

function setFlashMovie($page_id) {
	$final_content = '';
	
	
	$flashmovie_id = get_post_meta($page_id, 'flashmovie_id', 'true');
	
	$m_t 							= $m_t_base = 0;
	$m_b 							= $m_b_base = 0;
	$left 						= "50%";
	$position 					= 'relative';
	$top 							= 0;
	$shadow 						= 0;
	$background 				= 'transparent';
	$line 						= 0;
	$fallback_w 				= '';
  	$fallback_h 				= '';
	$fallback_top 				= '';
	$fallback_bottom 			= '';
	$m_l 							= '';
	$fallback_shadow 			= '';
	$fallback_line 			= 0;
	$fallback_background 	= '';
	$fallback_line_display 	= 'block';
	
	$fallback_image = trim(get_post_meta($flashmovie_id, 'flashmovie_fallback_image', true));
	
	
	$movie_500 		= get_post_meta($flashmovie_id, 'movies_0_movie_500', true);
	$movie_1000 	= get_post_meta($flashmovie_id, 'movies_0_movie_1000', true);
	$movie_1500 	= get_post_meta($flashmovie_id, 'movies_0_movie_1500', true);
	
	if($movie_500 > 0 || $movie_1000 > 0 || $movie_1500 > 0) {
		$movie_w 				= get_post_meta($flashmovie_id, 'movie_sizes_0_movie_w', true);
		$movie_h 				= get_post_meta($flashmovie_id, 'movie_sizes_0_movie_h', true);
		$movie_top 				= get_post_meta($flashmovie_id, 'movie_sizes_0_movie_top', true);
		$movie_bottom 			= get_post_meta($flashmovie_id, 'movie_sizes_0_movie_bottom', true);
		$movie_background 	= get_post_meta($flashmovie_id, 'movie_background', true);
		$movie_autostart 		= get_post_meta($flashmovie_id, 'movie_autostart', true);
		$movie_image 			= get_post_meta($flashmovie_id, 'movie_image', true);
				
				//$final_content = '
		//	<div id="header'.$flashmovie_id.'" class="flashmovie flashmovie_shadow_'.$shadow.'" style="height:'.$box_h.'px;">
		//		'.$final_line.'
		//		<div id="FlashMovieContainer'.$flashmovie_id.'" style="width:'.$fallback_w.'px; height:'.$fallback_h.'px; position:absolute; top:'.$fallback_top.'px; left:50%; margin-left:-'.round($fallback_w/2,0).'px; text-align:center; background-color:'.$background.'; font-size:0px;">
		//			'.$fallback.'
		//		</div>
		//	</div>
		//	'.clearer($fallback_bottom, 'clearer_bottom_'.$flashmovie_id).'
		//';
		
		$box_h = $movie_h + $movie_top;
		
		$final_content = '
			<div id="header'.$flashmovie_id.'" class="flashmovie flashmovie_shadow_1" style="height:'.$box_h.'px;">
				<div id="FlashMovieContainer'.$flashmovie_id.'" style="width:'.$movie_w.'px; height:'.$movie_h.'px; position:absolute; top:'.$movie_top.'px; left:50%; margin-left:-'.round($movie_w/2,0).'px; text-align:center; background-color:'.$movie_background.'; font-size:0px;">
					'.createVideo(array(
						'autostart'		=> $movie_autostart,
						'movie_500'		=> $movie_500,
						'movie_1000'	=> $movie_1000,
						'movie_1500'	=> $movie_1500,
						'image'			=> $movie_image,
						'w'				=> $movie_w,
						'h'				=> $movie_h,
					)).'
				</div>
			</div>
			'.clearer($movie_bottom, 'clearer_bottom_'.$flashmovie_id).'
		';
	
	} else {
		$fallback = '';
		if($fallback_image > 0) {
			$img_src 			= wp_get_attachment_image_src($fallback_image, 'full');
			$fallback_h 		= 0;
			$fallback_top 		= 0;
			$fallback_bottom 	= 0;
			$fallback_line 	= get_post_meta($flashmovie_id, 'flashmovie_fallback_line', true);
			$fallback_shadow 	= get_post_meta($flashmovie_id, 'flashmovie_fallback_shadow', true);
			
			if($fallback_line == 0) {
				$fallback_line_display = 'none';
			}
			
			if($img_src) {
				$fallback_w 			= $img_src[1];
				$fallback_h 			= $img_src[2];
				$fallback_top 			= get_post_meta($flashmovie_id, 'flashmovie_fallback_top', true);
				$fallback_bottom 		= get_post_meta($flashmovie_id, 'flashmovie_fallback_bottom', true);
				$m_l 						= '-'.round($fallback_w/2, 0);
				
				$fallback_background = get_post_meta($flashmovie_id, 'flashmovie_fallback_background', true);
				
				$fallback_extra = '';
				for($i = 1; $i<4; $i++) {
					$fb_e_image 	= get_post_meta($flashmovie_id, 'fallback_extra_'.$i.'_image', true);
					$fb_e_img_src 	= wp_get_attachment_image_src($fb_e_image, 'full');
					
					if($fb_e_img_src) {
						$fb_e_top 		= get_post_meta($flashmovie_id, 'fallback_extra_'.$i.'_top', true);
						$fb_e_left 		= get_post_meta($flashmovie_id, 'fallback_extra_'.$i.'_left', true);
						$fb_e_link 		= get_post_meta($flashmovie_id, 'fallback_extra_'.$i.'_link', true);
						
						$final_fb_e_image = '<img src="'.$fb_e_img_src[0].'" '.createAltTitleTag("").' />';
						if($fb_e_link > 0) {
							$final_fb_e_image = '<a href="'.get_permalink($fb_e_link).'">'.$final_fb_e_image.'</a>';
						}
						
						$fallback_extra .= '
							<div class="fallback_extra" style="top:'.$fb_e_top.'px; left:'.$fb_e_left.'px;">
								'.$final_fb_e_image.'
							</div>
						';
					}
				}
				
				
				$alt = get_the_title($fallback_image);
				
				$fallback = '
					<img src="'.$img_src[0].'" '.createAltTitleTag($alt).' />
					'.$fallback_extra.'
				';
				
			} else {
				$fallback_bottom = 80;
				$fallback_line = 1;
			}
			
		} else {
			$fallback_bottom = 80;
			$fallback_line = 1;
		}
		
		
		
		//!GET & SET variables for the flashmovie
		$addVariables = array();
		
		$flashmovie_vars = trim(get_post_meta($flashmovie_id, 'flashmovie_vars', true));
		$vars = explode("\n", $flashmovie_vars);
		if($flashmovie_vars != "" && sizeof($vars) > 0) {
			foreach($vars AS $var) {
				$explode = explode(" : ", $var);
				$addVariables[] = 'flashvars.'.$explode[0].' = "'.trim(strip_tags(apply_filters("the_content", $explode[1]))).'";';
			}
		}
		
		
		//!TRY to set the Flashmovie
		$swf = wp_get_attachment_url(get_post_meta($flashmovie_id, 'flashmovie_swf', true));
		
		if($swf && getOptionNumber('load_flash') == 1 && $flashmovie_id > 0) {
			$flash_w					= get_post_meta($flashmovie_id, 'flashmovie_w', true);
			$flash_h 				= get_post_meta($flashmovie_id, 'flashmovie_h', true);
			$flash_top 				= get_post_meta($flashmovie_id, 'flashmovie_top', true);
			$flash_bottom 			= get_post_meta($flashmovie_id, 'flashmovie_bottom', true);
			$flash_m_l 				= '-'.round($flash_w/2, 0);
			$flash_shadow 			= get_post_meta($flashmovie_id, 'flashmovie_shadow', true);
			$flash_background 	= get_post_meta($flashmovie_id, 'flashmovie_background', true);
			$flash_line 			= get_post_meta($flashmovie_id, 'flashmovie_line', true);
			
			//echo '
			//	<p>$id: '.$flashmovie_id.'
			//	<p>$swf: '.$swf.'
			//	<p>$w: '.$w.'
			//	<p>$h: '.$h.'
			//';
			
			$fallback_formatted = str_replace("\n", "", $fallback);
			$fallback_formatted = str_replace("\r", "", $fallback_formatted);
			$fallback_formatted = addslashes($fallback_formatted);
			
			
			$final_line = '';
			if($flash_line == 1) {
				$final_line = '<div id="header-line"></div>';
			}
			
			$box_h = $flash_h + $flash_top;
			
			$final_content = '
				<div id="header'.$flashmovie_id.'" class="flashmovie flashmovie_shadow_'.$flash_shadow.'" style="height:'.$box_h.'px;">
					'.$final_line.'
					<div id="FlashMovieContainer'.$flashmovie_id.'" style="width:'.$flash_w.'px; height:'.$flash_h.'; position:relative; top:'.$flash_top.'px; left:50%; margin-left:'.$flash_m_l.'px; text-align:center; background-color:'.$flash_background.'; font-size:0px;">
						<div id="FlashMovie'.$flashmovie_id.'"></div>
					</div>
				</div>
				'.clearer($flash_bottom, 'clearer_bottom_'.$flashmovie_id).'
				<script type="text/javascript">
					function outputStatus(e) {
		 				if(e.success == false) {
		 					jQuery("#header'.$flashmovie_id.'").removeClass("flashmovie_shadow_'.$flash_shadow.'");
		 					jQuery("#header'.$flashmovie_id.'").addClass("flashmovie_shadow_'.$fallback_shadow.'");
		 					jQuery("#header'.$flashmovie_id.'").css("height", "'.($fallback_h + $fallback_top).'px");
		 					
		 					jQuery("#FlashMovieContainer'.$flashmovie_id.'").css("top", "'.$fallback_top.'px");
		 					jQuery("#FlashMovieContainer'.$flashmovie_id.'").css("height", "'.$fallback_h.'px");
		 					jQuery("#FlashMovieContainer'.$flashmovie_id.'").css("width", "'.$fallback_w.'px");
		 					jQuery("#FlashMovieContainer'.$flashmovie_id.'").css("margin-left", "-'.round($fallback_w/2,0).'px");
		 					jQuery("#FlashMovieContainer'.$flashmovie_id.'").css("background-color", "'.$fallback_background.'");
		 					
		 					jQuery("#header-line").css("display", "'.$fallback_line_display.'");
		 					
		 					jQuery("#clearer_bottom_'.$flashmovie_id.'").css("height", "'.$fallback_bottom.'px");
		 					
		 					
		 					
		 					jQuery("#FlashMovieContainer'.$flashmovie_id.'").html("'.$fallback_formatted.'");
		 					
		 				} else {
		 					/* jQuery("#clearer_FlashMovie'.$flashmovie_id.'").css("height", "'.$m_b.'px"); */
		 				}
					}
					
					var flashvars = {};
					var params = {};
					var attributes = {};
					
					'.implode("", $addVariables).'
					
					params.allowfullscreen = "false";
					params.allowscriptaccess = "false";
					params.quality = "high";
					params.scale = "noscale";
					params.wmode = "transparent";
					
					swfobject.embedSWF("'.$swf.'","FlashMovie'.$flashmovie_id.'","'.$flash_w.'","'.$flash_h.'","9.0.0", "", flashvars, params, attributes, outputStatus);
				</script>
			';
		
		} else {
			$h = 'auto';
			$shadow = $fallback_shadow;
			
			$final_line = '';
			if($fallback_line == 1) {
				$final_line = '<div id="header-line"></div>';
			}
			
			$box_h = $fallback_h + $fallback_top;
			
			$final_content = '
				<div id="header'.$flashmovie_id.'" class="flashmovie flashmovie_shadow_'.$shadow.'" style="height:'.$box_h.'px;">
					'.$final_line.'
					<div id="FlashMovieContainer'.$flashmovie_id.'" style="width:'.$fallback_w.'px; height:'.$fallback_h.'px; position:absolute; top:'.$fallback_top.'px; left:50%; margin-left:-'.round($fallback_w/2,0).'px; text-align:center; background-color:'.$background.'; font-size:0px;">
						'.$fallback.'
					</div>
				</div>
				'.clearer($fallback_bottom, 'clearer_bottom_'.$flashmovie_id).'
			';
		}
	}
	
	
	$return = $final_content;
	
	++$flashmovie_id;
	
	//return $return;
}

?>