<?php

$parallax_id = 0;

function createModuleParallax($args) {
	//debug($args);
	
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	global $parallax_id;
	
	if(isset($args['page_id'])) {
		$page_id = $args['page_id'];
	} else {
	    global $page_id;
	}
	
	
	$data = $args['m_parallax_content'][0];
	$o = $args['m_parallax_configs'][0];
	
	//debug($o);
	
	(isset($o['speed'])) 	? $speed = $o['speed'] 		: $speed = 10;
	(isset($o['offset'])) 	? $offset = $o['offset'] 	: $offset = 0;
	
	
	$e = addFrontpageEdit(array(
		'id' 			=> $page_id,
		'field'			=> $args['meta_key'],
		'center'		=> 1,
		'module_type'	=> 'parallax',
	));
	
	
	$object = '';
	$buttons = '';
	
	if($o['type'] == 'image') {
		$image_data 	= wp_get_attachment_image_src($data['image'], 'screen');
		$url 			= $image_data[0];
		$w 				= $image_data[1];
		$h 				= $image_data[2];
		
		$data_object_type = 'image';
		
		$object = '
			<img id="parallax_obj_inner_'.$parallax_id.'" class="parallax_obj_inner" src="'.$url.'" '.@$e['id'].' />
		';
	
	} else if($o['type'] == 'video' || $o['type'] == 'youtube') {
		global $videoplayer_id;
		
		if($o['type'] == 'video') {
			$url 	= wp_get_attachment_url($data['video']);
		
		} else if($o['type'] == 'youtube') {
			$url 	= $data['youtube'];
		}
		
		$w 		= $o['w'];
		$h 		= $o['h'];
		
		$image = '';
		if($data['image'] > 0) {
			$image 			= 'image: "'.wp_get_attachment_url($data['image']).'",';
		}
		
		$buttons = '
			<div class="btn_video hand" id="video_play_'.$videoplayer_id.'" onclick="jwplayer(\'videoplayer_'.$videoplayer_id.'\').play();">
			</div>
		';
		
		$autostart = 'false';
		if(isset($data['video_autostart']) && $data['video_autostart'] == 1) {
			$autostart = 'true';
		}
		
		
		$data_object_type = 'video';
		
		$object = '
			<div class="parallax_obj_inner" id="parallax_obj_inner_'.$parallax_id.'">
				<div id="videoplayer_'.$videoplayer_id.'" style="width:100%; height:100%;"></div>
			</div>
			
			<script type="text/javascript">
				var jwsetup = {
			    	modes: [
				  		{
				  		    provider: "http",
				  		    type: "flash",
				  		    src: "'.get_stylesheet_directory_uri().'/_jwplayer/player.swf",
				  		    config: {
				  		    	"levels": [{ file: "'.$url.'" }]
				  		    }
				  		},
				  		{
				  		    provider: "video",
				  		    type: "html5",
				  		    config: {
				  		        "levels": [{ file: "'.$url.'" }]
				  		    }
				  		},
				  	],
				  	'.$image.'
			    	smoothing				: false,
			    	autostart				: '.$autostart.',
			    	allowscriptaccess		: "always",
			    	height					: "100%",
			    	width					: "100%",
			    	icons					: false,
			    	controlbar				: "none",
			    	repeat					: "none",
			    	bufferlength			: 5,
			    	volume					: 100,
			    	stretching				: "uniform",
					skin					: "'.get_stylesheet_directory_uri().'/_jwplayer/skins/default.zip"
			    };
			    
			    jwplayer("videoplayer_'.$videoplayer_id.'").setup(jwsetup);
			    
			    jwplayer("videoplayer_'.$videoplayer_id.'").onPlay( function(event){
			    	$("#video_play_'.$videoplayer_id.'").fadeOut(300);
			    });
			    
			    jwplayer("videoplayer_'.$videoplayer_id.'").onPause( function(event){
			    	$("#video_play_'.$videoplayer_id.'").fadeIn(300);
			    });
			    
			    jwplayer("videoplayer_'.$videoplayer_id.'").onIdle( function(event){
			    	$("#video_play_'.$videoplayer_id.'").fadeIn(300);
			    });
			</script>
		';
				
		++$videoplayer_id;
		
	} else if($o['type'] == 'slideshow' && !empty($data['slideshow'])) {
		$data_object_type = 'slideshow';
		
		$images 	= getRepeaterIDs(array('data' => $data['slideshow'], 'key' => 'url'));
		$w 			= $data['slideshow'][0]['width'];
		$h 			= $data['slideshow'][0]['height'];
		
		//debug($data['slideshow']);
		
		$slideshow_images = array();
		foreach($images AS $image_url) {
			$slideshow_images[] = '{image: "'.$image_url.'"}';
		}
		
		$buttons = '
			<div class="btn_slideshow btn_slideshow_next hand" id="btn_next_'.$parallax_id.'"></div>
			<div class="btn_slideshow btn_slideshow_prev hand" id="btn_prev_'.$parallax_id.'"></div>
		';
		
		$object = '
			<div class="parallax_obj_inner" id="parallax_obj_inner_'.$parallax_id.'">
				<div id="slideshow_'.$parallax_id.'" style="width:100%; height:100%;"></div>
			</div>
			
			<script>
			    var data = ['.implode(",", $slideshow_images).'];
			    Galleria.run("#slideshow_'.$parallax_id.'", {
			    	dataSource			: data,
			    	id					: "slideshow_'.$parallax_id.'",
			    	width				: "100%",
			    	height				: "100%",
			    	initialTransition	: "fade",
			    	transition			: "slide",
			    	autoplay			: 2500,
			    	caroussel			: true,
			    	transitionSpeed		: 800,
			    	imageCrop			: true,
			    	lightbox			: false,
			    	imagePan			: false,
			    	showCounter			: false,
			    	showInfo			: false,
			    	showImagenav		: false,
			    	thumbnails			: false,
			    	wait				: true,
			    	extend: function() {
			    		var gallery = this;
			    		$("#btn_next_'.$parallax_id.'").click(function() {
			    			gallery.next();
			    		});
			    		$("#btn_prev_'.$parallax_id.'").click(function() {
			    			gallery.prev();
			    		});
			    	}
			    });
			</script>
		';
		
	}
	
	
	
	//data-offsetY="'.$offset.'" style="background-image: url('.$url.'); "
	
	if($object != "") {
		if(isMobile()) {
			$return = '
				<div class="relative">
					'.$object.'
				</div>
			';
			
		} else {
			$return = '
				<div class="relative parallax" id="parallax_'.$parallax_id.'" data-speed="'.$speed.'" data-type="background">
					'.@$e['content'].'
					<div class="relative parallax_obj" data-type="content" data-object-type="'.$data_object_type.'" data-w-orig="'.$w.'" data-h-orig="'.$h.'" data-w="'.$w.'" data-h="'.$h.'" data-speed="'.$speed.'" data-id="'.$parallax_id.'">
						'.$object.'
					</div>
					'.$buttons.'
				</div>
			';
		}
	}
	
	++$parallax_id;
	
	return $return;
}

?>