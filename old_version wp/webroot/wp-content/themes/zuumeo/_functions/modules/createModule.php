<?php

function createModule($args) {
	$data 		= $args['data'];
	$layout 	= $args['layout'];
	
	$GLOBALS['module_type'] = substr($layout, 2);
	$abs = false;
	//debug($data);
	
	//echo '<p>xxx'.$layout;
	
	if(isset($data['config_base'][0]['columns']) && !isset($data['col_w'])) {
		$data['col_w'] = getColumnWidth(array('columns' => $data['config_base'][0]['columns']));
		$data['class_col'] = 'col_'.$data['config_base'][0]['columns'];
	}
	
	
	if(isset($args['class_col'])) {
		$data['class_col'] = $args['class_col'];
	}
	
	
	if($layout == "m_columns" || $layout == "m_multi_column") {
		$return = createModuleColumns($data);
	
	} else if($layout == "m_flex") {
		$return = createModuleFlex($data);
	
	} else if($layout == "m_sidebars") {
		$return = createModuleSidebars($data);
	
	} else if($layout == "m_text") {
		$return = createModuleText($data);
	
	} else if($layout == "m_headline") {
		$return = createModuleHeadline($data);
	
	} else if($layout == "m_image") {
	    if(isset($data['m_image_content'][0]['misc'][0]['abs']) && $data['m_image_content'][0]['misc'][0]['abs'] == true) {
		    $abs = true;
		    $abs_top = $data['m_image_content'][0]['misc'][0]['abs_top'];
		    $abs_left = $data['m_image_content'][0]['misc'][0]['abs_left'];
	    }
	    
	    $return = createModuleImage($data);
	
	} else if($layout == "m_parallax") {
	    $return = createModuleParallax($data);
	
	} else if($layout == "m_360grad") {
	    $return = createModule360Grad($data);
	
	} else if($layout == "m_image_list") {
	    $return = createModuleImageList($data);
	
	} else if($layout == "m_content_list") {
	    $return = createModuleContentList($data);
	
	} else if($layout == "m_empty") {
	    $return = createModuleEmpty($data);
	
	} else if($layout == "m_partners") {
	    $return = createModulePartners($data);
	    
	} else if($layout == "m_downloads") {
	    $return = createModuleDownloads($data);
	    			
	} else if($layout == "m_video") {
	    $return = createModuleVideo($data);
	    
	} else if($layout == "m_gap") {
	    $return = clearer($data['gap']);
	
	} else if($layout == "m_line") {
	    $return = createModuleLine($data);
	
	} else if($layout == "m_safaris") {
	    $return = createModuleSafaris($data);
	
	} else if($layout == "m_news") {
	    $return = createModuleNews($data);
	
	} else if($layout == "m_formulare") {
	    $return = createForm($data);
	    			
	} else if($layout == "m_gallery") {
	    $return = createModuleGalleria($data);
	    
	} else if($layout == "m_showreel") {
	    $return = createModuleShowreel($data);
	    
	} else if($layout == "m_shortcode") {
	    $return = createModuleShortcode($data);
	    	    			
	} else {
	    if(isAdmin()) {
		    $return = 'Missing Module - Bitte an den Super-Admin wenden!';
		}
	}
	
	$return_position = 'relative';
	$return_position_values = '';
	
	(isset($args['m_l'])) ? $m_l = $args['m_l'] : $m_l = 0;
	(isset($args['m_r'])) ? $m_r = $args['m_r'] : $m_r = 0;
	
	if($abs == true) {
		$return_position = 'absolute';
		$return_position_values = 'z-index:10; top:'.$abs_top.'px; left:'.$abs_left.'px;';
	}
	
	if(isset($data['config_base'][0]['inactive']) && $data['config_base'][0]['inactive'] == true) {
		if(isAdmin()) {
			$return = '
				<div class="'.$return_position.' '.setModuleClass($data).' module_inactive"  style="'.$return_position_values.setModuleWidth($data).' margin:0px '.$m_r.'px 0px '.$m_l.'px;">
					<div class="absolute data_edit_button data_edit_inactive">Deaktiviert</div>
					'.$return.'
					'.clearer().'
				</div>
			';
			
			return $return; 
		}
			
	} else {
		$return = '
			<div class="'.$return_position.' '.setModuleClass($data).'"  style="height:100%; margin:0px '.$m_r.'px 0px '.$m_l.'px; '.$return_position_values.setModuleWidth($data).'">
				'.$return.'
				'.clearer().'
			</div>
		';
		
		return $return;	
	}
}

?>