<?php

add_action( 'wp_ajax_sneek_update_post_order', 'sneek_update_post_order' );

function sneek_update_post_order() {
	global $wpdb;

	$post_type     = $_POST['postType'];
	$order        = $_POST['order'];

	/**
	*    Expect: $sorted = array(
	*                menu_order => post-XX
	*            );
	*/
	foreach( $order as $menu_order => $post_id ) {
		$post_id         = intval( str_ireplace( 'post-', '', $post_id ) );
		$menu_order     = intval($menu_order);
		//wp_update_post( array( 'ID' => $post_id, 'menu_order' => $menu_order ) );
		
		$wpdb->update( $wpdb->posts, array( 'menu_order' => $menu_order ), array( 'ID' => $post_id ) );
	}

	die( '1' );
}

?>