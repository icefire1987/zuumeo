<?php

add_image_size( 'header_slideshow', 960, 320, true );

for($i = 1; $i<=12; $i++) {
	add_image_size( 'custom_'.$i, getColumnWidth(array('columns' => $i)), 999999 );
}

?>