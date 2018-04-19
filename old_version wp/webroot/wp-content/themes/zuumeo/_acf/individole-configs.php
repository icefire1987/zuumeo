<?php

$p_theme = get_stylesheet_directory_uri();


$GLOBALS['configs_tinymce'] = array(
	'theme'						=> 'advanced',
	'skin'						=> 'wp_theme',
	'language'					=> 'de',
	'styles' 					=> "Bild links umflossen=image_left,Bild rechts umflossen=image_right,Headline mit Linie=headline_line",
	'blockformats'				=> 'p,h1,h2,h3,h4,h5',
	'invalid_elements'			=> 'div',
	'plugins'					=> 'inlinepopups,spellchecker,tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,-advimage,wpfullscreen',//,table,save,advhr,advimage,advlink',
	'content_css'				=> $p_theme.'/style.css,'.$p_theme.'/editor-style.css',
	'theme_advanced_buttons1' 	=> 'bold,underline,italic,|,justifyleft,justifycenter,justifyright,justifyfull,|,sub,sup,|,link,unlink',
	'theme_advanced_buttons2' 	=> 'styleselect,formatselect,|,outdent,indent,|,bullist,numlist',
	'theme_advanced_buttons3' 	=> 'pasteword,removeformat,|,undo,redo,|,code',
	'theme_advanced_buttons4' 	=> '',
);


$GLOBALS['individole']['repeater_modules'] = array(
	'page'				=>	__("Seiteneinstellungen (Name: page_options)",'acf'),
	'meta'				=>	__("Meta-Angaben (Name: meta)",'acf'),
	'formulare'			=>	__("Formulare (Name: formulare)",'acf'),
	'videos'			=>	__("Videos (Name: videos_config)",'acf'),
	'attachment'		=>	__("Attachment (Name: attachment_extra_content)",'acf'),
);

$GLOBALS['individole']['flex_modules'] = array(
	'm_headline'		=> true,
	'm_button'			=> true,
	'm_text'			=> true,
	'm_text_columns'	=> false,
	'm_image'			=> true,
	'm_image_list'		=> true,
	'm_gallery'			=> true,
	'm_articles'		=> false,
	'm_wall'			=> false,
	'm_content_list'	=> false,
	'm_downloads'		=> true,
	'm_line'			=> true,
	'm_video'			=> true,
	'm_shortcode'		=> true,
	'm_formulare'		=> true,
	'm_tables'			=> false,
	'm_page_elements'	=> false,
	'm_empty'			=> false,
	'm_showreel'		=> true,
	'm_360grad'			=> true,
);

$GLOBALS['individole']['flex_modules_options'] = array(
	'box'						=> false,
	'column_gaps'				=> false,
	'inset'						=> false,
	'module_name'				=> false,
	'innertop'					=> false,
	'innerbottom'				=> false,
	'no_padding_left_right'		=> false,
	'background'				=> false,
	'corner_top'				=> false,
	'corner_bottom'				=> false,
);


$GLOBALS['individole']['post_types'] = array(
	'page'			=> array(
		 'title'			=> 'Seiten',
		 'orderby'		=> 'menu_order',
		 'order'			=> 'ASC',
		 'output'		=> array('title'),
		 'hierarchical'	=> true,
	),
	'kunde'			=> array(
		 'title'			=> 'Kunden',
		 'orderby'		=> 'menu_order',
		 'order'			=> 'ASC',
		 'output'		=> array('title'),
		 'hierarchical'	=> true,
	),
	'formulare'		=> array(
		'orderby'		=> 'menu_order',
		'order'			=> 'ASC',
		'output'		=> array('title'),	
	),
	'videos'		=> array(
		'orderby'		=> 'menu_order',
		'order'			=> 'ASC',
		'output'		=> array('title'),	
	),
);


