<?php

add_shortcode('video', 'createModuleVideo');

$videoplayer_id = 1;

function createModuleVideo($args) {
	//debug($args);
	
	global $videoplayer_id;
	
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	
	
	if(isset($args['direct'])) {
		$o 				= array();
		$v 				= array();
		$f 				= array();
		$source 		= $args['source'];
		$v['embed'] 	= $args['url'];
		$o['w'] 		= $args['w'];
		$o['image'] 	= $args['image'];
		$o['h'] 		= $args['h'];
		$f['mp4'] 		= $args['video'];
	
	} else {
		$o 				= $args['m_video_configs'][0];
		$v 				= $args['m_video'][0];
		$f 				= $v['upload'][0];
		$source 		= $v['source'];
	}
	
	(isset($o['w']) && $o['w'] > 0) ? $w = $o['w'] : $w = 640;
	(isset($o['h']) && $o['h'] > 0) ? $h = $o['h'] : $h = 480;
	(isset($o['autostart'])) ? $autostart = '"'.$o['autostart'].'"' : $autostart = "false";
	
	$content_width = getColumnWidth($args);
	
	
	
	
	if($w > $content_width) {
		$h = ceil(($content_width * $h) / $w);
		$w = $content_width;
	}
	
	if(isset($args['col_w']) && $w > $args['col_w']) {
		$h = ceil(($args['col_w'] * $h) / $w);
		$w = $args['col_w'];
	}
	
	//debug($f);
	
	
	$videoplayer = '';
	$output = '';
	
	if($source == 'embed') {
		$pattern = "#(width|height)=[\'\"](\d)+[\'\"]#ies";
		$replace = "(strtolower('\\1')=='width') ? \"\\1='".$w."'\":\"\\1='".$h."'\"";
		
		$output = preg_replace($pattern, $replace, html_entity_decode($v['embed']));
				
	} else {
		$image = $image_end = '';
		if(isset($o['image']) && $o['image'] > 0) {
		   	$image = $image_end = 'image: "'.wp_get_attachment_url($o['image']).'",';
		}
		
		if(isset($o['image_end']) && $o['image_end'] > 0) {
		   	$image_end = 'image: "'.wp_get_attachment_url($o['image_end']).'",';
		}
			    
			    
		$videos = '';	
		$status = 0;
		$youtube = '';
		$controlbar = "bottom";
		$files = array();
		
		if($source == 'url') {
			$status = 1;
			//$videos = '<source src="'.$v['embed'].'" />';
			$final_file = $v['embed'];
			
			
			$files[] = '{ file: "'.$v['embed'].'" }';
		
		} else if($source == 'youtube') {
			if(getYoutubeIDFromURL($v['embed'])) {
				$final_file = $v['embed'];
				
				/* $controlbar = "none"; */
				$h = $h + 32;
				$status = 1;
				//$youtube = 'data-youtube-id="'.getYoutubeIDFromURL($v['embed']).'"';
				
				$files[] = '{ file: "'.$v['embed'].'" }';
			}
		
		} else {
			if(isset($f['mp4']) && $f['mp4'] != "") {
			  //$files[] = '<source src="'.wp_get_attachment_url($f['mp4']).'" />';
			  $final_file = wp_get_attachment_url($f['mp4']);
			  
			  $files[] = '{ file: "'.wp_get_attachment_url($f['mp4']).'", type: "video/mp4" }';
			}
			
			if(isset($f['ogg']) && $f['ogg'] != "") {
				//$files[] = '<source src="'.wp_get_attachment_url($f['mp4']).'" />';
				$final_file = wp_get_attachment_url($f['ogg']);
				
				$files[] = '{ file: "'.wp_get_attachment_url($f['ogg']).'", type: "video/ogv" }';
			}
			
			if(isset($f['webm']) && $f['webm'] != "") {
				//$files[] = '<source src="'.wp_get_attachment_url($f['mp4']).'" />';
				$final_file = wp_get_attachment_url($f['webm']);
				
				$files[] = '{ file: "'.wp_get_attachment_url($f['webm']).'", type: "video/webm" }';
			}
			
			if(empty($files)) {
			    $output = '
			    	<div class="">
			    		Keine Quelldateien angegeben oder hochgeladen!
			    	</div>
			    ';
			    
			} else {
			    $status = 1;
			    //$videos = implode("", $files);
			    $h = $h + 32;
			}
		}
		
		
		
		$w_box = $w.'px';
		$h_box = $h.'px';
		
		if(isset($o['full_width']) && $o['full_width'] == 1) {
			$w = $w_box = "100%";
			$h = $h_box = "100%";
		}
		
		
		$controlbar = 'none';
		if(isset($o['controls']) && $o['controls'] == 1) {
			$controlbar = 'bottom';
		}
		
		
		$icons = "false";
		if(isset($o['icons']) && $o['icons'] == 1) {
			$icons = 'true';
		}
		
		
		
		if($status == 1) {
			$path 		= 'levels: ['.implode(",", $files).']';
			
			$autostart = 'false';
			if(isset($o['autostart']) && $o['autostart'] == 1) {
				$autostart = 'true';
			}
			
			if(isAdmin()) {
				/* $controlbar = 'bottom'; */
				/* $icons = "true"; */
			}
			
			$output = '
				<div class="videoplayer" style="width:'.$w_box.'; height:'.$h_box.';">
					<div id="videoplayer_'.$videoplayer_id.'" style="width:100%; height:100%;">'.$output.'</div>
				</div>
				<script type="text/javascript">
					var jwsetup = {
						players: [
							{ type: "flash", src: "'.get_stylesheet_directory_uri().'/_jwplayer/player.swf" },
							{ type: "html5" }
				  		],
						'.$path.',
						'.$image.'
						smoothing				: true,
						autostart				: '.$autostart.',
						allowscriptaccess		: "always",
						height					: "'.$h.'",
						width					: "'.$w.'",
						icons					: '.$icons.',
						controlbar				: "'.$controlbar.'",
						repeat					: "none",
						bufferlength			: 4,
						volume					: 100,
						stretching				: "fill",
						skin					: "'.get_stylesheet_directory_uri().'/_jwplayer/skins/default/modieus.xml",
						events					: {
							onComplete: function(e){
								this.load({
									file: "'.$final_file.'",
									'.$image_end.'
								});
								this.stop();
							}
						}
					};
					
					jwplayer("videoplayer_'.$videoplayer_id.'").setup(jwsetup);
				</script>
			';
		}
	}
	
	
	$text = '';
	if(isset($o['text']) && trim($o['text']) != "") {
		$text = '
			'.clearer(8).'
			<div class="video_subtitle">'.trim($o['text']).'</div>
		';
	}
	
	
	if(isAdmin() & isset($args['meta_key'])) {
	    $e = addFrontpageEdit(array(
	    	'id' 		=> $page_id,
	    	'field'		=> $args['meta_key'],
	    	'type'		=> 'video',
	    ));
	}
	
	
	$return = '
		'.setGapTop($args, @$e['edit_id']).'
		<div class="relative" style="height:100%;">
			'.@$e['content'].'
			'.$output.'
		</div>
		'.$text.'
		'.clearer().'
		'.setGapBottom($args, @$e['edit_id']).'
	';
		
	++$videoplayer_id;
		
	return $return;
}

?>