<?php

function sendMail($args) {	
	$headers = array();
	
	if(checkMail($args['to_mail'])) {
		$to_mail 			= $args['to_mail'];
		$from_name 			= $args['from_name'];
		$from_mail 			= $args['from_mail'];
		
		(isset($args['to_name'])) ? $to_name = $args['to_name'] : $to_name = '';
		(isset($args['reply_to'])) ? $reply_to = $args['reply_to'] : $reply_to = '';
		
		(isset($args['cc'])) ? $cc = $args['cc'] : $cc = array();
		(isset($args['bcc'])) ? $bcc = $args['bcc'] : $bcc = array();
		
		$subject 			= $args['subject'];
		$text_html			= $args['text_html'];
		$text_plain			= $args['text_plain'];
		
		
		$phpmailer = get_stylesheet_directory()."/_phpmailer";
		
		$random = rand(1,9999);
		
		
		//!include php-mailer
		require_once($phpmailer.'/class.phpmailer.php');
		
		${'mail'.$random} = new PHPMailer();
		${'mail'.$random}->SetLanguage("de", $phpmailer."/language/");
		${'mail'.$random}->CharSet = "utf-8";
		${'mail'.$random}->IsSendmail();
		
		
		
		if($reply_to == "") {
			${'mail'.$random}->AddReplyTo($from_mail, $from_name);
		
		} else {
			${'mail'.$random}->AddReplyTo($reply_to, $from_name);
		}
		
		
		${'mail'.$random}->From 		= $from_mail;
		${'mail'.$random}->FromName 	= $from_name;
		${'mail'.$random}->Sender 		= $from_mail;
		
		if($to_name != "") {
			${'mail'.$random}->AddAddress($to_mail, $to_name);
		} else {
			${'mail'.$random}->AddAddress($to_mail);
		}
		
		
		${'mail'.$random}->Subject 		= $subject;
		
		if(!empty($cc)) {
			foreach($cc AS $value) {
				${'mail'.$random}->AddCC($value);
			}
		}
		
		if(!empty($bcc)) {
			foreach($bcc AS $value) {
				${'mail'.$random}->AddBCC($value);
			}
		}
		
		
		
		//!merge content
		${'mail'.$random}->IsHTML(true);
		${'mail'.$random}->ContentType 	= "text/html";
		${'mail'.$random}->Body    		= $text_html;
		${'mail'.$random}->AltBody 		= $text_plain;
		
		
		//!send mail
		if(${'mail'.$random}->Send()) {
		    //echo "yep";
		    return true;
		    
		} else {
		    //echo "nope<p>" .${'mail'.$random}->ErrorInfo;
		    return false;
		    exit;
		}
	}
}

?>