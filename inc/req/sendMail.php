<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include_once '../class/model.php';
$model= new Model();
//$DB = $model->mysqli;

if (isset($_POST['anmerkung'], $_POST['name'], $_POST['email'], $_POST["url"])) {
	if($_POST["url"]!=""){
		return false;
	}
	
    $email = $model->clean_string($_POST['email']);
    $name = $model->clean_string($_POST['name']); 
    $anmerkung = $model->clean_string($_POST['anmerkung']);
    $grund = $model->clean_string($_POST['grund'][0]);
    
    
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';  

    if(!preg_match($email_exp,$email)) {
    	$text = 'Es wurde eine ungültige eMail-Adresse angegeben.';
    	$text=htmlentities($text);
    	$ret = array("err"=>$text);    
    	echo json_encode($ret);
    	return false;
    }

    $string_exp = "/^[A-Za-z .'-]+$/";    
    if(!preg_match($string_exp,$name)) {  
    	$text = 'Es wurde ein ungültiger Name angegeben.';
    	$text=htmlentities($text);
    	$ret = array("err"=>$text);    
    	echo json_encode($ret);
    	return false;
    }  

    if(strlen($anmerkung) < 2) {    
    	$text = 'Bitte geben Sie eine aussagekräftige Anmerkung ein.';
    	$text=htmlentities($text);
    	$ret = array("err"=>$text);
    	echo json_encode($ret);
    	return false;    	
    }
    if(isset($_POST['firma'])){
    	$firma = $model->clean_string($_POST['firma']);
    	$anmerkung.="<br>Firma: ".$firma;
    }
    if(isset($_POST['telefon'])){
    	$tel = $model->clean_string($_POST['telefon']);
    	$anmerkung.="<br>Telefon: ".$tel;
    }
   
 	$res = $model->sendNewMail(
 			"christopher.jurthe@zuumeo.com",
 			$grund,
 			array(
 					"mailHeadline"=>"<span style='font-weight: normal;color: black;'> Name: </span> <span style=''> ".$name." </span>
 									<span style='font-weight: normal;color: black;'> eMail: </span> <span style=''> ".$email." </span>",
 					"mailContent"=>$anmerkung
 			)
 	);
    if ($res === true) {
    	// Login success
    	echo "1";
    }else if ($res === 0) {
    	// User unbekannt
    	$ret = array("err"=>"Die eMail konnte nicht versendet werden");
    	echo json_encode($ret);
    	return false;
    } else {     
    	$ret = array("err"=>"Else: ".$res);
    	echo json_encode($ret);
    	return false;
    }
} else {
  	$ret = array("err"=>"Bitte alle Felder korrekt ausfüllen");
  	$ret=htmlentities($ret);
    echo json_encode($ret);
    return false;
}
