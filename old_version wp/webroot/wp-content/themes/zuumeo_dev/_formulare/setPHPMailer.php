<?php

function setPHPMailer( $phpmailer ) {
	global $final_text_html;
	global $final_text_plain;
	
	$boundary = md5(date('U'));
	
	//$phpmailer->WordWrap = 50;
	$phpmailer->ContentType = "multipart/alternative; boundary=".$boundary;
	$phpmailer->AltBody = $final_text_plain;
	$phpmailer->Body = stripslashes($final_text_html);
	
	//debug($phpmailer);
}
add_action( 'phpmailer_init', 'setPHPMailer' );

?>