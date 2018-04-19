<?php

function get_post_meta_id( $post_id, $meta_key ) {
  global $wpdb;
  $mid = $wpdb->get_var( $wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = %s", $post_id, $meta_key) );
  if( $mid != '' )
    return (int)$mid;
 
  return false;
}

?>