<?php

function createMailBody($args) {
	$return = array();
	
	$options 				= getOptions();
	$options_admin	 		= $options['admin'];
	$options_numbers 		= $options['numbers'];
	$options_words 			= $options['words'];
	$options_clauses 		= $options['clauses'];
	$options_texts 			= $options['texts'];
	$options_files 			= $options['files'];
	$options_colors 		= $options['colors'];
	$options_galleries 		= $options['galleries'];
	$options_status 		= $options['status'];
	$options_pages 			= $options['pages'];
	
	$theme_path = getThemePath();
	
	(isset($args['language'])) ? $lang = $args['language'] : $lang = 'de';
	(isset($args['w'])) ? $w = $args['w'] : $w = 700;
	(isset($args['p_width'])) ? $p_width = $args['p_width'] : $p_width = 0;

	$base_text_style = 'font-family: Verdana, Trebuchet MS, sans-serif;	font-size: 13px; line-height: 1.4em; color: #666660; text-rendering: optimizeLegibility;';
	
	$style_navi = 'font-family: Trebuchet MS, Arial, sans-serif; font-size:13px; line-height:1.0em; color: #666660; text-transform:uppercase; text-rendering: optimizeLegibility; letter-spacing: 1px;';
	
	$style_footer = 'font-family: Verdana, Arial, sans-serif; font-size:11px; line-height:1.3em; color: #666660; text-rendering: optimizeLegibility;';
	
	
	if($p_width > 0) {
		$base_text_style .= ' width:'.$p_width.'px;';
	}
	
	$h1_text_style = 'font-family: Verdana, Trebuchet MS, sans-serif; font-size: 18px; line-height: 1.2em; font-weight: normal; color: #666660; padding: 0px 0px 16px 0px;';

	
	
	$final_text_plain = $args['text_plain'];
	
	$loop_args = array( 
	    'post_type' 		=> 'kategorien', 
	    'posts_per_page' 	=> 9999999,
	    'orderby'			=> 'menu_order',
	    'order'				=> 'ASC',
	    'lang'				=> $lang,
	    'post_parent'		=> 0,
	    'post_status'		=> array('publish'),
	);
	
	$loop = new WP_Query( $loop_args );
	
	
	//debug($loop->posts);
	
	$array_navi = array();
	foreach($loop->posts AS $post) {
		$post_id 		= $post->ID;
		$post_title 	= $post->post_title;
		$post_type		= get_post_type($post_id);
		
		$permalink		= getPermalink(array(
			'post_id'		=> $post_id,
			'post_type'		=> $post_type,
		));
	
		$array_navi[] = '
			<td style="text-align: center; padding: 10px 0px 10px 0px; white-space:nowrap;" nowrap>
				<a href="'.$permalink.'">'.strtoupper($post_title).'</a>
			</td>
		';
	}
	
	$w_gap = floor(100 / (sizeof($array_navi)-1));
	$navi = implode('<td style="width: '.$w_gap.'%;">&nbsp;</td>', $array_navi);
	
	$navi = str_replace('<a ', '<a style="text-decoration:none; '.$style_navi.'" ', $navi);
	$navi = str_replace('<p', '<p style="'.$style_navi.'" ', $navi);
	
	
	$footer = $options_texts[$lang]["formulare_footer"];
	$footer = str_replace('<a ', '<a style="text-decoration:none; '.$style_footer.'" ', $footer);
	$footer = str_replace('<p', '<p style="text-align:center; '.$style_footer.'" ', $footer);
	
	$share_buttons = '';
	//if(isset($args['page_id'])) {
	//	$share_buttons = '
	//		<div style="margin: 20px 0px 0px 0px; padding: 20px 0px 5px 0px; border-top: 1px solid #666660; overflow:hidden;">
	//			Teilen &raquo; '.createSharingOptions(array(
	//				'page_id'			=> $args['page_id'],
	//				'hide_pinterest'	=> true,
	//				'hide_googleplus'	=> true,
	//				'image'				=> @$args['image'],
	//			)).'
	//		</div>
	//	';
	//}
	
		
	$f_text_html = $args['text_html'];
	$f_text_html = str_replace('<p', '<p style="margin: 0px 0px 12px 0px; '.$base_text_style.'"', $f_text_html);
	$f_text_html = str_replace('<h1', '<h1 style="'.$h1_text_style.'"', $f_text_html);
	
	$final_text_html = '
		<html>
		<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		</head>
		<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="margin: 0; -webkit-text-size-adjust: none; text-decoration: none !important; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; width: 100% !important;">
			<style type="text/css">
				* { padding:0px; margin: 0px; }
				body, td, tr, table, p, span, div, input, textarea, select, option, ol, ul, li { '.$base_text_style.' }
				p { margin: 0px 0px 12px 0px; }
				a:link { color:#33348e; text-decoration: none; }
				a:visited { color:#33348e; text-decoration: none; }
				a:hover { color:#33348e; text-decoration: none; }
				a:active { color:#7476b4; text-decoration: underline; }
			</style>
			<center>
				<table width="100%" cellpadding="0" cellspacing="0" border="0" valign="top" style="background:#ffffff;">
					<tr>
						<td valign="top" align="center" style="width:100%; text-align:center; background:#000000;"><a href="'.getSiteURL().'"><img src="'.$theme_path.'/_images/_mail/header.gif?'.rand().'"></a></td>
					</tr>
					<tr>
						<td valign="top" style="width:100%;">
							<table cellpadding="0" cellspacing="0" border="0" valign="top" align="left" width="100%" style="width:100%;">
								<tr>
									<td width="50%" style="width:50%;">&nbsp;</td>
									<td width="'.$w.'" style="width:'.$w.'px;">
										<div style="width:'.$w.'px; padding: 40px 0px 20px 0px; overflow:hidden;">'.$f_text_html.'</div>
										<div style="margin: 20px 0px 0px 0px; padding: 20px 0px 5px 0px; border-top: 1px solid #666666; overflow:hidden;">
											'.$footer.'
										</div>
									</td>
									<td width="50%" style="width:50%;">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			<center>
		</body>
		</html>
	';
	
	
	$return['text_plain'] = $final_text_plain;
	$return['text_html'] = $final_text_html;
	
	return $return;
}

?>