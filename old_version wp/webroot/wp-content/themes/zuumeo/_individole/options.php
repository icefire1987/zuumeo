<?php

function individole_options() {
	$c = array(
		'wp_debug'					=> array(
			'title'						=> 'DEV &raquo; WP DEBUG',
			'default'					=> 1,
			'type'						=> 'true_false',
		),
		
		'show_dev_version'			=> array(
			'title'						=> 'DEV &raquo; Show developer version to default admins',
			'default'					=> 1,
			'type'						=> 'true_false',
		),
		
		'admin_grid'				=> array(
			'title'						=> 'Raster &raquo; Show Grid Option',
			'default'					=> 1,
			'type'						=> 'true_false',
		),
		
		'responsive'				=> array(
			'title'						=> 'Responsive',
			'default'					=> 1,
			'type'						=> 'true_false',
		),
		
		'admin_grid_difference'		=> array(
			'title'						=> 'Raster &raquo; Admin Grid Difference',
			'default'					=> 0,
		),
		
		'admin_grid_color'			=> array(
			'title'						=> 'Raster &raquo; Grid Farbe',
			'default'					=> "#dddddd",
			'type'						=> 'text',
		),
		
		'admin_grid_color_module'	=> array(
			'title'						=> 'Raster &raquo; Grid Farbe Module',
			'default'					=> "#dddddd",
			'type'						=> 'text',
		),
		
		'col_w'						=> array(
			'title'						=> 'Raster &raquo; Spalten &raquo; Breite',
			'default'					=> 47,
		),							
									
		'col_w_full'				=> array(
			'title'						=> 'Raster &raquo; Spalten &raquo; Breite (au&szlig;en)',
			'default'					=> 70,
		),							
									
		'col_w_inner'				=> array(
			'title'						=> 'Raster &raquo; Spalten &raquo; Breite (innen)',
			'default'					=> 47,
		),							
									
		'col_w_mobile'				=> array(
			'title'						=> 'Raster &raquo; Spalten &raquo; Breite Mobile',
			'default'					=> 29,
		),							
									
		'col_w_mobile_full'			=> array(
			'title'						=> 'Raster &raquo; Spalten &raquo; Breite Mobile (au&szlig;en)',
			'default'					=> 29,
		),							
									
		'col_w_mobile_inner'		=> array(
			'title'						=> 'Raster &raquo; Spalten &raquo; Breite Mobile (innen)',
			'default'					=> 29,
		),							
									
		'col_w_facebook'			=> array(
			'title'						=> 'Raster &raquo; Spalten &raquo; Breite (Facebook Tab App)',
			'default'					=> 45,
		),
		
		'col_gap'					=> array(
			'title'						=> 'Raster &raquo; Spalten &raquo; Abstand (horizontal)',
			'default'					=> 36,
		),							
									
		'col_gap_response'			=> array(
			'title'						=> 'Raster &raquo; Spalten &raquo; Abstand Response (horizontal)',
			'default'					=> 24,
		),							
									
		'col_gap_mobile'			=> array(
			'title'						=> 'Raster &raquo; Spalten &raquo; Abstand Mobile (horizontal)',
			'default'					=> 22,
		),							
									
		'module_gap'				=> array(
			'title'						=> 'Raster &raquo; Module &raquo; Abstand (vertikal)',
			'default'					=> 0,
		),							
									
		'col_w_right'				=> array(
			'title'						=> 'Raster &raquo; Rechte Spalte',
			'default'					=> 0,
		),							
									
		'col_w_left'				=> array(
			'title'						=> 'Raster &raquo; Linke Spalte',
			'default'					=> 0,
		),							
									
		'col_gap_artikel'			=> array(
			'title'						=> 'Raster &raquo; Artikel &raquo; Abstand',
			'default'					=> 12,
		),							
									
		'module_p_left'				=> array(
			'title'						=> 'Raster &raquo; Module &raquo; Padding (links)',
			'default'					=> 0,
		),							
									
		'module_p_right'			=> array(
			'title'						=> 'Raster &raquo; Module &raquo; Padding (rechts)',
			'default'					=> 0,
		),							
									
		'w_slideshow_thumb'			=> array(
			'title'						=> 'Slideshow &raquo; Thumbnail Breite',
			'default'					=> 50,
		),							
									
		'w_slideshow_thumb_mobile'	=> array(
			'title'						=> 'Slideshow &raquo; Thumbnail Breite (Mobilversion)',
			'default'					=> 100,
		),							
									
		'image_padding'				=> array(
			'title'						=> 'Raster &raquo; Image &raquo; Padding',
			'default'					=> 0,
		),
		
		'shadowbox_overlay_color'	=> array(
			'title'						=> 'Shadowbox &raquo; Overlay Farbe (HEX)',
			'default'					=> "#000000",
			'type'						=> 'text',
		),
		
		'shadowbox_overlay_opacity'	=> array(
			'title'						=> 'Shadowbox &raquo; Overlay Opacity (0-1)',
			'default'					=> "0.7",
			'type'						=> 'text',
		),
		
		'form_gap'					=> array(
			'title'						=> 'Formulare &raquo; Gap (Zeilen)',
			'default'					=> 10,
		),
		
		'form_gap_textarea'			=> array(
			'title'						=> 'Formulare &raquo; Gap (Zeile mehrzeiliges Textfeld)',
			'default'					=> 20,
		),
		
		'praefix_seo'				=> array(
			'title'						=> 'Pr&auml;fix SEO',
			'default'					=> 'seo',
			'type'						=> 'text',
		),
		
		'google_analytics_code'		=> array(
			'title'						=> 'Google Analytics Code',
			'default'					=> '',
			'type'						=> 'text',
		),
		
		'facebook_share_api'		=> array(
			'title'						=> 'Facebook Share API Key',
			'default'					=> '',
			'type'						=> 'text',
		),
	);
	
	$rows = array();
	$i = 0;
	foreach($c AS $k => $v) {
		if(isset($_POST['individole_options_save_settings'])) {
			if(isset($v['type']) && $v['type'] == 'true_false') {
				if(isset($_POST['individole_'.$k])) {
					$update_value = "1";
					
				} else {
					$update_value = "0";
				}
				
			} else {
				$update_value = $_POST['individole_'.$k];
			}
			
			update_option("individole_".$k, $update_value);
		}
		
		$value = get_option("individole_".$k);
		if($value === false) {
			$value = $v['default'];
		}
		
		(isset($v['title'])) ? $title = $v['title'] : $title = '???';
		(isset($v['type'])) ? $type = $v['type'] : $type = 'number';
		
		if($type == 'true_false') {
			$checked = '';
			if($value == "1") {
				$checked = 'checked';
			}
			$input = '<input type="checkbox" name="individole_'.$k.'" '.$checked.'>';
			
		} else {
			$input = '<input type="'.$type.'" name="individole_'.$k.'" value="'.$value.'">';
		}
		
		$class = '';
		if($i%2 == 0) {
		    $class = 'alternate';
		}
		
		$rows[] = '
			<tr class="'.$class.'">
				<th>'.$title.'</th>
				<td>'.$input.'</td>
				<td>getIndividoleOption("'.$k.'")</td>
			</tr>
		';
		
		++$i;
	}
	
	$return = '
		<div class="wrap">
			<h2>Individol&eacute; / Seiten-Einstellungen</h2>
			'.individole_menu().'
			<form action="" method="post">
			<table class="wp-list-table widefat fixed posts" cellspacing="0" style="width:auto;">
				<thead>
					<th>Bezeichnung</th>
					<th>Wert</th>
					<th>Aufruf</th>
				</thead>
				<tbody>
					'.implode("", $rows).'
				</tbody>
			</table>
			'.clearer(10).'
			<input type="hidden" name="individole_options_save_settings" value="1">
			<input class="button acf-button" type="submit" value="Einstellungen speichern">
			</form>
		</div>
	';
	
	echo $return;
}

?>