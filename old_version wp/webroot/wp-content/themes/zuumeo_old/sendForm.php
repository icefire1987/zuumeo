<?php

if(isset($_POST['send_form'])) {
	$basepath = $_SERVER["DOCUMENT_ROOT"];
	include($basepath."/wp-config.php");
	
	
	
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
	
	$id = $_POST['id'];
	
	$configs = get_field('formulare_config', $id);
	
	$r = $configs[0]['formulare_receiver'][0];
	$c = $configs[0]['formulare_einstellungen'][0];
	$f = $configs[0]['formulare_eingabefelder'];
	
	
	$w = 600;
	$font = 'font-family:Verdana, sans-serif;font-size:13px;line-height:1.5em;';
	
	
	//!BETREFF
	$final_subject = 'Kontaktformular '.$_SERVER['HTTP_HOST'];
	if(isset($c['subject']) && trim($c['subject']) != "") {
	    $final_subject = $c['subject'];
	}
	
	//debug($c);
	
	
	$final_receiver 	= array();
	$final_cc 			= array();
	$final_bcc 			= array();
	
	$from_name	 		= $c['sender_name'];
	$from_mail	 		= $c['sender_mail'];
	$final_reply_to 	= '';
	
	
	
	//!GET main receiver
	$to_mail = $r['standard'][0]['mail'];
	$to_name = $r['standard'][0]['name'];
	
	
	
	//!GET cc
	foreach($r['cc'] AS $key => $value) {
		$mail = $value['mail'];
		$name = $value['name'];
	
		if(checkMail($mail)) {
			$final_cc[] = $mail;
		}
	}
	
	
	//!GET bcc
	foreach($r['bcc'] AS $key => $value) {
		$mail = $value['mail'];
		$name = $value['name'];
	
		if(checkMail($mail)) {
			$final_bcc[] = $mail;
		}
	}
	
	
	
	//!MESSAGE
	$input_rows = array();
	$input_rows_plain = array();
	$reply_to_name = array();
	$reply_to_mail = "";
	$receiver_name = array();
	$receiver_mail = "";
	$copy_to_sender = 0;
	foreach($f AS $key => $value) {
		$key 			= $key+1;
		
		$show_in_mail	= $value['show_in_mail'];
		$type 			= $value['typ'];
		$title 			= $value['title'];
		$alt_title 		= $value['alt_title'];
		
		if($alt_title != "") {
			$title = $alt_title;
		}
		
		$config 		= $value['config'];
		
		$final_value 	= utf8_encode($_POST['value_'.$key]);
		
		if($type == 'sender_name') {
		    $reply_to_name[] = $final_value;
		}
		
		if($type == 'sender_mail') {
		    $reply_to_mail = $final_value;
		    $copy_to_sender_mail = $final_value;
		}
		
		if($type == 'receiver_name') {
		    $to_name = $final_value;
		}
		
		if($type == 'receiver_mail') {
		    $to_mail = $final_value;
		}
		
		if($type == 'subject' && $final_value != "") {
		    $final_subject = $final_value;
		}
		
		if($type == 'true_false') {
		    $checkbox_options = explode("#", $config);
		    $title = $checkbox_options[0];
		    
		    ($final_value == 0) ? $final_value = "Nein" : $final_value = "Ja";
		}
		
		if($type == 'copy' && $final_value == 1) {
		    $copy_to_sender = 1;
		}
		
			
		if($show_in_mail == 1) {
			if($final_value == "") {
				$final_value = '-';
			}
			
			$input_rows_plain[] = $title.':\n'.$final_value;
			
			$input_rows[] = '<tr><th align="left" valign="top" style="padding-right:20px; white-space: nowrap; '.$font.'">'.$title.'</th><td align="left" valign="top" style="width:100%; '.$font.'">'.nl2br($final_value).'</td></tr>';
		}	
		
		$_SESSION['form_'.$id][$key] = $final_value;
	}
	
	if($reply_to_mail != "") {
		$final_reply_to = $reply_to_mail;	
	}
	
	if($receiver_mail != "") {
		$receiver_standard = $receiver_mail;
		//if(sizeof($receiver_name) > 0) {
		//	$receiver_standard = implode(" ", $receiver_name).' <'.$receiver_mail.'>';	
		//}
	}
	
	
	
	//!TEXT vor Daten
	$text_top = '';
	$text_top_plain = '';
	if(isset($c['mailtext_start']) && trim($c['mailtext_start']) != "") {
	    $text_top_plain = $c['mailtext_start'];
	    $text_top = '<p style="padding-bottom:20px;'.$font.'">'.nl2br($text_top_plain);
	}
	
	
	//!TEXT nach Daten
	$text_bottom = '';
	$text_bottom_plain = '';
	if(isset($c['mailtext_end']) && trim($c['mailtext_end']) != "") {
	    $text_bottom_plain = $c['mailtext_end'];
	    $text_bottom = '<br><p style="'.$font.'">'.nl2br($text_bottom_plain);
	}
			
	
	$text_plain = $text_top_plain.'\n\n'.implode("\n\n", $input_rows_plain).'\n\n'.$text_bottom_plain;
	
	$text_html = '
		<table cellpadding="0" cellspacing="0" border="0" valign="top" width="100%" style="width:'.$w.'px; padding: 15px 25px 15px 25px; background:#ffffff;">
			<tr><td colspan="2">'.$text_top.'</td></tr>
			'.implode("", $input_rows).'
			<tr><td colspan="2">'.$text_bottom.'</td></tr>
		</table>
	';
	
	
	$text = createMailBody(array(
		'text_plain'	=> $text_plain,
		'text_html'		=> $text_html,
	));
	
	
	//!SET sendmail values AND send
	$array_sendmail = $array_sendmail_copy = array(
		'to_name'		=> $to_name,
		'to_mail'		=> $to_mail,
		'from_name'		=> $from_name,
		'from_mail'		=> $from_mail,
		'reply_to'		=> $final_reply_to,
		'cc'			=> $final_cc,
		'bcc'			=> $final_bcc,
		'subject'		=> $final_subject,
		'text_html'		=> $text['text_html'],
		'text_plain'	=> $text['text_plain'],
	);
	
	if($copy_to_sender == 1 && $copy_to_sender_mail != "") {
		$array_sendmail_copy['to_copy_mail'] 		= $copy_to_sender_mail;
		$array_sendmail_copy['reply_to'] 			= $to_mail;
		$array_sendmail_copy['receiver'] 			= array();
		$array_sendmail_copy['cc'] 					= array();
		$array_sendmail_copy['bcc'] 				= array();
		$array_sendmail_copy['subject'] 			= 'KOPIE: '.$array_sendmail_copy['subject'];
		
		//debug($array_sendmail_copy);
		
		sendMail($array_sendmail_copy);
	}
	
	
	if(sendMail($array_sendmail)) {
		$success = 1;
	} else {
		$success = 0;
	}
	
	debug($array_sendmail_copy);
	
	echo '|||'.$success;
}

?>