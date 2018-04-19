<?php

$i_module = 0;

function createPageModules($args) {
	if(function_exists("get_field")) {
		global $i_module;
		
		if(isset($args['page_id'])) {
			$page_id = $args['page_id'];
		} else {
			$page_id = $GLOBALS['page_id'];
		}
		
		
		$content = array();
		$fields = get_field('page_content', $page_id);
		
		//debug($args);
		
		if(!empty($fields)) {
			$i_module = 0;
			$i_field = 0;
			foreach($fields AS $data_value) {
				$layout = $data_value['acf_fc_layout'];
				
				$config_base_module = $data_value['config_base_'.str_replace("m_", "", $layout)];
				$data_value['config_base'] = $config_base_module;
				unset($data_value['config_base_'.str_replace("m_", "", $layout)]);
				
				
				//debug($args);
				
				if(isset($args['col_w'])) {
					$data_value['col_w'] = $args['col_w'];
				}
				
				
				$data_value['meta_key'] = 'page_content_'.$i_module;
				$data_value['i_module'] = $i_module;
				$data_value['page_id'] = $page_id;
				
				
				$module_content = createModule(array(
					'data'		=> $data_value,
					'layout'	=> $layout,
				));
				
				if($module_content != "") {
					$content[] = '
						<div>
							'.$module_content.'
						</div>
					';
					
					++$i_field;
					++$i_module;
				}
			}
			
			
		}
		
		$return = implode("", $content);
		
		return $return.clearer();
	}
}

?>