$GLOBALS['individole']['choices_module_view'] = array(
	'full'				=> 'Volle Breite',
	'inner'				=> 'nur Innen',
	'full_inner'		=> 'Volle Breite, Inhalt innen',
);


$GLOBALS['individole']['choices_shortcode'] = array(
	'button'			=> 'Button',
	'fb_like'			=> 'Facebook Like-Button',
);

$GLOBALS['individole']['choices_imagelist_text'] = array(
	'none'			=> 'Keine Titel/Texte anzeigen',
	'overlay'		=> 'Titel/Text als Overlay',
	'mouseover'		=> 'Titel/Text als Overlay (Mouseover)',
	'below'			=> 'Titel/Text unter dem Bild',
);

$GLOBALS['individole']['module_background'] = array(
	'none'				=> 'transparent',
	'default'			=> 'grau',
	'default_0'			=> 'grau (kein Padding)',
	'border'			=> 'grau + weißer Rand',
	'border_0'			=> 'grau + weißer Rand (kein Padding)',
);

$GLOBALS['individole']['choices_gallery_type'] = array(
	'slideshow'		=> 'Slideshow',
	'wand'			=> 'Bilderwand',
);

$GLOBALS['individole']['choices_showreel_columns'] = array(
	'1'				=> '1',
	'2'				=> '2',
	'3'				=> '3',
	'4'				=> '4',
	'5'				=> '5',
);

$GLOBALS['individole']['choices_gallery_wand_cols'] = array(
	'2'				=> '2',
	'3'				=> '3',
	'4'				=> '4',
	'5'				=> '5',
	'6'				=> '6',
	'7'				=> '7',
	'8'				=> '8',
	'9'				=> '9',
);

$GLOBALS['individole']['choices_gallery_wand_gap'] = array(
	 '0'	 		=> 0,
	 '1'		 	=> 1,
	 '2'		 	=> 2,
	 '3'		 	=> 3,
	 '4'		 	=> 4,
	 '5'		 	=> 5,
	 '6'		 	=> 6,
	 '7'		 	=> 7,
	 '8'		 	=> 8,
	 '9'		 	=> 9,
	 '10'	 	=> 10,
	 '11'	 	=> 11,
	 '12'	 	=> 12,
	 '13'	 	=> 13,
	 '14'	 	=> 14,
	 '15'	 	=> 15,
	 '16'	 	=> 16,
	 '17'	 	=> 17,
	 '18'	 	=> 18,
	 '19'	 	=> 19,
	 '20'	 	=> 20,
	 '25'	 	=> 25,
	 '30'	 	=> 30,
	 '35'	 	=> 35,
	 '40'	 	=> 40,
);

$GLOBALS['individole']['choices_sitemap'] = array(
	'1.0'				=> '1.0',
	'0.9'				=> '0.9',
	'0.8'				=> '0.8',
	'0.7'				=> '0.7',
	'0.6'				=> '0.6',
	'0.5'				=> '0.5',
	'0.4'				=> '0.4',
	'0.3'				=> '0.3',
	'0.2'				=> '0.2',
	'0.1'				=> '0.1',
	'0'					=> 'nicht in Sitemap aufnehmen',
);

$GLOBALS['individole']['choices_changefreq'] = array(
	'always'			=> 'permanent',
	'hourly'			=> 'stündlich',
	'daily'				=> 'täglich',
	'weekly'			=> 'wöchentlich',
	'monthly'			=> 'monatlich',
	'yearly'			=> 'jährlich',
	'never'				=> 'niemals',
);


$GLOBALS['individole']['choices_form_submit_position'] = array(
	 'left'				=> 'links',
	 'indent'			=> 'eingerückt',
	 'center'			=> 'mittig',
	 'right'				=> 'rechts',
	 'indent_full'		=> 'eingerückt + über die volle Breite',
	 'full'				=> 'über die volle Formularbreite',
);


$GLOBALS['individole']['choices_headline_type'] = array(
	 'h1'				=> 'H1',
	 'h2'				=> 'H2',
	 'h3'				=> 'H3',
);


