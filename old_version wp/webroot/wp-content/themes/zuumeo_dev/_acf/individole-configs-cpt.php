<?

$custom_post_types = array(
	/* 'accounts',  */
	'kunde',
	/* 'abteilung', */
	/* 'job', */
	'videos',
	'formulare',
	'page', 
	'acf',
);

$individole_dynamic_post_types = array();



$config_cpt_theme = array(
	'kunde'				=> array(
		'name' 					=> 'Kunden',
		'singular_name' 		=> 'Kunde oder Kundenunterseite',
		'hierarchical'			=> true,
		'my_show_in_nav_menus'	=> true,
		'capability_type'		=> 'page',
		'supports'				=> array('title', 'page-attributes'),
	),
	
	//'abteilung'				=> array(
	//	'name' 					=> 'Karriere / Abteilungen',
	//	'singular_name' 		=> 'Karriere / Abteilung',
	//),
	//
	//'job'				=> array(
	//	'name' 					=> 'Karriere / Jobs',
	//	'singular_name' 		=> 'Karriere / job',
	//),
	
	'formulare'				=> array(
		'name' 					=> 'Formulare',
		'singular_name' 		=> 'Formular',
	),
	
	'videos'				=> array(
		'name' 					=> 'Videos',
		'singular_name' 		=> 'Video',
		'columns'				=> array(
			'videos_config_0_video_configs_0_image'		=> array(
				'head'					=> 'Bild',
				'titles'				=> '',
				'formats'				=> 'image',
				'width'					=> 60,
			),
			'title'					=> array(
				'head'					=> 'Title',
				'titles'				=> '',
				'formats'				=> '',
			),
			'videos_config_0_video_0_upload_0_mp4--videos_config_0_video_0_upload_0_ogg'		=> array(
				'head'					=> 'Upload',
				'titles'				=> 'MP4,OGG',
				'formats'				=> 'title,title',
				'width'					=> 260,
			),
		),
	),
	
	'page'					=> array(
		'register' 				=> false,
		'name' 					=> 'Seiten',
		'my_show_in_nav_menus'	=> true,
		'singular_name' 		=> 'Seite',
		'hierarchical'			=> true,
		'capability_type'		=> 'page',
		'columns'				=> array(
			'title'		=> array(
				'head'					=> 'Titel',
				'titles'				=> '',
				'formats'				=> '',
			),
			'meta_0_meta_title--meta_0_meta_description--meta_0_meta_keywords'	=> array(
				'head'					=> 'SEO',
				'titles'				=> 'Title,Description,Keywords',
				'formats'				=> '',
				'width'					=> 340,
			),
		),
	),
	
	'acf'					=> array(
		'register' 				=> false,
		'name' 					=> 'Advanced Custom Fields',
		'singular_name' 		=> 'Advanced Custom Field',
		'dashboard'				=> 'superadmin',
		'submenu'				=> false,
	),
);





//!Standard-Einstellungen
$config_cpt_default = array(
	'register' 				=> true,
	'name' 					=> 'missing name',
	'singular_name' 		=> 'missing singular name',
	'button_label' 			=> '+ add new post',
	'add_new' 				=> true,
	'slug'					=> false, // false, wanted slug
	'capability_type'		=> 'post',
	'hierarchical'			=> false,
	'with_front'			=> true,
	'show_in_nav_menus'		=> false,
	'my_show_in_nav_menus'	=> false,
	'supports'				=> array('title'),
	'orderby'				=> 'menu_order',
	'ordermeta'				=> false, // true, false
	'direction'				=> 'ASC', // ASC, DESC
	'limit'					=> 999999,
	'submenu'				=> true, // true, admin, superadmin
	'dashboard'				=> 'admin', // admin, superadmin
	'dashboard_title'		=> false,
	'dashboard_limit'		=> 999999,
	'columns'				=> array(),
	'taxonomies' 			=> array(),
);

foreach($custom_post_types AS $custom_post_type) {
	$config_cpt_base[$custom_post_type] = $config_cpt_default;
}

//!Standard-Einstellungen durch individuelle erweitern/überschreiben
$config_cpt = array_replace_recursive($config_cpt_base, $config_cpt_theme);
   		
?>