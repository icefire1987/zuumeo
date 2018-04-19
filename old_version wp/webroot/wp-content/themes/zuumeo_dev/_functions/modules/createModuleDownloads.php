<?php

function createModuleDownloads($args) {
	//debug($args);
	
	$downloads = $args['m_downloads_content'];
	
	if(!empty($downloads)) {
		$rows = array();
		foreach($downloads AS $download) {
			$o = $download['options'][0];
			
			$title 			= $o['title'];
			$file_id 		= $download['file'];
			
			$mime 			= getFiletypeByMime(get_post_mime_type($file_id));
			$file 			= wp_get_attachment_url($file_id);
			
			$link = '<a href="'.$file.'" class="a_download" target="_blank">';
			
			$rows[] = '
				<div class="download">
					'.$link.$title.' ('.strtoupper($mime).')</a>
				</div>
			';
		}
		
		$return = implode("", $rows);
		
		return $return;
	}
}

?>