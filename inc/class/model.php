<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
class Model{
	public $path = '../templates';
	
	function __construct(){
// 		define("HOST", "localhost");
// 		define("USER", "db11206237-it");
// 		define("PASSWORD", "zuumeo001");
// 		define("DATABASE", "db11206237-it");
		
		
/*		define("HOST", "127.0.0.1");     // The host you want to connect to.
		define("USER", "root");    // The database username.
		define("PASSWORD", "5uum30");    // The database password.
		define("DATABASE", "immo");    // The database name.
		
		define("CAN_REGISTER", "any");
		define("DEFAULT_ROLE", "member");
		define("SECURE", true);
		
		
		$this->mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
		if ($this->mysqli->connect_error) {
			die('Connect Error (' . $this->mysqli->connect_errno . ') '. $this->mysqli->connect_error);
		}
		$this->mysqli->query("SET NAMES UTF8");
		*/
	}	
	
	public function setTemplate($template = 'mail') {
		$this->template = $this->path.DIRECTORY_SEPARATOR.'tpl.'.$template.'.php';
	}
	
	
	function clean_string($string) {	
		$bad = array("content-type","bcc:","to:","cc:","href");	
		$clean = str_replace($bad,"",$string);
		return $this->real_escape_string_html($clean);	
	}
	function real_escape_string_html($string){
		$text = filter_var($string, FILTER_SANITIZE_STRING);		
		return $text;
	}

	function checkbrute($user_id, $mysqli) {
		// Get timestamp of current time
		$now = time();
	
		// All login attempts are counted from the past 2 hours.
		$valid_attempts = $now - (2 * 60 * 60);
	
		if ($stmt = $mysqli->prepare("SELECT time
				FROM login_attempts
				WHERE user_id = ?
				AND time > '$valid_attempts'")) {
				$stmt->bind_param('i', $user_id);
	
				// Execute the prepared query.
				$stmt->execute();
				$stmt->store_result();
	
				// If there have been more than 5 failed logins
				if ($stmt->num_rows > 5) {
					return true;
				} else {
					return false;
				}
		}
	}
	
	public function parseTemplate() {
		if (file_exists ( $this->template )) {	
			ob_start ();
			include $this->template;
			$output = ob_get_contents ();
			ob_end_clean ();	
			return $output;
		}
		return "Kann das Template " . $this->template . " nicht finden";
	}
	
	
	function sendNewMail($an,$betreff,$content){
		//extension=php_openssl.dll
		include_once '../class/PHPMailer/class.phpmailer.php';
		$this->mail = new PHPMailer();
		try {
			$this->mail->SMTPDebug  = 0;
	
			$this->mail->Host = 'smtp.gmail.com';
			$this->mail->Port       = 587;
	
			$this->mail->IsSMTP();
			$this->mail->SMTPAuth   = true;
			$this->mail->SMTPSecure = 'tls';
	
			$this->mail->Username   = "christopher.jurthe@zuumeo.com";
			$this->mail->Password   = "ChJu2009";
	
			$this->mail->CharSet = 'UTF-8';
			$this->mail->SetFrom('christopher.jurthe@zuumeo.com', 'ZUUMEO.com');
			$this->mail->AddAddress($an);
			$this->mail->Subject = $betreff;
				
				
			$this->mailHeader = $content["mailHeadline"];
			$this->mailContent = $content["mailContent"];
			$this->setTemplate('mail');
			$this->mailtext = $this->parseTemplate();
				
			$this->mail->Body = $this->mailtext;
			$this->mail->IsHTML(true);
			$this->mail->AltBody = strip_tags($this->mailtext);
			if($this->mail->Send()){
				return true;
			}else{
			}
		}catch (phpmailerException $e){
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
			return false;
		}catch (Exception $e){
			echo $e->getMessage(); //Boring error messages from anything else!
			return false;
		}
		return false;
	}
	
	function esc_url($url) {
	
		if ('' == $url) {
			return $url;
		}
	
		$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
	
		$strip = array('%0d', '%0a', '%0D', '%0A');
		$url = (string) $url;
	
		$count = 1;
		while ($count) {
			$url = str_replace($strip, '', $url, $count);
		}
	
		$url = str_replace(';//', '://', $url);
	
		$url = htmlentities($url);
	
		$url = str_replace('&amp;', '&#038;', $url);
		$url = str_replace("'", '&#039;', $url);
	
		if ($url[0] !== '/') {
			// We're only interested in relative links from $_SERVER['PHP_SELF']
			return '';
		} else {
			return $url;
		}
	}
	
}