$GLOBALS['individole']['choices_headerslideshow_controls'] = array(
	 ''					=> 'Keine Steuerung',
	 'dots'				=> 'Punkte',
	 'titles'			=> 'Titel (unten eingeben!) <sup>1</sup>',
);


$GLOBALS['individole']['choices_alignment'] = array(
	 'left'				=> 'Links',
	 'center'			=> 'Mittig',
	 'right'			=> 'Rechts',
);



$GLOBALS['individole']['choices_video_source'] = array(
	'embed'				=> '(A) Externer Player (Embed-Code)',
	'youtube'			=> '(A) Eigener Player (Youtube)',
	'url'				=> '(A) Eigener Player (URL zum Video)',
	'upload'			=> '(B) Eigener Player (Upload mp4, ...)',
);


$GLOBALS['individole']['choices_image_list_per_row'] = array(
	'1'					=> 1,
	 '2'					=> 2,
	 '3'					=> 3,
	 '4'					=> 4,
	 '5'					=> 5,
	 '6'					=> 6,
	 '7'					=> 7,
	 '8'					=> 8,
);

$GLOBALS['individole']['choices_image_list_scale'] = array(
	'1.0'				=> "100%",
	 '0.95'				=> "95%",
	 '0.9'				=> "90%",
	 '0.85'				=> "85%",
	 '0.8'				=> "80%",
	 '0.75'				=> "75%",
	 '0.7'				=> "70%",
	 '0.65'				=> "65%",
	 '0.6'				=> "60%",
	 '0.55'				=> "55%",
	 '0.5'				=> "50%",
);

$GLOBALS['individole']['choices_gap_default'] = array(
	 'default'	=> 'Standard',
	 'empty'	 	=> 0,
	 '5'		 	=> 5,
	 '10'	 	=> 10,
	 '15'	 	=> 15,
	 '20'	 	=> 20,
	 '25'	 	=> 25,
	 '30'	 	=> 30,
	 '35'	 	=> 35,
	 '40'	 	=> 40,
	 '45'	 	=> 45,
	 '50'	 	=> 50,
);

$GLOBALS['individole']['choices_gap_line'] = array(
	 'default'	=> 'Standard',
	 'empty'	 	=> 0,
	 '1'		 	=> 1,
	 '2'		 	=> 2,
	 '3'		 	=> 3,
	 '4'		 	=> 4,
	 '5'		 	=> 5,
	 '6'		 	=> 6,
	 '7'		 	=> 7,
	 '8'		 	=> 8,
	 '9'		 	=> 9,
	 '10'	 	=> 10,
	 '11'	 	=> 11,
	 '12'	 	=> 12,
	 '13'	 	=> 13,
	 '14'	 	=> 14,
	 '15'	 	=> 15,
	 '16'	 	=> 16,
	 '17'	 	=> 17,
	 '18'	 	=> 18,
	 '19'	 	=> 19,
	 '20'	 	=> 20,
	 '25'	 	=> 25,
	 '30'	 	=> 30,
	 '35'	 	=> 35,
	 '40'	 	=> 40,
	 '45'	 	=> 45,
	 '50'	 	=> 50,
	 '55'	 	=> 55,
	 '60'	 	=> 60,
	 '65'	 	=> 65,
	 '70'	 	=> 70,
	 '75'	 	=> 75,
	 '80'	 	=> 80,
);

