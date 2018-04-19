<?php


function createModuleFlex($args) {
	//debug($args);
	
	if(isset($args['m_flex_content'])) {
		if(isset($args['page_id'])) {
			$page_id = $args['page_id'];
		} else {
			global $page_id;
		}
		
		
		$content = array();
		
		if(!empty($args['m_flex_content'])) {
			$i_flex = 0;
			foreach($args['m_flex_content'] AS $data_value) {
				$layout = $data_value['acf_fc_layout'];
				
				if(isset($args['col_w'])) {
					$data_value['col_w'] = $args['col_w'];
				}
				
				$class_col = 'col_12';
				if(isset($args['class_col'])) {
					$class_col = $args['class_col'];
				}
				
				$config_base_layout = 'config_base_'.str_replace("m_", "", $layout);
			
				if(isset($data_value[$config_base_layout])) {
					$data_value['config_base'] = $data_value[$config_base_layout];
					unset($data_value[$config_base_layout]);
				}
				
				
				//debug($data_value);
				
				
				$data_value['meta_key'] = $args['meta_key'].'_m_flex_content_'.$i_flex;
				$data_value['page_id'] = $page_id;
				
				$content[] = createModule(array(
					'data'			=> $data_value,
					'layout'		=> $layout,
					'class_col'		=> $class_col,
				));
				
				++$i_flex;
			}
		}
		
		
		$return = '
			'.implode("", $content).'
			'.clearer().'
		';
		
		return $return;
	}
}

?>