<?php

$module_id = 1;

function createModuleImage($args) {
	global $module_id;
	
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	//debug($args);
	
	$data = $args['m_image_content'][0];
	$o = $data['misc'][0];
	
	//debug($o);
	
	$image_data 		= wp_get_attachment_image_src($data['image'], 'full');
	$image_data_full 	= wp_get_attachment_image_src($data['image'], 'full');
	$url 				= $image_data[0];
	$w = $w_img 		= $image_data[1];
	$h_img 				= $image_data[2];
	
	$content_width = getColumnWidth($args);
	
	if($w > $content_width) {
		$w = $content_width;
	}
	
	if(isset($args['col_w']) && $w > $args['col_w']) {
		$w = $args['col_w'];
	}
	
	$image_data_best = getBestImageSource(array(
		'w'		=> $w,
		'id'	=> $data['image'],
	));
	
	
	if($image_data_best) {
		$url = $image_data_best[0];
	}
	
	
	$shadow = '';
	if(isset($o['shadow']) && $o['shadow'] == true) {
		$shadow = 'shadow';
	}
	
	if(isset($args['meta_key'])) {
		$e = addFrontpageEdit(array(
		    'id' 		=> $page_id,
		    'field'		=> $args['meta_key'],
		    'type'		=> 'image',
		));
	}
	
	$w = '100%';
	if(isset($o['scale'])) {
		if($o['scale'] > 100) {
			$o['scale'] = 100;
			
		} else if($o['scale'] < 0) {
			$o['scale'] = 0;
		}
		
		if($o['scale'] > 0 && $o['scale'] <= 100) {
			$w = $o['scale'].'%';
		}
	}
	
	
	$alignment = '';
	if(isset($o['alignment'])) {
		if($o['alignment'] == 'center') {
			$alignment = 'margin: 0 auto;';
			
		} else if($o['alignment'] == 'right') {
			$alignment = 'float: right;';
		}
	}
	
	
	$final_image = '<img src="'.$url.'" style="display:block; '.$alignment.' width:'.$w.';" class="'.$shadow.'" '.@$e['id'].' />';
	$final_link = '';
	
	$link = "";
	$shadowbox = '';
	if(isset($o['page']) && is_numeric($o['page']) && $o['page'] > 0) {
		$link = get_permalink($o['page']);
	
	} else if(isset($o['link']) && $o['link'] != "") {
		$link = formatLink($o['link']);
	
	} else if(isset($o['zoom']) && $o['zoom'] == true) {
		$shadowbox = 'rel="shadowbox[]"';
		$link = $image_data_full[0];
	}
	
	//debug($o);
	
	if($link != "") {
		$final_image = '<a href="'.$link.'" '.setLinkExternal($link).' '.$shadowbox.' id="data_href_'.@$e['edit_id'].'">'.$final_image.'</a>';
		
		$final_link = '
			'.clearer(5).'
			<a href="'.$link.'" '.setLinkExternal($link).' class="btn_more">'.$link.'</a>
		';
	}
	
	
	$title = '';
	if(isset($o['text']) && trim($o['title']) != "") {
		$title = '
			<div class="image_text">
				'.trim($o['title']).'
			</div>
		';
	}
	
	
	$return = '
		'.setGapTop($args, @$e['edit_id']).'
		<div class="relative img_rounded null" id="module_'.$module_id.'">
			'.@$e['content'].$final_image.'
		</div>
		'.$title.'
		'.setGapBottom($args, @$e['edit_id']).'
	';
		
	
	++$module_id;
	
	return $return;
}

?>