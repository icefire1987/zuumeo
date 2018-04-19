<?php

if((!isset($page_id) || (isset($page_id) && $page_id == 0)) && get_post()) {
	$page_id = get_the_ID();
}

?>