$GLOBALS['individole']['choices_grid'] = array(
	 'default'	=> 'Alle Spalten gleichm&auml;&szlig;ig verteilen',
	 '2-10'		=> '2 Spalten -> 2-10',
	 '3-9'		=> '2 Spalten -> 3-9',
	 '4-8'		=> '2 Spalten -> 4-8',
	 '5-7'		=> '2 Spalten -> 5-7',
	 '7-5'		=> '2 Spalten -> 7-5',
	 '8-4'		=> '2 Spalten -> 8-4',
	 '9-3'		=> '2 Spalten -> 9-3',
	 '10-2'		=> '2 Spalten -> 10-2',
	 
	 '2-2-8'		=> '3 Spalten -> 2-2-8',
	 '2-4-6'		=> '3 Spalten -> 2-4-6',
	 '2-6-4'		=> '3 Spalten -> 2-6-4',
	 '2-8-2'		=> '3 Spalten -> 2-8-2',
	 '3-1-8'		=> '3 Spalten -> 3-1-8',
	 '3-2-7'		=> '3 Spalten -> 3-2-7',
	 '3-3-6'		=> '3 Spalten -> 3-3-6',
	 '3-4-5'		=> '3 Spalten -> 3-4-5',
	 '3-5-4'		=> '3 Spalten -> 3-5-4',
	 '3-6-3'		=> '3 Spalten -> 3-6-3',
	 '4-2-6'		=> '3 Spalten -> 4-2-6',
	 '4-6-2'		=> '3 Spalten -> 4-6-2',
	 '5-1-6'		=> '3 Spalten -> 5-1-6',
	 '6-1-5'		=> '3 Spalten -> 6-1-5',
	 '6-2-4'		=> '3 Spalten -> 6-2-4',
	 '6-3-3'		=> '3 Spalten -> 6-3-3',
	 '6-4-2'		=> '3 Spalten -> 6-4-2',
	 '6-5-1'		=> '3 Spalten -> 6-5-1',
	 '7-1-4'		=> '3 Spalten -> 7-1-4',
	 '7-2-3'		=> '3 Spalten -> 7-2-3',
	 '7-3-2'		=> '3 Spalten -> 7-3-2',
	 '7-4-1'		=> '3 Spalten -> 8-4-1',
	 '8-1-3'		=> '3 Spalten -> 8-1-3',
	 '8-2-2'		=> '3 Spalten -> 8-2-2',
	 '8-3-1'		=> '3 Spalten -> 8-3-1',
	 
	 '2-2-2-6'	=> '4 Spalten -> 2-2-2-6',
	 '2-2-4-4'	=> '4 Spalten -> 2-2-4-4',
	 '2-2-6-2'	=> '4 Spalten -> 2-2-6-2',
	 
	 '4-2-2-4'	=> '4 Spalten -> 4-2-2-4',
	 '4-2-4-2'	=> '4 Spalten -> 4-2-4-2',
	 '4-4-2-2'	=> '4 Spalten -> 4-4-2-2',
	 
	 '6-2-2-2'	=> '4 Spalten -> 6-2-2-2',
	 
	 
);

$GLOBALS['individole']['module_columns'] = array(
	 '1'		=> 1,
	 '2'		=> 2,
	 '3'		=> 3,
	 '4'		=> 4,
	 '5'		=> 5,
	 '6'		=> 6,
	 '7'		=> 7,
	 '8'		=> 8,
	 '9'		=> 9,
	 '10'	 	=> 10,
	 '11'	 	=> 11,
	 '12'	 	=> '12 (volle Breite)',
);

