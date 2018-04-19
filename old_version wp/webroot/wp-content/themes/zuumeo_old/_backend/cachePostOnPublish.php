<?php

//function cachePostOnPublish() {
//	if(isset($_POST['post_ID']) && $_POST['post_ID'] > 0) {
//		global $config_cpt;
//		
//		//debug($_POST);
//		//debug($config_cpt);
//		
//		$siteurl 		= get_option("siteurl");
//		$cache_dir 		= dirname(ABSPATH).'/cache_test';
//		$post_type		= get_post_type($_POST['post_ID']);
//		
//		$permalink 		= get_permalink($_POST['post_ID']);
//		$permalink 		= str_replace($siteurl, "", $permalink);
//		
//		$file_get_contents_url = $siteurl.$permalink.'?nocache=1';
//		
//		$content = file_get_contents($file_get_contents_url);
//		
//		$file = $cache_dir.'/'.urlencode($permalink).'.html';
//		
//		file_put_contents($file, $content);
//		chmod($file, 0777);
//	}
//}
//add_action('save_post', 'cachePostOnPublish');

?>