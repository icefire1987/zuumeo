<?php

if(is_admin() && isAdminPage("options-media")) {
	global $wp_version;
	if ( version_compare($wp_version, '3.5', '<') || !is_admin() || is_multisite() )
		return;
	
	
	add_action( 'load-options-media.php',	'uupe_init' );
	add_action( 'load-options.php',			'uupe_init' );
	function uupe_init() {
		if ( !get_option('upload_url_path') && !( get_option('upload_path') != 'wp-content/uploads' && get_option('upload_path') ) ) {
			register_setting( 'media',	'upload_path',		'esc_attr' );
			register_setting( 'media',	'upload_url_path',	'esc_url'  );
			add_settings_field( 'upload_path',		__( 'Store uploads in this folder' ),	'uupe_upload_path',		'media',	'uploads',	array( 'label_for' => 'upload_path' ) );
			add_settings_field( 'upload_url_path',	__( 'Full URL path to files' ),			'uupe_upload_url_path',	'media',	'uploads',	array( 'label_for' => 'upload_url_path' ) );
		}
	}
	
	
	function uupe_upload_path( $args ) { ?>
		<input name="upload_path" type="text" id="upload_path" value="<?php echo esc_attr(get_option('upload_path')); ?>" class="regular-text code" />
		<p class="description"><?php _e('Default is <code>wp-content/uploads</code>'); ?></p>
		<?php
	}
	
	
	function uupe_upload_url_path( $args ) { ?>
		<input name="upload_url_path" type="text" id="upload_url_path" value="<?php echo esc_attr( get_option('upload_url_path')); ?>" class="regular-text code" />
		<p class="description"><?php _e('Configuring this is optional. By default, it should be blank.'); ?></p>
		<?php
	}
}

?>