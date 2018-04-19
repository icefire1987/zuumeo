<?php

//$current_m_column_columns = 12;

function createModuleColumns($args) {
	//global $current_m_column_columns;
	
	//debug($args);
	
	if(isset($args['m_columns_content']) || isset($args['m_multi_column_content'])) {
		if(isset($args['page_id'])) {
			$page_id = $args['page_id'];
		} else {
			global $page_id;
		}
		
		if(isset($args['m_columns_content'])) { 
			$final_columns_content = $args['m_columns_content'];
			
		} else {
			$final_columns_content = $args['m_multi_column_content'];
		}
		
		if(isAdmin() & isset($args['meta_key'])) {
			$e = addFrontpageEdit(array(
	    		'id' 			=> $page_id,
	    		'field'			=> $args['meta_key'],
	    		'columns'		=> 1,
	    		'module_type'	=> 'columns',
	    		'label'			=> 'Spalten',
	    	));
	    }
	    
	    
		$columns = array();
		$amount_columns = sizeof($final_columns_content);
		$amount_grid = 0;
		$i_column = 0;
		$i_field = 0;
		foreach($final_columns_content AS $data_key => $data_value) {
			$args['i_col'] = $i_column + 1;
			
			//$text = do_shortcode($text_value['text']);
			
			//$text = apply_filters("the_content", $text_value['text']);
			
			$layout = $data_value['acf_fc_layout'];
			
			$config_base_layout = 'config_base_'.str_replace("m_", "", $layout);
			
			if(isset($data_value[$config_base_layout])) {
				$data_value['config_base'] = $data_value[$config_base_layout];
				unset($data_value[$config_base_layout]);
			}
			
			//debug($data_value);
			
			
			//$e = createLiveEdit(array(
			//	"field"		=> 'content_modules_'.$args['id'].'_texts_'.$i_column.'_text',
			//	"type"		=> 'wysiwyg',
			//	"label"		=> 'Text/Spalteninhalt',
			//));
			
			
			if(isset($args['config_base'][0]['column_gap']) && $args['config_base'][0]['column_gap'] != "default") {
				if($args['config_base'][0]['column_gap'] == "empty") {
					$gap = 0;
				} else {
					$gap = $args['config_base'][0]['column_gap'];
				}
				
			} else {	
				$gap = COL_GAP;
			}
			
			
			$content_width = getColumnWidth($args);
			
			//debug($args);
			
			$grid = array();
			if(isset($args['config_base'][0]['grid']) && $args['config_base'][0]['grid'] != 'default') {
				$grid = explode("-", $args['config_base'][0]['grid']);
			}
			
			$amount_grid = sizeof($grid);
			
						
			
			$col_gap = $gap;
			if($i_column%$amount_columns == $amount_columns-1) {
				$col_gap = 0;
			}
			
			
			$col_w_grid = ($content_width - (11 * $gap)) / 12;
			
			$error_clearer = '';
			
			if(!empty($grid)) {
				//$current_m_column_columns = $grid[$i_column];
				
				$max_content_width = $content_width;
				
				if($i_column%$amount_grid== $amount_grid-1) {
					$col_gap = 0;
				}
				
				
				////$max_content_width = $content_width - ($gap * intval($amount_columns-1));
				//$max_content_width = $content_width - ($gap - ($gap * ($percent/100)));
				//
				//$col_w = floor($max_content_width);
				if(isset($grid[$i_column])) {
					$col_w = floor(($col_w_grid * $grid[$i_column]) + (($grid[$i_column]-1) * $gap));
					
				} else {
					if($i_column == $amount_grid) {
						$error_clearer = clearer(intval(getOptionNumber("column_gap")));
					}
					
					$amount_cols_rest = 12/($amount_columns - $amount_grid);
					
					$col_w = floor(($col_w_grid * $amount_cols_rest) + (($amount_cols_rest-1) * $gap));
				}
				
				
				if($i_column%$amount_columns == $amount_columns-1) {
					$gap = 0;
				}
				
				//debug($gap);
				
			} else {
				$max_content_width = $content_width - ($gap * intval($amount_columns-1));
				
				$col_w = floor($max_content_width / $amount_columns);
			}
			
			
			$data_value['col_w'] = $col_w;
			//$data_value['col_w'] = $col_w;
			
			$data_value['meta_key'] = 'page_content_'.$args['i_module'].'_m_columns_content_'.$i_column;
			$data_value['page_id'] = $page_id;
			
			$m_r = floor($gap/2);
			$m_l = floor($gap/2);
			if($i_column == 0) {
				$m_l = 0;
			}
			
			$class_col_gap = 'col_gap';
			if($i_column == sizeof($final_columns_content)-1) {
				$class_col_gap = '';
				$m_r = 0;
			}
			
			if(isset($grid[$i_column])) {
				$class_col = 'col_'.$grid[$i_column];
			
			} else {
				$class_col = 'col_'.floor(12/sizeof($final_columns_content));
			}
			
			//debug($data_value);
			
			$column_content = createModule(array(
				'data'			=> $data_value,
				'layout'		=> $layout,
				'class_col'		=> $class_col,
				/* 'm_r'		=> $m_r, */
				/* 'm_l'		=> $m_l, */
			));
			
			$test = '<p>i_column: '.$i_column.'<br>content_width: '.$content_width.'<br>max_content_width: '.$max_content_width.'<br>col_w: '.$col_w.'<br>gap: '.$gap.'<br>col_gap: '.$col_gap.'<br>amount_columns: '.$amount_columns.'<br>col_w_grid: '.$col_w_grid.'<br>amount_grid: '.$amount_grid.'<br>grid: '.implode("-", $grid);
			$test = '';
			
			$columns[] = '
				'.$error_clearer.'<div id="data_column_'.@$e['edit_id'].'_'.$i_column.'" class="module_column left '.$class_col.' '.$class_col_gap.'">
					'.$column_content.'
				</div>
			';
			
			
			++$i_field;
			++$i_column;
		}
		
		
		$return = '
			'.setGapTop($args, @$e['edit_id']).'
			'.setColumnGridError($amount_columns, $amount_grid).'
			<div class="relative">
				'.@$e['content'].'
				'.implode("", $columns).'
				<input type="hidden" id="data_columns_cols_'.@$e['edit_id'].'" value="'.sizeof($final_columns_content).'">
				'.clearer().'
			</div>
			'.clearer().'
			'.setGapBottom($args, @$e['edit_id']).'
		';
		
		return $return;
	}
}

?>