#!/usr/local/bin/php
<?php

$wp_root = '/is/htdocs/wp11206237_BTZHRKPEXO/www/zuumeo.de/live/webroot';
$wp_template = $wp_root.'/wp-content/themes/zuumeo';
$wp_domain = "http://www.zuumeo.com";

include($wp_root."/wp-config.php");

$post_types = array(
	'page'			=> array(
		'prio'			=> '1.0',
		'orderby'		=> 'menu_order',
		'order'			=> 'ASC',
	),
);

$languages = array(
	'de'	=> 'sitemap.xml',
);

foreach($languages AS $language => $language_file) {
	$sitemap = array();
	
	foreach($post_types AS $post_type => $v) {
		(isset($v['orderby'])) 		? $orderby = $v['orderby'] 			: $orderby = 'post_date';
		(isset($v['order'])) 		? $order = $v['order'] 				: $order = 'DESC';
		(isset($v['prio'])) 		? $prio = $v['prio'] 				: $prio = '1.0';
		(isset($v['changefreq'])) 	? $changefreq = $v['changefreq'] 	: $changefreq = 'weekly';
		
		$loop_args = array( 
			'post_type' 		=> $post_type, 
			'posts_per_page' 	=> 9999999,
			'orderby'			=> $orderby,
			'order'				=> $order,
			'post_status'		=> array('publish'),
			'lang'				=> $language,
		);
		
		$loop = new WP_Query( $loop_args );
		
		foreach($loop->posts AS $post) {
			$post_id 			= $post->ID;
			$post_modified 		= get_the_modified_date("Y-m-d");
			$post_prio			= get_post_meta($post_id, 'meta_0_sitemap', true);
			$post_changefreq	= get_post_meta($post_id, 'meta_0_changefreq', true);
			$post_noindex		= get_post_meta($post_id, 'meta_0_noindex', true);
			
			$final_prio = $prio;
			if($post_prio != "") {
				$final_prio = $post_prio;
			}
			
			if($final_prio > 0) {
				$permalink 			= get_permalink($post_id);
								
				if(isset($_SERVER['SHELL'])) {
					$permalink 		= str_replace("http:", "", $permalink);
					$permalink 		= $wp_domain.str_replace($wp_domain, "", $permalink);	
				}
							
				
				$final_changefreq = $changefreq;
				if($post_changefreq != "") {
					$final_changefreq = $post_changefreq;
				}
				
				if($post_noindex != 1) {
					$entry = '<url><loc>'.$permalink.'</loc><lastmod>'.$post_modified.'</lastmod><changefreq>'.$final_changefreq.'</changefreq><priority>'.$final_prio.'</priority></url>';
				
					$sitemap[] = $entry;
				}
			}
		}
	}
	
	$content = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.implode("", $sitemap).'</urlset>';
	
	//echo $content;
	
	$xml_file = $wp_root.'/'.$language_file;
	$fh = fopen($xml_file, 'w') or die("can't open file");
	fwrite($fh, $content);
	fclose($fh);
	chmod($xml_file, 0755);
}

?>