<?php

$i_galleria = 1;

function createModuleGalleria($args){
	global $i_galleria;
	global $page_id;
	
	//debug($args);
	
	$o = $args['m_gallery_options'][0]['options'][0];
	$c = $args['config_base'][0];
	$images = $args['m_gallery_images'];
	
	//debug($o);
	
	if(isset($o['random']) && $o['random'] == true) {
		shuffle($images);
	}
		
	if(isAdmin() & isset($args['meta_key'])) {
		$e_array = array(
	    	'id' 			=> $page_id,
	    	'field'			=> $args['meta_key'],
	    	'column'		=> 1,
	    );
	    
	    if(isset($args['col_w'])) {
	        $e_array['w'] = $args['col_w'];
	    }
	    
	    $e = addFrontpageEdit($e_array);
	}
	
	if(isset($o['type']) && $o['type'] == 'wand') {
		//debug($o);
		
		$scale = 1;
		$image_padding = 0;
		
		$per_row 	= $o['wand_cols'];
		$shadow 	= $o['wand_shadow'];
		$gap 		= $o['wand_gap'];
		$masonry	= $o['wand_masonry'];
		
		if($masonry == true) {
			//$gap = 0;
		}
		
		$max_width = getColumnWidth(array());
		
		if(isset($args['col_w']) && $args['col_w'] < $max_width) {
			$max_width = $args['col_w'];
		}
		
		
		
		
		$w = $w_image = floor(($max_width - ($gap * ($per_row - 1))) / $per_row);	
		
		if($masonry == true) {
			//$w = $w - $gap;
		}
		
		//debug($images);
		
			
		$image_wall = array();
		$i = 0;
		foreach($images AS $image => $v) {
			//debug($v);
			
			$m_r = $gap;
			$clearer = '';
			if($i%$per_row == $per_row-1 && $masonry != true) {
			    $m_r = 0;
			    
			    if($i < sizeof($images)-1) {
			    	$clearer = clearer($gap);
			    }
			}
			
			$h = $h_image = 'auto';
			
			$class_image_border = '';
			if($shadow == true) {
			    $class_image_border = 'shadow';
			    
			    $w_image = floor(($w - $image_padding) * $scale);
			    $h_image = floor(($h - $image_padding) * $scale);
			
			} else {
			    $w_image = floor($w * $scale);
			    $h_image = floor($h * $scale);
			}
			
			
			$image_array = array(
			    'id'		=> $v['id'],
			    'w'			=> $w,
			    'size'		=> 'full',
			    'shadowbox'	=> 'wand_'.$i_galleria,
			    'set_sizes'	=> true,
			);
			
			if(
			($masonry != true) 
			&& (isset($o['w']) && $o['w'] > 0) 
			&& (isset($o['h']) && $o['h'] > 0)
			) {
			    $image_array['h_box'] = floor((($w * $o['h']) / $o['w']) * $scale);
			    $image_array['fill'] = 1;
			}
			
			//debug($image_array);
			
			$image = createImage($image_array);
			
			$image_wall[] = '
			    <div class="null left relative" style="width:'.$w.'px; height:'.$h.'; margin:0px '.$m_r.'px '.$m_r.'px 0px;">
			    	<div class="null '.$class_image_border.'" style="">
			    		'.$image.'
			    	</div>
			    	'.$clearer.'
			    </div>
			';
			
			++$i;
			
		}
		
		$final_masonry = '';
		if($masonry == true) {
			$final_masonry = '
				<script>
					var $container = jQuery("#wall_'.$i_galleria.'");
					$container.imagesLoaded(function(){
						$container.masonry({
							columnWidth : '.($w + $gap).',
							isAnimated: true
						});
					});
				</script>
			';
		}
		
		$return = '
			<div id="wall_'.$i_galleria.'" class="relative null" style="width:'.($max_width + $gap).'px;">
				'.implode("", $image_wall).'
				'.clearer().'
			</div>
			'.$final_masonry.'
		';
		
	} else {
		$t = array();
		if(isset($args['m_gallery_text'][0])) {
			$t = $args['m_gallery_text'][0];
		}
		
		if(isset($o['name']) && $o['name'] != "") {
			$name = $o['name'];
			
		} else {
			$name = $i_galleria;
		}
		
		$galleria_text = '';
		if(isset($t['status']) && $t['status'] == true) {
			$galleria_text_content = array();
			$galleria_text_status = 0;
			if($t['title'] != "") {
				$galleria_text_status = 1;
				$galleria_text_content[] = '
					<div class="galleria_text_title">'.$t['title'].'</div>
				';
			}
			
			if($t['subtitle'] != "") {
				$galleria_text_status = 1;
				$galleria_text_content[] = '
					<div class="galleria_text_subtitle">'.$t['subtitle'].'</div>
				';
			}
			
			if($t['text'] != "") {
				$galleria_text_status = 1;
				
				if($t['title'] != "" || $t['subtitle'] != "") {
					$galleria_text_content[] = clearer(8);
				}
				
				$galleria_text_content[] = '
					<div class="galleria_text_text">'.nl2br($t['text']).'</div>
				';
			}
			
			
			if($t['position'] >= 0) {
				$final_position = 'top:'.$t['position'].'px;';
				
			} else {
				$bottom_position = ((-1 * $t['position'])-1);
				
				if(defined("GALLERIA_THUMBS_H") && $o['thumbnails'] == true) {
					$bottom_position = $bottom_position + GALLERIA_THUMBS_H;
				}
				
				$final_position = 'bottom:'.$bottom_position.'px;';
			}
			
			
			$final_background = '';
			if($t['background'] == true) {
				if($t['background_opacity'] > 0) {
					($t['background_color'] != "") ? $bg_color = $t['background_color'] : $bg_color = '#FFFFFF';
				
					$final_background = '<div class="galleria_text_background" style="background:'.$bg_color.'; opacity:'.number_format($t['background_opacity']/100, 2, ".", ",").'; filter: alpha(opacity='.$t['background_opacity'].');"></div>';
				}
			}
			
			if($galleria_text_status == 1) {
				$galleria_text = '
					<div class="galleria_text" style="'.$final_position.'">
						'.$final_background.'
						<div class="galleria_text_inner">
							'.implode("", $galleria_text_content).'
						</div>
						'.clearer().'
					</div>
				';
			}
		}
		
		//debug($args);
		
		$return = createGalleria(array(
			'id'			=> 'galleria_'.$name,
			'images' 		=> getRepeaterIDs(array('data' => $images)),
			'options'		=> $o,
			'config'		=> $c,
			'col_w'			=> @$args['col_w'],
			'configs'		=> $args,
		));
		
		$return = '
			<div class="galleria_container img_rounded relative">
				'.$galleria_text.'
				<div>
					'.$return['images'].'
				</div>
			</div>
		';
	}
	
	$galleria_css = '';
	if(defined("GALLERIA_THUMBS_H")) {
		$galleria_css = '
			<style>
				.galleria-thumbnails-container,
				.galleria-thumbnails .galleria-image {
					height: '.GALLERIA_THUMBS_H.'px;
				}
			</style>
		';
	}
	
	$return = '
		'.setGapTop($args, @$e['edit_id']).'
	    <div class="relative">
	    	'.@$e['content'].'
	    	'.$return.'
	    </div>
	    '.$galleria_css.'
	    '.setGapBottom($args, @$e['edit_id']).'
	';
	
	++$i_galleria;
		
	return $return;
}

?>