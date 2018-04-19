<?php

function individole_cache() {
	if(file_exists(getCacheDir())) {
		$caches= array(
			'desktop'	=> array(
				'dir'		=> getCacheDir(),
			),
			'mobile'	=> array(
				'dir'		=> getCacheDir("mobile"),
			)
		);
		
		$infos = array();
		foreach($caches AS $c_key => $c_v) {
			$cache_dir = $c_v['dir'];	
			
			if(isset($_POST['individole_empty_cache']) && $_POST['individole_empty_cache'] == $c_key) {
				foreach(glob($cache_dir.'/*.html') as $file){
					if(is_file($file)) {
						unlink($file);
					}
				}
			}
			
			$i_files = 0;
			$sum_file_size = 0;
			
			$files = glob($cache_dir.'/*.html');
			
			if(!empty($files)) {
				foreach($files AS $file) {
					$file_size = filesize($file);
					
					$sum_file_size = bcadd($sum_file_size, $file_size);
					
					++$i_files;
				}
				
				$final_file_size = number_format((($sum_file_size/1024)/1024), 2, ",", ".");
				
				$infos[] = '
					<tr>
						<td>'.strtoupper($c_key).'</td>
						<td>'.$i_files.'</td>
						<td>'.$final_file_size.' MB</td>
						<td>'.$cache_dir.'</td>
						<td>
						<form action="" method="post">
							<input type="hidden" name="individole_empty_cache" value="'.$c_key.'">
							<input class="button button_small_individole" type="submit" value="'.strtoupper($c_key).' Cache leeren">
						</form>
						</td>
					</tr>
				';
			}
		}
	}
	
	if(isset($_POST['individole_cache_save_settings'])) {
		if(isset($_POST['cache_status'])) {
			update_option("individole_cache_status", 1);
		} else {
			update_option("individole_cache_status", 0);
		}
		
		update_option("individole_cache_time_desktop", $_POST['cache_time_desktop']);
		update_option("individole_cache_time_mobile", $_POST['cache_time_mobile']);
	}
	
	if(isset($_POST['cache_status']) || (!isset($_POST['individole_cache_save_settings']) && getCacheStatus())) {
		$checked_individole_status = 'checked';
	
	} else {
		$checked_individole_status = '';
	}
	
	
	$cache_time_options = array(
		'0'			=> 'Kein Cache anlegen',
		'36000'		=> '10 Stunden',
		'86400'		=> '1 Tag',
	);
	
	$cache_time_options_desktop = array();
	$cache_time_options_mobile = array();
	
	foreach($cache_time_options AS $k => $v) {
		$selected = '';
		
		if(isset($_POST['cache_time_desktop']) && $_POST['cache_time_desktop'] == $k) {
			$selected = 'selected';
		} else if(!isset($_POST['cache_time_desktop']) && getCacheTime() && getCacheTime() == $k) {
			$selected = 'selected';
		}
		$cache_time_options_desktop[] = '
			<option value="'.$k.'" '.$selected.'>'.$v.'</option>
		';
		
		
		$selected = '';
		if(isset($_POST['cache_time_mobile']) && $_POST['cache_time_mobile'] == $k) {
			$selected = 'selected';
		} else if(!isset($_POST['cache_time_mobile']) && getCacheTime("mobile") && getCacheTime("mobile") == $k) {
			$selected = 'selected';
		}
		$cache_time_options_mobile[] = '
			<option value="'.$k.'" '.$selected.'>'.$v.'</option>
		';
	}
	
	
	//!GENERATE CACHE-FILES
	$module_create_cache_files = '';
	if(isSuperAdmin()) {
		$siteurl 		= get_option("siteurl");
		$cache_dir		= getCacheDir();
		
		global $config_cpt;
		$config_cpt = sortArrayByKey($config_cpt, "name");
		$cache_generate_rows = array();
		$i = 0;
		foreach($config_cpt AS $cpt_key => $v) {
			if(isset($v['cache']) && $v['cache'] == true) {
				$loop_args = array( 
					'post_type' 		=> $cpt_key, 
					'posts_per_page' 	=> 999999,
					'orderby'			=> 'post_date',
					'order'				=> 'DESC',
					'post_status'		=> array('publish'),
				);
		
				$loop = new WP_Query( $loop_args );
				
				$count_caches = 0;
				$count_posts = 0;
				foreach($loop->posts AS $post) {
					$permalink 	= get_permalink($post->ID);
					$permalink 	= str_replace($siteurl, "", $permalink);
					$file 		= $cache_dir.'/'.urlencode($permalink).'.html';
					$nocache 	= get_post_meta($post->ID, get_option("individole_praefix_seo").'_0_cache', true);
		    
					if($nocache != 1) {
						++$count_posts;
					}
					
					if(file_exists($file)) {
						++$count_caches;
					}
				}
				
				$class = '';
				if($i%2 == 0) {
					$class = 'alternate';
				}
				
				$cache_generate_rows[] = '
					<tr class="'.$class.'">
						<td>'.$v['name'].'</td>
						<td>'.$count_posts.'</td>
						<td>'.$count_caches.'</td>
						<td>
							<div id="cache_'.$cpt_key.'_buttons">
								<div class="button button_small_individole" onclick="admin_create_cache({post_type:\''.$cpt_key.'\', posts_per_page:1, ids:\'\'})">1</div>
								<div class="button button_small_individole" onclick="admin_create_cache({post_type:\''.$cpt_key.'\', posts_per_page:3, ids:\'\'})">3</div>
								<div class="button button_small_individole" onclick="admin_create_cache({post_type:\''.$cpt_key.'\', posts_per_page:10, ids:\'\'})">10</div>
								<div class="button button_small_individole" onclick="admin_create_cache({post_type:\''.$cpt_key.'\', posts_per_page:99999, ids:\'\'})">Alle</div>
							</div>
						</td>
						<td>
							<div id="cache_'.$cpt_key.'_progress" style="height: 3px; width: 1px; background:red; margin:11px 0px 0px 0px;"></div>
						</td>
						<td id="cache_'.$cpt_key.'_count">0</td>
					</tr>
				';
				
				++$i;
			}
		}
		
		$module_create_cache_files = '
		    '.clearer(25).'
		    <h3>Cache-Files generieren (published posts only)</h3>
		    <table class="wp-list-table widefat fixed posts" cellspacing="0" style="float:left; width:auto;">
		        <thead>
		        	<th>Post Type</th>
					<th># Posts</th>
					<th># Caches</th>
					<th>Caches generieren</th>
					<th style="width: 150px;">Progress</th>
					<th style="width: 40px;"></th>
				</thead>
				<tbody>
					'.implode("", $cache_generate_rows).'
				</tbody>
		    </table>
		    <div id="cache_info" style="float: left; margin-left: 20px;">?</div>
		    '.clearer().'
		    <div class="hidden" id="admin_btn_cancel_cache">
		        '.clearer(10).'
		        <div class="left button acf-button" onclick="admin_cancel_cache()">Abbrechen</div>
		    </div>
		';
	}
	
	
	$return = '
		<div class="wrap">
			<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br></div>
			<h2>Individol&eacute; / Cache Management</h2>
			'.individole_menu().'
			<h3>Einstellungen</h3>
			<form action="" method="post">
			<table class="wp-list-table widefat fixed posts" cellspacing="0" style="width:auto;">
				<tr>
					<th>Cache aktivieren</th>
					<td>
						<input type="checkbox" name="cache_status" '.$checked_individole_status.'>
					</td>
				</tr>
				<tr>
					<th>Cache-Dauer Desktop</th>
					<td>
						<select name="cache_time_desktop">
							'.implode("", $cache_time_options_desktop).'
						</select>
					</td>
				</tr>
				<tr>
					<th>Cache-Dauer Mobile</th>
					<td>
						<select name="cache_time_mobile">
							'.implode("", $cache_time_options_mobile).'
						</select>
					</td>
				</tr>
			</table>
			'.clearer(10).'
			<input type="hidden" name="individole_cache_save_settings" value="1">
			<input class="button acf-button" type="submit" value="Einstellungen speichern">
			</form>
			'.clearer(25).'
			<h3>Aktueller Cache-Inhalt</h3>
			<table class="wp-list-table widefat fixed posts" cellspacing="0" style="width:auto;">
				<thead>
				<tr>
					<th>Cache</th>
					<th># Dateien</th>
					<th>Größe</th>
					<th>Cache-Ordner</th>
					<th>&nbsp;</th>
				</tr>
				</thead>
				<tbody>
					'.implode("", $infos).'
				</tbody>
			</table>
			'.$module_create_cache_files.'
		</div>
	';
		
	echo $return;
}

?>