$GLOBALS['individole']['choices_gap'] = array(
	 'default'	=> 'Standard ('.MODULE_GAP.')',
	 'empty'	=> 0,
	 '1'		=> 1,
	 '2'		=> 2,
	 '3'		=> 3,
	 '4'		=> 4,
	 '5'		=> 5,
	 '6'		=> 6,
	 '7'		=> 7,
	 '8'		=> 8,
	 '9'		=> 9,
	 '10'	 	=> 10,
	 '11'	 	=> 11,
	 '12'	 	=> 12,
	 '13'	 	=> 13,
	 '14'	 	=> 14,
	 '15'	 	=> 15,
	 '16'	 	=> 16,
	 '17'	 	=> 17,
	 '18'	 	=> 18,
	 '19'	 	=> 19,
	 '20'	 	=> 20,
	 '21'	 	=> 21,
	 '22'	 	=> 22,
	 '23'	 	=> 23,
	 '24'	 	=> 24,
	 '25'	 	=> 25,
	 '26'	 	=> 26,
	 '27'	 	=> 27,
	 '28'	 	=> 28,
	 '29'	 	=> 29,
	 '30'	 	=> 30,
	 '31'	 	=> 31,
	 '32'	 	=> 32,
	 '33'	 	=> 33,
	 '34'	 	=> 34,
	 '35'	 	=> 35,
	 '36'	 	=> 36,
	 '37'	 	=> 37,
	 '38'	 	=> 38,
	 '39'	 	=> 39,
	 '40'	 	=> 40,
	 '41'	 	=> 41,
	 '42'	 	=> 42,
	 '43'	 	=> 43,
	 '44'	 	=> 44,
	 '45'	 	=> 45,
	 '46'	 	=> 46,
	 '47'	 	=> 47,
	 '48'	 	=> 48,
	 '49'	 	=> 49,
	 '50'	 	=> 50,
	 '55'	 	=> 55,
	 '60'	 	=> 60,
	 '65'	 	=> 65,
	 '70'	 	=> 70,
	 '75'	 	=> 75,
	 '80'	 	=> 80,
	 '85'	 	=> 85,
	 '90'	 	=> 90,
	 '95'	 	=> 95,
	 '100'	 	=> 100,
);


$GLOBALS['individole']['choices_line_color'] = array(
	'no_color'	=> 'Keine Farbe',
	 'grey'		=> 'Hellgrau',
	 'blue'		=> 'Dunkelgrau',
);

$GLOBALS['individole']['choices_gap_columns'] = array(
	 'default'	=> 'Standard ('.COL_GAP.')',
	 'empty'	 	=> 0,
	 '1'		 	=> 1,
	 '2'		 	=> 2,
	 '3'		 	=> 3,
	 '4'		 	=> 4,
	 '5'		 	=> 5,
	 '6'		 	=> 6,
	 '7'		 	=> 7,
	 '8'		 	=> 8,
	 '9'		 	=> 9,
	 '10'		=> 10,
	 '11'		=> 11,
	 '12'		=> 12,
	 '13'		=> 13,
	 '14'		=> 14,
	 '15'		=> 15,
	 '16'		=> 16,
	 '17'		=> 17,
	 '18'		=> 18,
	 '19'		=> 19,
	 '20'	 	=> 20,
	 '21'	  	=> 21,
	 '22'	  	=> 22,
	 '23'	  	=> 23,
	 '24'	  	=> 24,
	 '25'	  	=> 25,
	 '26'	  	=> 26,
	 '27'	  	=> 27,
	 '28'	  	=> 28,
	 '29'	  	=> 29,
	 '30'	 	=> 30,
	 '31'	  	=> 31,
	 '32'	  	=> 32,
	 '33'	  	=> 33,
	 '34'	  	=> 34,
	 '35'	  	=> 35,
	 '36'	  	=> 36,
	 '37'	  	=> 37,
	 '38'	  	=> 38,
	 '39'	  	=> 39,
	 '40'	 	=> 40,
	 '41'	 	=> 41,
	 '42'	 	=> 42,
	 '43'	 	=> 43,
	 '44'	 	=> 44,
	 '45'	 	=> 45,
	 '46'	 	=> 46,
	 '47'	 	=> 47,
	 '48'	 	=> 48,
	 '49'	 	=> 49,
	 '50'	 	=> 50,
	 '51'	 	=> 51,
	 '52'	 	=> 52,
	 '53'	 	=> 53,
	 '54'	 	=> 54,
	 '55'	 	=> 55,
	 '56'	 	=> 56,
	 '57'	 	=> 57,
	 '58'	 	=> 58,
	 '59'	 	=> 59,
	 '60'		=> 60,
);

?>