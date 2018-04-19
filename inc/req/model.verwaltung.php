<?php 
	class VerwaltungModel{

		private $dbhandler;
		private $settings;
		private $array = array();
		private $slides = array();
		
		public function __construct (){
			$Db = DB::getInstance();
			$this->dbhandler=$Db;
		}
		
		public function getFunctionListPoints(){
			
			$this->array = array(0 => array("name"=>"Aufträge","link"=>"?site=verwaltung&f=best"),
								1 => array("name"=>"Kunden","link"=>"?site=verwaltung&f=lief"),
								2 => array("name"=>"Ladungsträger","link"=>"?site=verwaltung&f=lt"),
								3 => array("name"=>"Import vorbereiten","link"=>"?site=verwaltung&f=import"),
								4 => array("name"=>"Inselverwaltung","link"=>"?site=verwaltung&f=insel"),
								5 => array("name"=>"Teamverwaltung","link"=>"?site=verwaltung&f=team"),
								6 => array("name"=>"Warengruppen","link"=>"?site=verwaltung&f=wg"),
								7 => array("name"=>"Abrechnung","link"=>"?site=verwaltung&f=abrechnung"),
								8 => array("name"=>"LV-Mail","link"=>"?site=verwaltung&f=usermail"),
					
								);
			return $this->array;
		}
		public function getInformationSlides(){
			$slider = new Slider();
			$this->slides = array(	
					0 => array( "title"=>"Backlog","content"=>$slider->displayBacklogData($slider->getBacklogData()) ),
					1 => array( "title"=>"Produktion","content"=>$slider->displayDailyProdData($slider->getDailyProdData()) )					
			);
			return $this->slides;
		}
		public function bestButtonNav(){
			$this->array = array(	0=>array("text"=>"neuen Auftrag generieren","func"=>"best","link"=>"neu"),
									1=>array("text"=>"Artikel einspielen","func"=>"best","link"=>"add"),
									2=>array("text"=>"Auftrag einsehen","func"=>"best","link"=>"view"),
									3=>array("text"=>"Auftrag automatisiert<br>importieren","func"=>"best","link"=>"autoImport")
			);
			return $this->array;
		}
		public function liefButtonNav(){
			$this->array = array(	0=>array("text"=>"neuen Kunden anlegen","func"=>"lief","link"=>"neu"),
									1=>array("text"=>"Kundenübersicht","func"=>"lief","link"=>"view"));
			return $this->array;
		}
		public function ltButtonNav(){
			$this->array = array(	0=>array("text"=>"neuen Ladungsträger anlegen","func"=>"lt","link"=>"neu"),
									1=>array("text"=>"Ladungsträger bearbeiten","func"=>"lt","link"=>"view"));
			return $this->array;
		}
		function getOrderData($orderID){
			$qryString = " SELECT
								tab_lieferant.name as supplier, tab_order.number as orderNumber,
								tab_order.delivery,tab_order.retour,tab_order.shipping,
								count(distinct tab_article.id) as articleCount, tab_article.articleGroupID,
								group_concat(DISTINCT wg_wg.name ORDER BY wg_articlegroup.depth SEPARATOR '<br>') as articlegroup,
								group_concat(DISTINCT prozess_station.short ORDER BY prozess_stationmatch.sort SEPARATOR '+') as process,
								tab_article.processCode,tab_order.naming,tab_order.comment,tab_order.lieferantID as supplierID,
								tab_order.personFoto,tab_order.personPost,tab_order.personContent,tab_order.pictureSize,
								tab_order.background,tab_order.views,tab_order.timelineFoto,tab_order.timelinePost,tab_order.timelineContent,
								tab_order.styling,tab_order.pictureType,tab_order.dpi,tab_order.crop,tab_order.remembrance,tab_order.namingPost,
								tab_order.textSize,tab_order.textTime,tab_order.seo,tab_order.salutation
							FROM tab_order
							LEFT JOIN tab_lieferant on tab_lieferant.id = tab_order.lieferantID
							LEFT JOIN tab_article ON tab_article.orderID = tab_order.id
							LEFT JOIN wg_articlegroup ON wg_articlegroup.id = tab_article.articleGroupID
							LEFT JOIN wg_wg ON wg_wg.id = wg_articlegroup.wgID
							LEFT JOIN prozess_stationmatch ON prozess_stationmatch.prozessID = tab_article.processCode
							LEFT JOIN prozess_station ON prozess_station.id = prozess_stationmatch.stationID
							WHERE tab_order.id = '".$orderID."'
							group by tab_article.articleGroupID,tab_article.processCode
							ORDER BY articlegroup
						";
			$sql = $this->dbhandler->qry($qryString);
			$res = $sql->fetch_assoc();
			return $res;
			
		}
		function updateOrderData($post){
			if(!isset($_GET["orderID"])){return false;}
			$orderID = $_GET["orderID"];
			if($orderID==0){return false;}
			$qryStringA = " UPDATE tab_article SET
								tab_article.retour ='".$post["retour"]."',
								tab_article.shipping ='".$post["shipping"]."'	
							WHERE tab_article.orderID = '".$orderID."'
						";
			$sqlA = $this->dbhandler->qry($qryStringA);
			
			$qryString = " UPDATE tab_order SET								
								tab_order.delivery ='".$post["delivery"]."',
								tab_order.retour ='".$post["retour"]."',
								tab_order.shipping ='".$post["shipping"]."',
								tab_order.naming ='".$post["naming"]."',
								tab_order.comment ='".$post["comment"]."',
								tab_order.personFoto ='".$post["personFoto"]."',
								tab_order.personPost ='".$post["personPost"]."',
								tab_order.personContent ='".$post["personContent"]."',
								tab_order.pictureSize ='".$post["pictureSize"]."',
								tab_order.background ='".$post["background"]."',
								tab_order.views ='".$post["views"]."',
								tab_order.timelineFoto ='".$post["timelineFoto"]."',
								tab_order.timelinePost ='".$post["timelinePost"]."',
								tab_order.timelineContent ='".$post["timelineContent"]."',
								tab_order.styling ='".$post["styling"]."',
								tab_order.pictureType ='".$post["pictureType"]."',
								tab_order.dpi ='".$post["dpi"]."',
								tab_order.crop ='".$post["crop"]."',
								tab_order.remembrance ='".$post["remembrance"]."',
								tab_order.namingPost ='".$post["namingPost"]."',
								tab_order.textSize ='".$post["textSize"]."',
								tab_order.textTime ='".$post["textTime"]."',
								tab_order.seo ='".$post["seo"]."',
								tab_order.salutation ='".$post["salutation"]."'
												
							WHERE tab_order.id = '".$orderID."'						
						";
			$sql = $this->dbhandler->qry($qryString);
			
			return $this->dbhandler->affected_rows;
				
		}
		function newOrder(){
			
			$in = array("");
			$in['form']["id"] = "orderCreate";
			$in['form']["class"] = "div_white borderRound block marginpadding5 relative";
			$in['input'][] = array("fieldgroup"=>"Notwendige Daten","class"=>"inline-block top" );
				
				$option["onchange"] = "isRequired(this,'submitNewOrder')";
				$option["col"] = "name";
				$option["name"] = "tab_lieferant";
				$in['input'][] = array(
						"rawHTML"=>"<fieldset><span class='legend'>Kunden</span>".
										Site::getSelectFromTab('tab_lieferant',$option).
										"<div class='rund div_green pointer'>
											<a title='neuen Kunden anlegen' href='?site=verwaltung&f=lief&t=neu'>+</a>
										</div>
									</fieldset>");
				$in['input'][] = array("type"=>"date","name"=>"dateOrder","id"=>"dateOrder","placeholder"=>"Datum Auftrag","autocomplete"=>"off",
						"value"=>date("d.m.Y"),"optional"=>"{01.11.2013}","patterntitle"=>"tt.mm.jjjj","pattern"=>"(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}");
				$option["first"] = "none";
				$option["col"] = "id";
				$option["name"] = "tab_ordertyp";
				$in['input'][] = array("rawHTML"=>"<fieldset><span class='legend'>Orderart</span>".
						Site::getSelectFromTab('tab_ordertyp',$option).
						"</fieldset>");
				$in['input'][] = array("type"=>"checkbox","name"=>"articleWithLabel","id"=>"articleWithLabel","placeholder"=>"Lieferung mit Artikellabel ");
				
			$in['input'][] = array("fieldgroupClose"=>"");
			
			$in['input'][] = array("fieldgroup"=>"Optionale Daten","class"=>"inline-block top" );
				$in['input'][] = array("type"=>"date","name"=>"dateDeliver","id"=>"dateDeliver","placeholder"=>"Lieferung am","autocomplete"=>"off",
					"value"=>"","optional"=>"{01.11.2013}","patterntitle"=>"tt.mm.jjjj","pattern"=>"(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}");
				$in['input'][] = array("type"=>"date","name"=>"dateRetour","id"=>"dateRetour","placeholder"=>"Datenretour bis","autocomplete"=>"off",
						"value"=>date("d.m.Y", strtotime("+7 days")),"optional"=>"{01.11.2013}","patterntitle"=>"tt.mm.jjjj","pattern"=>"(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}");
				$in['input'][] = array("type"=>"date","name"=>"dateShipping","id"=>"dateShipping","placeholder"=>"Rückversand bis","autocomplete"=>"off",
						"value"=>date("d.m.Y", strtotime("+7 days")),"optional"=>"{01.11.2013}","patterntitle"=>"tt.mm.jjjj","pattern"=>"(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}");
				
			$in['input'][] = array("fieldgroupClose"=>"");
			
			$in['input'][] = array("fieldgroup"=>"Ansprechpartner","class"=>"inline-block top" );
				$in['input'][] = array("type"=>"text","name"=>"projecctManager","placeholder"=>"Projektmanager","class"=>"textRight",
						"autocomplete"=>"off","value"=>"");
				$in['input'][] = array("type"=>"text","name"=>"personFoto","placeholder"=>"AP Foto","class"=>"textRight",
						"autocomplete"=>"off","value"=>"");
				$in['input'][] = array("type"=>"text","name"=>"personPost","placeholder"=>"AP Post","class"=>"textRight",
						"autocomplete"=>"off","value"=>"");
				$in['input'][] = array("type"=>"text","name"=>"personContent","placeholder"=>"AP Content","class"=>"textRight",
						"autocomplete"=>"off","value"=>"");
			$in['input'][] = array("fieldgroupClose"=>"");
						
			$in['input'][] = array("fieldgroup"=>"Kommentar","class"=>"inline-block top" );
				$in['input'][] = array("type"=>"textarea","name"=>"comm","rows"=>"4","cols"=>"40","value"=>"","class"=>'block glow textDarkGrey');
			$in['input'][] = array("fieldgroupClose"=>"");
			
			$in['input'][] = array("type"=>"submit","name"=>"submitNewOrder","id"=>"submitNewOrder","value"=>"Auftrag erstellen", "class"=>"bottomright","disabled"=>"");
				
			$this->array["form"] = Site::newForm($in);
			
			$this->array["title"] = "Auftrag generieren";
			$this->array["table"] = "";
			return $this->array;
		}
		
		function addArticleToOrder($orderid){
			$queryString = "SELECT tab_lieferant.name,number,DATE_FORMAT(date,'%d.%m.%Y') as date, tab_order.comment as comment, tab_lieferant.id as supplierID,
									DATE_FORMAT(delivery,'%d.%m.%Y') as delivery,  DATE_FORMAT(retour,'%d.%m.%Y') as retour,DATE_FORMAT(shipping,'%d.%m.%Y') as shipping 
					from tab_order LEFT JOIN tab_lieferant ON tab_lieferant.id = tab_order.lieferantID  WHERE tab_order.id = '".$orderid."'";
			$result = $this->dbhandler->qry($queryString);
			$res = $result->fetch_assoc();
			
			$values = array(
						array("caption"=>"Kunde:","value"=>$res["name"]),
						array("caption"=>"Auftragsnr:","value"=>$res["number"]),
						array("caption"=>"Bestelldatum:","value"=>$res["date"]),
						array("caption"=>"Lieferdatum:","value"=>$res["delivery"]),
						array("caption"=>"","value"=>"","class"=>"block"),
						array("caption"=>"Retourfrist:","value"=>$res["retour"]),
						array("caption"=>"Rückversandfrist:","value"=>$res["shipping"]),
						array("caption"=>"Kommentar:","value"=>$res["comment"],"class"=>"inline-block hoverResize petrol"));
			$in = array("");
			$in['form']["id"] = "orderAdd";
			$in['form']["class"] = "div_white borderRound block marginpadding5 relative";
			$in['form']["enctype"] = "multipart/form-data";
			$in['input'][] = array("type"=>"hidden","name"=>"orderId","value"=>$orderid);
			$in['input'][] = array("type"=>"hidden","name"=>"orderRetour","value"=>$res["retour"]);
			$in['input'][] = array("type"=>"hidden","name"=>"orderShipping","value"=>$res["shipping"]);
			$in['input'][] = array("fieldgroup"=>"<span class='lsf lsfIcon text30 textDarkGrey'>memo</span>Auftragsdaten","class"=>"block" );
			
			$in['input'][] = array("rawHTML"=>Site::newValueHeader($values,true));
			$in['input'][] = array("rawHTML"=>"<a href='index.php?site=verwaltung&f=best&t=edit&orderID=".$orderid."' class='textWhite smallButton'><span class='lsf lsfIcon text20'>edit</span>Ändern</a>");
			$in['input'][] = array("fieldgroupClose"=>"");
			
			$in['input'][] = array("fieldgroup"=>"<span class='lsf lsfIcon text30 textDarkGrey'>setup</span>Informationen hinzufügen","class"=>"block");
			$in['input'][] = array("rawHTML"=>"<span class='block smallText10'>gilt für alle leeren Felder in der CSV</span>");

			$in['input'][] = array("rawHTML"=>
					"<fieldset class='inline-block'><span class='margin5'>Warengruppe</span>".
					Site::getWGDropDown().
					"</fieldset>");
			
			$in['input'][] = array("rawHTML"=>
					"<fieldset class='inline-block'><span class='margin5'>Prozess</span>".
					Site::getProcessDropDown().
					"</fieldset>");
			//<div class='rund div_green pointer'><a title='neuen Prozess anlegen' href='?site=verwaltung&f=proc&t=neu'>+</a></div>
			$in['input'][] = array("fieldgroupClose"=>"");
		
			$in['input'][] = array("fieldgroup"=>"<span class='lsf lsfIcon text30 textDarkGrey'>pen</span>Artikel manuell eintragen","class"=>"","toggle"=>"addSingleArticle");
			$in['input'][] = array("rawHTML"=>"<div id='addSingleArticle' style='display:none'>");
			$in['input'][] = array("type"=>"text","name"=>"fileReplaceSAN","placeholder"=>"Artikelnummer","class"=>"textRight",
					"autocomplete"=>"off","value"=>"","placeholderAlign"=>"inline", "placeholderClass"=>"textLeft marginRight5 block");
			$in['input'][] = array("type"=>"text","name"=>"fileReplaceScan","placeholder"=>"Scancode","class"=>"textRight",
					"autocomplete"=>"off","value"=>"","placeholderAlign"=>"inline", "placeholderClass"=>"textLeft marginRight5 block");
			
			$in['input'][] = array("type"=>"date","name"=>"dateRetour","id"=>"dateRetour","placeholder"=>"Retourfrist","autocomplete"=>"off",
						"value"=>"","optional"=>"{01.11.2013}","patterntitle"=>"tt.mm.jjjj","pattern"=>"(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}",
						"placeholderAlign"=>"inline", "placeholderClass"=>"block textLeft marginRight5");
			
			$in['input'][] = array("rawHTML"=>
					"<fieldset class='inline-block'><span class='textLeft margin5 block'>Warengruppe</span>".
					Site::getWGDropDown(false,array("name"=>"selectWGSingle")).
					"</fieldset>");
			
			$in['input'][] = array("rawHTML"=>
					"<fieldset class='inline-block'><span class='textLeft margin5 block'>Prozess</span>".
					Site::getProcessDropDown(false,array("name"=>"selectProcessSingle")).
					"</fieldset>");
			$in['input'][] = array("type"=>"text","name"=>"comment","placeholder"=>"Kommentar","class"=>"textRight",
					"autocomplete"=>"off","value"=>"","placeholderAlign"=>"inline", "placeholderClass"=>"textLeft marginRight5 block");
				
			
			
			$in['input'][] = array("rawHTML"=>"</div>");
			$in['input'][] = array("fieldgroupClose"=>"");
			
			
			$in['input'][] = array("fieldgroup"=>"<span class='lsf lsfIcon text30 textDarkGrey'>clip</span>Artikeldaten laden","class"=>"","toggle"=>"addBulkArticle");
			$in['input'][] = array("rawHTML"=>"<div id='addBulkArticle' style='display:none'>");
			$in['input'][] = array("rawHTML"=>"<br>");
			$in['input'][] = array("type"=>"file","name"=>"file","id"=>"orderUploadFileInput","accept"=>".csv","label"=>"orderUploadFileInput",
					"labelText"=>"Datei vom PC wählen","mousetrigger"=>"onchange","mousetriggerValue"=>"uploadCSVFile(event,'outputRowCount')");
			$in['input'][] = array("type"=>"checkbox","name"=>"skipFirstRow","id"=>"skipFirstRow",
					"placeholder"=>"erste Zeile überspringen","placeholderClass"=>"textRight","placeholderAlign"=>"inline",
					"mousetrigger"=>"onclick","mousetriggerValue"=>"skipFirstLineInTab(this,'outputFileInput');","class"=>"inline-block");
			$in['progress'] = array("id"=>"uploadProgressbar", "style"=>"display:none;","min"=>0,"max"=>100,"value"=>0);
			$in['div'] = array("id"=>"outputRowCount","class"=>"inline-block");
			$in['input'][] = array("fieldgroupClose"=>"");
			
			$in['input'][] = array("type"=>"submit","name"=>"submitAddOrder","id"=>"submitAddOrder","value"=>"Daten absenden", "class"=>"bottomright text16");
			$this->array["header"] = Site::newValueHeader($values);
			$this->array["form"] = Site::newForm($in);
			$this->array["form"] .= "<div id='errorOutput' class='hidden div_red borderRound margin5 paddingSide5'></div>";
			$this->array["title"] = "Auftrag hochladen";
			$this->array["table"] = "<div id='outputFileInput' class='margin20 inline-block blackShadow'></div>";
			return $this->array;
		}
		function newSupplier(){
			$this->array["title"] = "neuen Kunden anlegen";
			$this->array["res"]["name"] = "";
			$this->array["res"]["contactIn"] = "";
			$this->array["res"]["contactEx"] = "";
			$this->array["res"]["email"] = "";
			$this->array["res"]["tel"] = "";
			$this->array["res"]["street"] = "";
			$this->array["res"]["addressAddition"] = "";
			$this->array["res"]["plz"] = "";
			$this->array["res"]["city"] = "";
			$this->array["res"]["comment"] = "";
			
			return $this->array;
		}
		function editSupplier($id){
			$queryString = "SELECT * from tab_lieferant WHERE id = '".$id."'";
			$result = $this->dbhandler->qry($queryString);
			$res = $result->fetch_assoc();
			$this->array["res"]["name"] = $res["name"];
			$this->array["res"]["contactIn"] = $res["contactIn"];
			$this->array["res"]["contactEx"] = $res["contactEx"];
			$this->array["res"]["email"] = $res["email"];
			$this->array["res"]["tel"] = $res["tel"];
			$this->array["res"]["street"] = $res["street"];
			$this->array["res"]["addressAddition"] = $res["addressAddition"];
			$this->array["res"]["plz"] = $res["plz"];
			$this->array["res"]["city"] = $res["city"];
			$this->array["res"]["comment"] = $res["comment"];
			$this->array["title"] = "Kunden bearbeiten";
			
			$queryStringR = "SELECT id,`receiver`,`toPerson`,`street`,`addressAddition`,`plz`,`city`,date_format(date,'%d.%m.%Y %H:%i') as date from lieferant_retouraddress WHERE supplierID = '".$id."'";
			$resultR = $this->dbhandler->qry($queryStringR);
			WHILE($resR = $resultR->fetch_assoc()){
				$this->array["table"]["content"]["view"][]=$resR;
			}
			
			return $this->array;
		}
		function editCarrier(){
			$this->array["title"] = "LT bearbeiten";
			$this->array["form"] = "";
			$this->array["table"] = "";
			return $this->array;
		}
		function newCarrier(){
			$in = array("");
			$in['form']["id"] = "carrierCreate";
			$in['form']["class"] = "div_white borderRound block marginpadding5 relative";
				
			$in['input'][] = array("fieldgroup"=>"Ladungsträgerinformationen");
			$in['input'][] = array("type"=>"text","name"=>"carrierName","id"=>"carrierName","placeholder"=>"Name",
					"required"=>"","autocomplete"=>"off","value"=>Site::outPOST('carrierName'),
					"ajaxButtonId"=>"checkCarrierNameButton","ajaxtrigger"=>"button",
					"ajax"=>"checkCarrierName('isFree','carrierName','checkCarrierNameButton','submitNewCarrier')");
			$option["onchange"] = "isRequired(this,'submitNewCarrier')";
			$option["first"] = "none";
			$option["name"] = "tab_standort";
			$in['input'][] = array(
				"rawHTML"=>"<fieldset><span class='legend'>Standort</span>".
								Site::getSelectFromTab('tab_standort',$option).	
				"</fieldset>");
			$in['input'][] = array("type"=>"submit","name"=>"submitNewCarrier","id"=>"submitNewCarrier","value"=>"neuen Eintrag erstellen","disabled"=>"","class"=>"bottomright");
			$in['input'][] = array("fieldgroupClose"=>"");
			$this->array["form"] = Site::newForm($in);
			
			$in = array("");
			$in['form']["id"] = "carrierCreateBulk";
			$in['form']["class"] = "div_white borderRound block marginpadding5 relative";
			$in['form']["enctype"] = "multipart/form-data";
			$in['input'][] = array("fieldgroup"=>"Ladungsträger-Bulk-Upload");
			$in['input'][] = array("rawHTML"=>"<br>");
			$in['input'][] = array("type"=>"file","name"=>"file","id"=>"orderUploadFileInput","accept"=>".csv","label"=>"orderUploadFileInput",
					"labelText"=>"Datei vom PC wählen","mousetrigger"=>"onchange","mousetriggerValue"=>"uploadCSVFile(event,'outputRowCount','submitCarrierBulk')");
			$in['input'][] = array("type"=>"checkbox","name"=>"skipFirstRow","id"=>"skipFirstRow",
					"placeholder"=>"erste Zeile überspringen","placeholderClass"=>"textRight","placeholderAlign"=>"inline",
					"mousetrigger"=>"onclick","mousetriggerValue"=>"skipFirstLineInTab(this,'outputFileInput');","class"=>"inline-block");
			
			$in['div'] = array("id"=>"outputRowCount","class"=>"inline-block");
			$in['input'][] = array("fieldgroupClose"=>"");
			//$option["onchange"] = "isRequired(this,'submitCarrierBulk')";
			$option["first"] = "none";
			$option["name"] = "tab_standort";
			$in['input'][] = array(
					"rawHTML"=>"<fieldset><span class='legend'>Standort</span>".
					Site::getSelectFromTab('tab_standort',$option).
							"</fieldset>");
			$in['progress'] = array("id"=>"uploadProgressbar", "style"=>"display:none;","min"=>0,"max"=>100,"value"=>0);
			$in['input'][] = array("type"=>"submit","name"=>"submitCarrierBulk","id"=>"submitCarrierBulk","value"=>"Upload durchführen","disabled"=>"","class"=>"bottomright");
			$in['input'][] = array("fieldgroupClose"=>"");
			$in['input'][] = array("rawHTML"=>"<div id='outputFileInput' class='margin20 inline-block blackShadow'></div>");
			
			$this->array["form"] .= Site::newForm($in);
			$this->array["form"] .= "<div id='errorOutput' class='hidden div_red borderRound margin5 paddingSide5'></div>";
			$this->array["title"] = "neuen Ladungstraeger anlegen";
			
			return $this->array;
		}
		
		function insertNewSupplier($userid,$PostArray,$edit=false){
			$i = 0;
			$j = 0;
			$ok = false;$double = false;
			if($edit==false){
				foreach($PostArray as $key=>$value){
					$i++;
					if($key=="supplierName"){
						$queryString = "SELECT id FROM tab_lieferant WHERE name = '".$value."'";
						$result = $this->dbhandler->qry($queryString);
						$anzahl = $result->num_rows;
						if($anzahl==0){
							$ok = true;
						}else{
							$double = true;
						}
					}
				}
			}else{
				$ok = true;
			}
			if($ok == true){
				if($PostArray["retourpostal"]==""){$PostArray["retourpostal"]=0;}
				if($edit!=false){					
					$queryString = "UPDATE tab_lieferant SET
										name = '".$PostArray["supplierName"]."',
										contactIn = '".$PostArray["contactInternal"]."',
										contactEx= '".$PostArray["contactExternal"]."',
										email = '".$PostArray["emailExternal"]."',
										tel = '".$PostArray["telExternal"]."',
										street = '".$PostArray["retourStreet"]."',
										addressAddition = '".$PostArray["retourStreetAddition"]."',			
										plz = '".$PostArray["retourpostal"]."',
										city = '".$PostArray["retourCity"]."',
										comment = '".$PostArray["comm"]."'
									WHERE id = '".$edit."'
								";
					
				}else{
					$queryString = "INSERT INTO tab_lieferant 
						( name,contactIn,contactEx,email,tel,
							street,plz,city,comment ) 
							VALUES 
						('".$PostArray["supplierName"]."','".$PostArray["contactInternal"]."','".$PostArray["contactExternal"]."','".$PostArray["emailExternal"]."','".$PostArray["telExternal"]."',
						'".$PostArray["retourStreet"]."','".$PostArray["retourpostal"]."','".$PostArray["retourCity"]."','".$PostArray["comm"]."')";
				}
				$result = $this->dbhandler->qry($queryString);
				$check = $this->dbhandler->affected_rows;
			}
			if($check==1){
				$text = "Erfolg<br><br>Deine Daten wurden erfolgreich gespeichert.";
				Site::innerPopUp('information_blue',$text,'popUpPersDataUpdate');
			}else if($double==true){
				$text = "Fehler<br><br><br>Deine Daten wurden nicht gespeichert.<br>Der Kunde existiert bereits!";
				Site::innerPopUp('warning',$text,'popUpPersDataUpdate');
			}else{
				$text = "Keine Änderung<br><br>Es wurden keine Daten geändert.";
				Site::innerPopUp('information_blue',$text,'popUpPersDataUpdate');
			}
		}
		function insertNewCarrier($userid,$PostArray,$bulk = false){
			$standortID = $this->dbhandler->real_escape_string($PostArray["tab_standort"]);
			if($bulk === true){
				if(!$_FILES["file"]['tmp_name'] && !isset($PostArray["fileReplaceSAN"])){
					$text = "Fehler<br><br><br>Du hast keine Datei ausgewählt.<br>";
					Site::innerPopUp('warning',$text,'popupNewOrder');
					return false;
				}
				$i = 0;
				$j = 0;
				$ok = false;
				$check = false;
				$this->dbhandler->autocommit(FALSE);
					
				// Zeilen importieren

				if(isset($PostArray["fileReplaceSAN"]) && $PostArray["fileReplaceSAN"]!= ''){
					$array[] = array($PostArray["orderId"],$PostArray["fileReplaceSAN"],$PostArray["fileReplaceScan"],$PostArray["tab_prozess"]);
					foreach($array as $inputrow){
						$cache = implode(";",$inputrow);
						$datarows[]  = $cache;
					}
				}else{
					$datei = $_FILES["file"]['tmp_name'];
					$handle = fopen($datei, 'r');
					WHILE($cache = fgetcsv ($handle, filesize($datei))){
						$datarows[]  =$cache[0];
					}
					fclose($handle);
				}
				foreach($datarows as $data){
					$i++;
					if($i==1 && isset($PostArray["skipFirstRow"])){
						continue;
					}
					$row = explode( ';',$data);
					$num = count($row);
					if($num == 1 && $row[0]!=''){	
						$ltname = $row[0];
						$queryString = "INSERT INTO logistik_lt
							( name,locationID,locationZoneID)
								VALUES
							('".$ltname."','".$standortID."','0')";
						$this->dbhandler->qry($queryString);
						if($this->dbhandler->affected_rows == 1){
							$j++;
							$ok = true;
						}
							
					}else{
						$ok = false;
					}
				}
					
				if($j == 0 ){
					$this->dbhandler->rollback();
					$text = "Fehler<br><br><br>Deine Daten wurden nicht gespeichert.<br>";
					Site::innerPopUp('warning',$text,'popUpPersDataUpdate');
				}
				else if($ok !== false){
					$this->dbhandler->commit();
					$text = "Erfolg<br><br>Es wurden ".$j."/".$i." Zeilen erfolgreich gespeichert.";
					Site::innerPopUp('information_blue',$text,'popUpPersDataUpdate');
				}else{
					$this->dbhandler->rollback();
					$text = "Fehler<br><br><br>Deine Daten wurden nicht gespeichert.<br>Die CSV-Datei enthält nicht genau 1 Spalte!";
					Site::innerPopUp('warning',$text,'popUpPersDataUpdate');
				}
					
				$this->dbhandler->autocommit(TRUE);
			}else{
				$ltname = $this->dbhandler->real_escape_string($PostArray["carrierName"]);
				$standortID = $this->dbhandler->real_escape_string($PostArray["tab_standort"]);
				$queryString = "SELECT id FROM logistik_lt WHERE name = '".$ltname."'";
				$result = $this->dbhandler->qry($queryString);
				$anzahl = $result->num_rows;
				if($anzahl==0){
					$ok = true;
				}else{
					$double = true;
				}
				if($ok == true){
					$queryString = "INSERT INTO logistik_lt
							( name,locationID,locationZoneID)
								VALUES
							('".$ltname."','".$standortID."','0')";
					$result = $this->dbhandler->qry($queryString);
					$check = $this->dbhandler->affected_rows;
				}
				if($check==1){
					$text = "Erfolg<br><br>Deine Daten wurden erfolgreich gespeichert.";
					Site::innerPopUp('information_blue',$text,'popUpPersDataUpdate');
				}else if($double==true){
					$text = "Fehler<br><br><br>Deine Daten wurden nicht gespeichert.<br>Der Ladungsträgername existiert bereits!";
					Site::innerPopUp('warning',$text,'popUpPersDataUpdate');
				}else{
					$text = "Keine Änderung<br><br>Es wurden keine Daten geändert.";
					Site::innerPopUp('information_blue',$text,'popUpPersDataUpdate');
				}
			}
		}
		function insertNewOrder($userid,$PostArray){
				$check = false;
				foreach($PostArray as $dirtyKey=>$dirtyVal){
					if(!is_array($dirtyVal)){
						$PostArray[$dirtyKey] = $this->dbhandler->real_escape_string($dirtyVal);
					}
				}
				if(!isset($_POST["dateOrder"])){
					$_POST["dateOrder"]=date("d.m.Y");
				}
				$PostArray["articleWithLabel"] = isset($PostArray["articleWithLabel"])?$PostArray["articleWithLabel"]:"";
				$PostArray["QaWithArticle"] = isset($PostArray["QaWithArticle"])?$PostArray["QaWithArticle"]:"";
				$PostArray["dateDeliver"] = (isset($PostArray["dateDeliver"])&&$PostArray["dateDeliver"]!='')?$PostArray["dateDeliver"]:"00.00.0000";
				$this->dbhandler->autocommit(FALSE);
				$queryString = "INSERT INTO tab_order
				( lieferantID,date,delivery,retour,shipping,comment,manager,articleWithLabel,orderTyp,
					personFoto, personPost, personContent )
					VALUES
				('".$PostArray["tab_lieferant"]."',
						STR_TO_DATE('".$PostArray["dateOrder"]."', '%d.%m.%Y'),
						STR_TO_DATE('".$PostArray["dateDeliver"]."', '%d.%m.%Y'),
						STR_TO_DATE('".$PostArray["dateRetour"]."', '%d.%m.%Y'),
						STR_TO_DATE('".$PostArray["dateShipping"]."', '%d.%m.%Y'),
						'".$PostArray["comm"]."','".$PostArray["projecctManager"]."',
						'".$PostArray["articleWithLabel"]."','".$PostArray["tab_ordertyp"]."',
					'".$PostArray["personFoto"]."','".$PostArray["personPost"]."','".$PostArray["personContent"]."' )";
				
				$result = $this->dbhandler->qry($queryString);
				$check = $this->dbhandler->affected_rows;
				
				if($check==1){
					$check = false;
					$id = $this->dbhandler->insert_id;
					$year = date("y");
					$m = date("n");
					$month = Site::getCharacterByMonth($m);
					$ordernumber = "ZU".$year.$month.str_pad($id, 5, 0, STR_PAD_LEFT);
					$queryString = "UPDATE tab_order SET number = '".$ordernumber."' WHERE id = '".$id."'";
					$result = $this->dbhandler->qry($queryString);
					$check = $this->dbhandler->affected_rows;
					if($check>0){
						$this->dbhandler->commit();
						$text = "Erfolg<br><br>Dein Auftrag wurde erfolgreich gespeichert.<br>
								<h2>Auftragsnummer: <a href='?site=verwaltung&f=best&t=add&edit=".$id."'>".$ordernumber."</a></h2>";
						
						Site::innerPopUp('information_blue',$text,'popUpPersDataUpdate');
					}
				}else{
					$this->dbhandler->rollback();
					$text = "Fehler<br><br><br>Deine Daten wurden nicht gespeichert.<br>";
					Site::innerPopUp('warning',$text,'popUpPersDataUpdate');
				}
				
				$this->dbhandler->autocommit(TRUE);
				return $id;
		}
		function insertArticleFromFormIntoOrder($postarray,$orderID){
			$this->dbhandler->autocommit(FALSE);
			$err=false;
			$all=0;
			foreach($postarray["Scancode"] as $key=>$val){
		
				$scancode = trim($postarray["Scancode"][$key]);
				if($scancode==""){
					continue;
				}
				$san = trim($postarray["Artikelnummer"][$key]);
				if(!isset($postarray["wgZuumeo"][$key]) || $postarray["wgZuumeo"][$key]==""){
					$wgID = 0;
				}else{
					$wgID = $postarray["wgZuumeo"][$key];
				}
				if(!isset($postarray["ProzessCode"][$key]) || $postarray["ProzessCode"][$key]==""){
					$proID = 0;
				}else{
					$proID = $postarray["ProzessCode"][$key];
				}	
					
				if(!isset($postarray["produkt"][$key]) || $postarray["produkt"][$key]==""){
					$productID = 0;
				}else{
					$productID = $postarray["produkt"][$key];
				}
				
				$genderID=0;
				if(isset($postarray["GeschlechtZ"][$key]) && $postarray["GeschlechtZ"][$key]!=''){
					switch($postarray["GeschlechtZ"][$key]){
						case "w":
						case "2":
							$genderID = 2;
							break;
						case "m":
						case "1":
							$genderID = 1;
							break;
						case "3":
						case "um":
							$genderID = 3;
							break;
						case "4":
						case "k":
							$genderID = 4;
							break;
						default:
							$genderID = 0;
							break;
					}					
				}
				if(isset($postarray["Artikelinformation"])){
				$comm = Site::outPOST($postarray["Artikelinformation"][$key]);
				}else{
					$comm="";
				}
				
				if(isset($postarray["Retourdatum"][$key])){
					$retour = $postarray["Retourdatum"][$key];
				}else{
					$retour = $postarray["dateRetour"];
				}
				$season="";
				if(isset($postarray["Saison"][$key])){
					$season = trim($postarray["Saison"][$key]);
				}				
				
				$size = "";
				if(isset($_POST["Groesse"][$key])){
					$size = $_POST["Groesse"][$key];
				}
				$queryPP = " SELECT claspID,detailsID,seasonID,sizeID,staticID,surfaceID
										FROM wg_produktion_default WHERE articlegroupID = '".$wgID."'";
				$resPP = $this->dbhandler->qry($queryPP);
				$PP = $resPP->fetch_assoc();
				
				if(!isset($PP["claspID"]) || $PP["claspID"]==""){$PP["claspID"]=1;}
				if(!isset($PP["seasonID"]) || $PP["seasonID"]==""){$PP["seasonID"]=1;}
				if(!isset($PP["sizeID"]) || $PP["sizeID"]==""){$PP["sizeID"]=1;}
				if(!isset($PP["staticID"]) || $PP["staticID"]==""){$PP["staticID"]=1;}
				if(!isset($PP["surfaceID"]) || $PP["surfaceID"]==""){$PP["surfaceID"]=1;}
				if(!isset($PP["detailsID"]) || $PP["detailsID"]==""){$PP["detailsID"]=1;}
		
				if(strpos($season, "HW")!==false){
					$PP["seasonID"] = 2;
				}else if(strpos($season, "FS")!==false){
					$PP["seasonID"] = 1;
				}
				$queryString = "INSERT INTO tab_article(
					orderID,san,scancode,processCode,comment,
					articlegroupID,retour,shipping,gender,
					claspID,detailsID,seasonID,sizeID,staticID,surfaceID,size
				)VALUES(
					'".$orderID."','".$san."','".$scancode."','".$proID."','".$comm."','".$wgID."',
					STR_TO_DATE('".$retour."', '%d.%m.%Y'),STR_TO_DATE('".$retour."', '%d.%m.%Y'),
					'".$genderID."','".$PP["claspID"]."','".$PP["detailsID"]."','".$PP["seasonID"]."','".$PP["sizeID"]."','".$PP["staticID"]."','".$PP["surfaceID"]."'
					,'".$size."'
				)";
				$result = $this->dbhandler->qry($queryString);
				if($this->dbhandler->affected_rows<1){
					$err = true;
				}else{
					$articleID = $this->dbhandler->insert_id;
					$queryString_apm = "REPLACE INTO article_product_match(
						articleID,productID
					)VALUES(
						'".$articleID."','".$productID."'
					)";
					$result_apm = $this->dbhandler->qry($queryString_apm);
					if(isset($postarray["addWE"]) && $postarray["addWE"]==1){
						
						$userID = $_SESSION["userid"];
						$qryString = "INSERT INTO logistik_log
										(articleID,we_user,we_timestamp,we_comment)
									VALUES
										('".$articleID."','".$userID."',NOW(),'')
									ON DUPLICATE KEY UPDATE we_comment = 'doppelt'";
						$sql = $this->dbhandler->qry($qryString);
					}
					$all++;
				}
		
			}
			if($err==false){
				$this->dbhandler->commit();
				$return = $all;
			}else{
				$this->dbhandler->rollback();
				$return = false;
			}
			$this->dbhandler->autocommit(TRUE);
			return $return;
		}
		function insertArticleInOrder($userid,$PostArray){
			if(!$_FILES["file"]['tmp_name'] && !isset($PostArray["fileReplaceSAN"])){
				$text = "Fehler<br><br><br>Du hast keine Datei ausgewählt.<br>";
				Site::innerPopUp('warning',$text,'popupNewOrder');
				return false;
			}
			//Warengruppe aus DropDown
			if(isset($PostArray["selectWG"]) && !empty($PostArray["selectWG"]) && $PostArray["selectWG"]!=""){
				$wgID = (int)$PostArray["selectWG"];
			}
			//Prozess aus DropDown
			if(isset($PostArray["selectProcess"]) && !empty($PostArray["selectProcess"]) && $PostArray["selectProcess"]!=""){
				$processID = (int)$PostArray["selectProcess"];
			}
			$i = 0;
			$j = 0;
			$ok = false;
			$check = false;
			$this->dbhandler->autocommit(FALSE);
			
			// Zeilen importieren
			$orderId = $PostArray["orderId"];
			$retByOrder = $PostArray["orderRetour"];
			$shippingByOrder = $PostArray["orderShipping"];
			if(isset($PostArray["fileReplaceSAN"]) && $PostArray["fileReplaceSAN"]!= ''){
				$array[] = array(
								trim($PostArray["fileReplaceSAN"]),
								trim($PostArray["fileReplaceScan"]),
								$PostArray["dateRetour"],
								$PostArray["selectWGSingle"],
								$PostArray["selectProcessSingle"],
								"",
								$PostArray["comment"]						
								);
				foreach($array as $inputrow){
					$cache = implode(";",$inputrow);
					$datarows[]  = $cache;
				}
			}else{
				if($datei = $_FILES["file"]['tmp_name']){
					$handle = fopen($datei, 'r');
					WHILE($cache = fgetcsv ($handle, filesize($datei))){
						if (array(null) !== $cache) {
							$datarows[]  =$cache[0];
						}
					}
					fclose($handle);
				}
			}
			if(isset($datarows) && is_array($datarows)){
				foreach($datarows as $data){
					
					$i++;
					if($i==1 && isset($PostArray["skipFirstRow"])){
						continue;
					}
					$row = explode( ';',$data);
					$row = array_filter( $row );
					$num = count($row);

					if($num==0){
						continue;
					}
					
					if($num > 0 && $num < 10 && $row[0]!=''){
						$col = " orderID, san, scancode  ";
					//ArtikelNummer
						$san = trim($row[0]);
					//Scancode
						if(isset($row[1]) && $row[1]!=''){
							$scan = trim($row[1]);
						}else{
							$scan = trim($row[0]);
						}
					//Warengruppe
						if(isset($row[3]) && $row[3]!=''){
							$wg = $row[3];
						}else if(isset($wgID)){
							$wg = $wgID;
						}
						
						
						$print[][] = $scan;
						$val = " '".$orderId."','".$san."','".$scan."' ";

						if(isset($wg)){
							$col .= ",articlegroupID ";
							$val .= " ,'".$wg."' ";
							
							// Saison
							if(isset($row[7]) && $row[7]!=''){
								if(strpos($row[7], "HW")!==false){
									$seasonInput = 2;
								}else{
									$seasonInput = 1;
								}
							}
							
							$queryPP = " SELECT claspID,detailsID,seasonID,sizeID,staticID,surfaceID
										FROM wg_produktion_default WHERE articlegroupID = '".$wg."'";
							$resPP = $this->dbhandler->qry($queryPP);
							$PP = $resPP->fetch_assoc();
							if(isset($seasonInput)){
								$PP["seasonID"] = $seasonInput;
							}
							if(!isset($PP["claspID"]) || $PP["claspID"]==""){$PP["claspID"]=1;}
							if(!isset($PP["seasonID"]) || $PP["seasonID"]==""){$PP["seasonID"]=1;}
							if(!isset($PP["sizeID"]) || $PP["sizeID"]==""){$PP["sizeID"]=1;}
							if(!isset($PP["staticID"]) || $PP["staticID"]==""){$PP["staticID"]=1;}
							if(!isset($PP["surfaceID"]) || $PP["surfaceID"]==""){$PP["surfaceID"]=1;}
							if(!isset($PP["detailsID"]) || $PP["detailsID"]==""){$PP["detailsID"]=1;}
							$col .= ",claspID,detailsID,seasonID,sizeID,staticID,surfaceID ";
							$val .= " ,'".$PP["claspID"]."','".$PP["detailsID"]."','".$PP["seasonID"]."','".$PP["sizeID"]."','".$PP["staticID"]."','".$PP["surfaceID"]."' ";
						}
						
						if(isset($row[2]) && $row[2]!=''){
							$col .= ",retour ";
							$val .= " ,'".$row[2]."' ";
						}else{
							$col .= ",retour ";
							$val .= " ,STR_TO_DATE('".$retByOrder."', '%d.%m.%Y') ";
						}
						if(isset($shippingByOrder) && $shippingByOrder!=''){
							
							$col .= ",shipping ";
							$val .= " ,STR_TO_DATE('".$shippingByOrder."', '%d.%m.%Y') ";
						}
						if(isset($row[5]) && $row[5]!=''){
							switch($row[5]){
								case "w":
								case "2":
									$gender = 2;
									break;
								case "m":
								case "1":
									$gender = 1;
									break;
								case "3":
								case "um":
									$gender = 3;
									break;
								case "4":
								case "k":
									$gender = 4;
									break;
								default:
									$gender = 0;
									break;
							}
							$col .= ",gender ";
							$val .= " ,'".$gender."' ";
						}
						
					//Prozess	
						if(isset($row[4]) && $row[4]!=''){
							$col .= ",processCode ";
							$val .= " ,'".$row[4]."' ";
						}else if(isset($processID)){
							$col .= ",processCode ";
							$val .= " ,'".$processID."' ";
						}
					// Kommentar
						if(isset($row[6]) && $row[6]!=''){
							$col .= ",comment ";
							$val .= " ,'".$row[6]."' ";
						}
					
					// Groesse
						if(isset($row[8]) && $row[8]!=''){
							$col .= ",size ";
							$val .= " ,'".$row[8]."' ";
						}
						
						$queryString = "INSERT INTO tab_article
							( ".$col." )
								VALUES
							( ".$val." )";

						$this->dbhandler->qry($queryString);
						if($this->dbhandler->affected_rows == 1){
							$j++;
							$ok = true;
						}
						
					}else{
						$ok = false;
					}
				}
			}
			if($j == 0 ){
				$this->dbhandler->rollback();
				$text = "Fehler<br><br><br>Deine Daten wurden nicht gespeichert.<br>";
				Site::innerPopUp('warning',$text,'popUpPersDataUpdate');
			}else if($ok !== false){
				
				$in = array();
				$in['form']["id"] = "exportScancodeList";
				$in['form']["class"] = "block";
				$in['form']["action"] = "excelExport.php";
				
				$in['input'][] = array("type"=>"hidden","name"=>"content","value"=>htmlentities(json_encode($print)));
				$in['input'][] = array("type"=>"submit","name"=>"submitScancodeList","value"=>"Liste der ScanCodes");
				$this->dbhandler->commit();
				$text = "Erfolg<br><br>Es wurden ".$j."/".$i." Zeilen erfolgreich gespeichert.";
				$text .= Site::newForm($in);
				Site::innerPopUp('information_blue',$text,'popUpPersDataUpdate');
			}else{
				$this->dbhandler->rollback();
				$text = "Fehler<br><br><br>Deine Daten wurden nicht gespeichert.<br>Die CSV-Datei enthält keine 4 Spalten!";
				Site::innerPopUp('warning',$text,'popUpPersDataUpdate');
			}
			
			$this->dbhandler->autocommit(TRUE);
		}
		function viewOrder($withTab = false,$orderOnly=false,$control=false){
			$in = array("");
			$in['form']["id"] = "filterOrder";
			$in['form']["class"] = "div_white borderRound block marginpadding5 relative";
			if($orderOnly==false){
				$in['form']["action"] = "?site=verwaltung&f=best&t=view";
			}else{
				$in['form']["action"] = "?site=verwaltung&f=best&t=add";
			}
			$this->array["title"] = "Auftrag suchen";
			
				
			$in['input'][] = array("fieldgroup"=>"Kunde","class"=>"inline-block");
				$option["first"] = "alle";
				$option["col"] = "name";
				$option["name"] = "tab_lieferant";
				$in['input'][] = array("rawHTML"=>Site::getSelectFromTab('tab_lieferant',$option));
			$in['input'][] = array("fieldgroupClose"=>"");
			$in['input'][] = array("fieldgroup"=>"Auftragsdatum","class"=>"inline-block");
			$in['input'][] = array("rawHTML"=>Site::datepicker('orderDate'));
			$in['input'][] = array("fieldgroupClose"=>"");
			$in['input'][] = array("fieldgroup"=>"Auftragsnummer","class"=>"inline-block");
				$in['input'][] = array("type"=>"text","name"=>"orderNumber","id"=>"orderNumber","value"=>Site::outPOST('orderNumber'));
			$in['input'][] = array("fieldgroupClose"=>"");
			if($orderOnly==false){
				$in['input'][] = array("fieldgroup"=>"Artikelnummer","class"=>"inline-block");
					$in['input'][] = array("type"=>"text","name"=>"san","id"=>"san","value"=>Site::outPOST('san'));
				$in['input'][] = array("fieldgroupClose"=>"");
				$in['input'][] = array("fieldgroup"=>"Scancode","class"=>"inline-block");
					$in['input'][] = array("type"=>"text","name"=>"scancode","id"=>"scancode","value"=>Site::outPOST('scancode'));
				$in['input'][] = array("fieldgroupClose"=>"");
			}
			$in['input'][] = array("type"=>"submit","name"=>"submitfilterOrder","id"=>"submitfilterOrder","value"=>"filtern");
				
			$this->array["form"] = Site::newForm($in);
			if($withTab){
				if(isset($control) && $control!= false){
					$control["rows"] = $control;
				}
				if(isset($withTab["pages"])){
					
					$count = 0;
					$tempCont = $withTab["content"]["view"];
					foreach($tempCont as $row){
						if(isset($row["hiddenarticleId"])){
							$row["reviewTyp"] = "<select name='errorTyp[".$row["hiddenarticleId"]."][]' style='width:60px'><option value='1'>faulty</option><option value='2'>reshoot</option></select>";
							$row["reviewReason"] = Site::getSelectFromTab('produktion_qa',array("id"=>'select'.$count,
									"name"=>'customError['.$row["hiddenarticleId"].'][]',
									"first"=>'',"firstVal"=>'0',
									"group"=>'gruppe',"class"=>' width175 smallText10',"col"=>'gruppe,name',
									"multiple"=>'multiple ',"selected"=>$row["hiddenErrors"],
									"onchange"=>"checkCheckbox('checkbox".$count."')")) ;
						}
						$tempArray[] = $row;
						$count++;
					}
					$withTab["content"]["view"] = $tempArray;
					if(isset($row["hiddenarticleId"])){
						$withTab['header']['Fehler'] = "Fehler";
						$withTab['header']['Grund'] = "Grund";
					}
					$control["pages"] = $withTab["pages"];
				}
				$this->array["table"] = Site::newTable($withTab['header'],
														$withTab['content'],
														'tableOrderContent',
														"div_grey_plain borderRoundTable marginTop10 widthFull text14",
														$control);
			}
			return $this->array;
		}
		function viewSupplier($withTab=false){
			$in = array("");
			$in['form']["id"] = "filterSupplier";
			$in['form']["class"] = "div_white borderRound block marginpadding5 relative";
			$this->array["title"] = "Kunde suchen";
				
			
			$in['input'][] = array("fieldgroup"=>"Kundenname","class"=>"inline-block");
				$in['input'][] = array("type"=>"text","name"=>"supplierName","id"=>"supplierName","value"=>Site::outPOST('supplierName'),"list"=>"kunden");

				
				$optionString ="";
				$customers = SITE::getArrayFromTab("tab_lieferant");
				foreach($customers as $cust){
					$optionString.="<option value='".$cust."'>";
				}
				$in['input'][] = array("rawHTML"=>"<datalist id='kunden'>".$optionString."</datalist>");
			$in['input'][] = array("fieldgroupClose"=>"");

			$in['input'][] = array("type"=>"submit","name"=>"submitfilterSupplier","id"=>"submitfilterSupplier","value"=>"filtern");
			
			$this->array["form"] = Site::newForm($in);
			if($withTab){
				if(isset($withTab["pages"])){
				
					$control["pages"] = $withTab["pages"];
				}
				$this->array["table"] = Site::newTable($withTab['header'],$withTab['content'],"","div_grey_plain borderRoundTable marginTop10 widthFull",$control);
			}
			return $this->array;
		}
		function getOrderByFilter($filter,$grouped=false){
			$i = 0;
			$where = "";
			
			foreach($filter as $col=>$val){
				if($i == 0){
					$where .= " WHERE ";
				}
				if($i > 0){	
					$where .= " AND ";
				}
				$i++;
				$where .= $col."='".$val."' ";
				
			}
			if($grouped!=false){
				//Gruppierte Ausgabe
				$qryString = "SELECT tab_lieferant.name as Kunde,
								tab_order.number as Auftragsnummer, 
								tab_ordertyp.name as Ordertyp,tab_order.comment as Kommentar,tab_order.date as Auftragsdatum,
								count(tab_article.san) as Artikelanzahl, tab_order.retour as 'Datenretourfrist',
								tab_order.shipping as 'Versandfrist',tab_order.id as onclick,GROUP_CONCAT(DISTINCT tab_product.name) as Produkt
							FROM tab_order
							LEFT JOIN tab_article ON tab_order.id = tab_article.orderID
							LEFT JOIN tab_ordertyp ON tab_ordertyp.id = tab_order.orderTyp
							LEFT JOIN tab_lieferant ON tab_lieferant.id = tab_order.lieferantID
							LEFT JOIN article_product_match apm ON apm.articleID = tab_article.id
							LEFT JOIN tab_product ON tab_product.id = apm.productID
							".$where." group by Auftragsnummer ORDER BY tab_order.id DESC";
			}else{
				$qryString = "SELECT tab_article.id as hiddenarticleId, tab_lieferant.name as Kunde,
								tab_order.number as Auftragsnummer, tab_order.date as Auftragsdatum,
								tab_article.san as Artikelnummer,tab_article.scancode as Scancode, 
								GROUP_CONCAT(DISTINCT wg_wg.name ORDER BY wg_articlegroup.depth SEPARATOR ' <br> ') as Warengruppe,
								
								if(logistik_log.we_timestamp is not null AND logistik_log.we_timestamp!=0,'&#10004;','') as WE,
								logistik_lt.name as 'LT-name',
								if(logistik_log.wa_timestamp is not null AND logistik_log.wa_timestamp!=0,'&#10004;','') as WA,
								tab_order.retour as 'Datenretour', tab_order.shipping as 'Versandfrist', process.abk as Prozess,
								tab_gender.short as Geschlecht,
								tab_article.size as Groesse, tab_article.comment as Info,
								tab_produktion_season.name as Saison,
								GROUP_CONCAT(DISTINCT tab_product.name) as Produkt,
								GROUP_CONCAT(produktion_review.errorID) as hiddenErrors
							FROM tab_article
							LEFT JOIN tab_order ON tab_order.id = tab_article.orderID
							LEFT JOIN tab_lieferant ON tab_lieferant.id = tab_order.lieferantID
							LEFT JOIN produktion_review ON produktion_review.articleID = tab_article.id
							LEFT JOIN logistik_matcharticlelt ON logistik_matcharticlelt.articleID = tab_article.id AND
																logistik_matcharticlelt.dateOff = 0
							LEFT JOIN logistik_lt ON logistik_lt.id = logistik_matcharticlelt.ltID
							LEFT JOIN logistik_log ON logistik_log.articleID = tab_article.id
							LEFT JOIN wg_articlegroup ON wg_articlegroup.id = tab_article.articlegroupID
							LEFT JOIN wg_wg ON wg_wg.id = wg_articlegroup.wgID
							LEFT JOIN tab_gender ON tab_gender.id = tab_article.gender
							LEFT JOIN article_product_match apm ON apm.articleID = tab_article.id
							LEFT JOIN tab_product ON tab_product.id = apm.productID
							LEFT JOIN tab_produktion_clasp FORCE INDEX (PRIMARY) ON tab_produktion_clasp.id = tab_article.claspID
							LEFT JOIN tab_produktion_details FORCE INDEX (PRIMARY) ON tab_produktion_details.id = tab_article.detailsID
							LEFT JOIN tab_produktion_season FORCE INDEX (PRIMARY) ON tab_produktion_season.id = tab_article.seasonID
							LEFT JOIN tab_produktion_size FORCE INDEX (PRIMARY) ON tab_produktion_size.id = tab_article.sizeID
							LEFT JOIN tab_produktion_static FORCE INDEX (PRIMARY) ON tab_produktion_static.id = tab_article.staticID
							LEFT JOIN tab_produktion_surface FORCE INDEX (PRIMARY) ON tab_produktion_surface.id = tab_article.surfaceID
							LEFT JOIN (SELECT prozessID, group_concat( short
										ORDER BY prozess_stationmatch.sort
										SEPARATOR '+' ) AS abk
										FROM `prozess_stationmatch`
										LEFT JOIN prozess_station ON `stationID` = prozess_station.id
										GROUP BY `prozessID`
										ORDER BY abk) as process ON process.prozessID =  tab_article.processCode ".$where."
							GROUP BY tab_article.id ORDER BY tab_order.number, tab_article.scancode";

			}
			$sql = $this->dbhandler->qry($qryString);
			$fields = $sql->fetch_fields();
			WHILE($row = $sql->fetch_assoc()){				
				$result["content"]["view"][] = $row;						
				$result["content"]["export"][] = $row;
			}
			if(!isset($result)){
				$result["content"]["view"][] = array("","keine","passenden","Daten","gefunden");
				$result["content"]["export"][] = array("","keine","passenden","Daten","gefunden");
			}
			foreach($fields as $field){
				if($field->name != "onclick"){					
					$result["header"][] = $field->name;
				}	
			}			
			return $result;
		}
		function getSupplierByFilter($filter){
			$i = 0;
			$where = "";
				
			foreach($filter as $col=>$val){
				$where = "WHERE ".$col." LIKE '%".$val."%' ";
		
			}
			
			$qryString = "SELECT tab_lieferant.id as onclick,
								tab_lieferant.id as ID,
								tab_lieferant.name as Kunde,
								tab_lieferant.contactIn as 'verantwortlicher Mitarbeiter',
								tab_lieferant.contactEx as Kontakt,
								tab_lieferant.email as eMail,
								tab_lieferant.tel as Telefon,
								CONCAT(tab_lieferant.street,'<br>', tab_lieferant.plz,' ', tab_lieferant.city) as Adresse,
								tab_lieferant.comment as Info
					FROM tab_lieferant ".$where." ORDER BY name";
			$sql = $this->dbhandler->qry($qryString);
			$fields = $sql->fetch_fields();
			WHILE($row = $sql->fetch_assoc()){
				$result["content"]["view"][] = $row;
				$result["content"]["export"][] = $row;
			}
			if(!isset($result)){
				$result["content"]["view"][] = array("","keine","passenden","Daten","gefunden");
				$result["content"]["export"][] = array("","keine","passenden","Daten","gefunden");
			}
			foreach($fields as $field){
				if($field->name != "onclick")
					$result["header"][] = $field->name;
			}
			return $result;
		}
		function deleteRowById($userid,$Postarray){
			$j=0;$i=0;$gotBooking=0;
			$tab = $Postarray["deleteTab"];
			foreach($Postarray["row"] as $row){
				$arr = json_decode($row, true);
				$idToDelete = $arr["delete"];
				$qryString = "
									SELECT 'WE/WA' as articleID FROM logistik_log WHERE (logistik_log.we_timestamp > 0 OR logistik_log.wa_timestamp > 0) AND articleID = '".$idToDelete."'
								UNION ALL
									SELECT 'LT' as articleID FROM logistik_matcharticlelt WHERE dateOff = 0 AND articleID = '".$idToDelete."'
								UNION ALL
									SELECT 'Produktion' as articleID  FROM produktion_log where articleID = '".$idToDelete."' AND produktion_log.timestamp>0								
								UNION ALL
									SELECT 'QA' as articleID FROM produktion_qa_log where articleID = '".$idToDelete."'
								UNION ALL
									SELECT 'KF' as articleID FROM produktion_klaerfall_log where articleID = '".$idToDelete."'
								UNION ALL
									SELECT 'OS' as articleID FROM produktion_outsourcing_log where articleID = '".$idToDelete."'
								
						";
				$sql = $this->dbhandler->qry($qryString);
				if($sql->num_rows == 0){
					
					$qryString = "DELETE FROM ".$tab." WHERE id  = '".$idToDelete."'";
					$sql = $this->dbhandler->qry($qryString);
					if($this->dbhandler->affected_rows == 1){
						$j++;
					}
					$qryString = "DELETE FROM zone_log WHERE articleID  = '".$idToDelete."'";
					$sql = $this->dbhandler->qry($qryString);
					$qryString = "DELETE FROM logistik_log WHERE articleID  = '".$idToDelete."'";
					$sql = $this->dbhandler->qry($qryString);
					$qryString = "DELETE FROM logistik_matcharticlelt WHERE articleID  = '".$idToDelete."'";
					$sql = $this->dbhandler->qry($qryString);
					$qryString = "DELETE FROM produktion_log WHERE articleID  = '".$idToDelete."'";
					$sql = $this->dbhandler->qry($qryString);
				}else{
					$reason = $sql->fetch_assoc();
					$reasons=array();
					foreach($reason as $k=>$v){
						$reasons[]=$v;
					}
					$booking[$i]=implode($reasons);
					$gotBooking++;
				}
				$i++;
			}
			if($i==0){
				$text = "Fehler<br><br><br>Deine Daten wurden nicht gespeichert.<br>Du hast keine Zeilen markiert!";
				Site::innerPopUp('warning',$text,'popUpPersDataUpdate');
			}else if($gotBooking>0){
				$text = "Achtung<br><br>Es wurden ".$j."/".$i." Zeilen erfolgreich gespeichert.<br>";
				$text .= "Es wurden zu ".$gotBooking." Artikeln bereits Buchungen getätigt. Artikel mit Buchungen können nicht gelöscht werden!!<br><hr>";
				foreach($booking as $x=>$y){
					$text .= ($x+1).". Artikel: ".$y."<br>";
				}
				 
				Site::innerPopUp('warning',$text,'popUpPersDataUpdate');	
			}else{
				$text = "Erfolg<br><br>Es wurden ".$j."/".$i." Zeilen erfolgreich gespeichert.<br>";
				
				Site::innerPopUp('information_blue',$text,'popUpPersDataUpdate');
			}
		}
		function updateProductionErrorByArticleID($userid,$Postarray){
			$j=0;$i=0;
			$articleID = $this->dbhandler->real_escape_string($Postarray["articleID"]);
			$errorIDs = $Postarray["errorID"];
			$errorTyp = $this->dbhandler->real_escape_string($Postarray["errorTyp"][0]);
			foreach ($errorIDs as $errorID){
				$errorID = $this->dbhandler->real_escape_string($errorID);
				$qryString = "INSERT INTO produktion_review 
								(articleID,errorID,errorTyp,date,userID) 
							VALUES 
								('".$articleID."','".$errorID."','".$errorTyp."',NOW(),'".$userid."')
							ON DUPLICATE KEY UPDATE id=id			";
				$sql = $this->dbhandler->qry($qryString);
				if($this->dbhandler->affected_rows == 1){
					$i++;
				}
				
			}

			if($i==0){
				$errArr = array("post"=>$Postarray,"query"=>$qryString,"ifName"=>"affected_rows","ifValue"=>$success);
				$err = print_r($errArr,true);
				Log::logError('WorkflowErrorInElse',$err);
				return 0;
			}else{
				return 1;
			}
		}
		function exportScanList($userid,$Postarray){
			$i=0;$scan = array();
			if(isset($Postarray["row"])){
				foreach($Postarray["row"] as $row){
					$arr = json_decode($row, true);
					$scan[][] = $arr["scanList"];
					$i++;
				}
				
				$form = "<form class='inline' id='exportForm' method='POST' action='excelExport.php'><input type='hidden' name='content' value='".json_encode($scan)."'></form>";
				$form .= "<script type='text/javascript'>function myfunc () {var frm = document.getElementById('exportForm');frm.submit();}window.onload = myfunc;</script>";
			}
			if($i==0){
				$text = "Fehler<br><br><br>Du hast keine Zeilen markiert!";
				Site::innerPopUp('warning',$text,'popUpPersDataUpdate');
			}else{
				echo $form;
			}
		}
		function getIslandsAndStations(){
			$qryString = "SELECT id,name
						FROM tab_insel
					";
			$sql = $this->dbhandler->qry($qryString);
				
			WHILE($row = $sql->fetch_assoc()){
				$inselID = $row["id"];
				$inselName = $row["name"];
				$qryStringStation = "SELECT produktion_station.name as stationName, 
											produktion_station.id as stationID,
											produktion_station_inselmatch.id as stationMatch
							FROM produktion_station
							LEFT JOIN produktion_station_inselmatch ON produktion_station_inselmatch.stationID = produktion_station.id
																	AND produktion_station_inselmatch.inselID = '".$inselID."'
																	AND produktion_station_inselmatch.active=1
						";
				$sqlStation = $this->dbhandler->qry($qryStringStation);
				$temp = Array();
				WHILE($rowStation = $sqlStation->fetch_assoc()){
					$temp["stations"][] = $rowStation;
				}
				$temp["inselName"] = $inselName;
				$result[$inselID] = $temp;
			}
			
			return $result;
		}
		function updateIslandStationMatching($inselID,$stations){
			$stationString = implode(",", $stations);
			$qry = "SELECT id FROM produktion_station";
			$sql = $this->dbhandler->qry($qry);
			WHILE($row = $sql->fetch_assoc()){
				$availableStations[] = $row;
			}
			foreach($availableStations as $station){
				if(in_array($station["id"],$stations)){
					// Station wurde mittels Checkbox gewählt -> soll aktiv sein
					$qry = "INSERT INTO produktion_station_inselmatch (stationID,inselID)
						VALUES ('".$station["id"]."','".$inselID."') ON DUPLICATE KEY UPDATE active=1";
					$this->dbhandler->qry($qry);
				}else{
					$qryUnset = "UPDATE produktion_station_inselmatch SET active=0 
								WHERE stationID='".$station["id"]."' AND inselID = '".$inselID."'";
					$this->dbhandler->qry($qryUnset);
				}		
			}
			return true;
		}
		function getUsersInStation($stationID){
			$qryH = "SELECT tab_dept.id, displayname as name
						FROM tab_dept ORDER BY sort
						";
			$sqlH = $this->dbhandler->qry($qryH);
			WHILE($data =  $sqlH->fetch_assoc()){
				$header[] = $data["name"];
			}
			$qry = "SELECT id as userID,name as userName,role as userRole,email as userMail,isExternal,isActive FROM user 
					WHERE abteilungId = '".$this->dbhandler->real_escape_string($stationID)."'
					ORDER BY isActive DESC,isExternal ASC,regkey DESC,role ASC,usergroup ASC ,id DESC";
			$sql = $this->dbhandler->qry($qry);
			WHILE($row = $sql->fetch_assoc()){
			
				$qryD = "SELECT tab_dept.id, displayname as name, view.id as visible
						FROM tab_dept 
						LEFT JOIN view ON tab_dept.id = view.deptID AND userId = '".$row["userID"]."'
						ORDER BY sort";
				$sqlD = $this->dbhandler->qry($qryD);
				$view = array();
				WHILE($rowD = $sqlD->fetch_assoc()){
					$view[] = $rowD;
				}
				$row["view"] = $view;
				$content[] = $row;
			}
			if(!isset($content)){$content = array();}
			return array("header"=>$header,"content"=>$content);
		}
		function updateUserView($userID,$modules,$change){
			$userID = $this->dbhandler->real_escape_string($userID);
			$role = $this->dbhandler->real_escape_string($change["role"]);
			$abt = $this->dbhandler->real_escape_string($change["abt"]);
			$ext = $this->dbhandler->real_escape_string($change["ext"]);
			$active = $this->dbhandler->real_escape_string($change["active"]);
			$count = 0;
			$deptArray = "";
			foreach($modules as $dept){
				if($count!=0){
					$deptArray .= ",";
				}
				$deptArray .= "('".$dept."','".$userID."')";
				$count++;
			}
			$qryOK = true;
			$this->dbhandler->autocommit(FALSE);
			$qry = "UPDATE user SET role = '".$role."',abteilungId = '".$abt."',isExternal='".$ext."',isActive='".$active."' WHERE id = '".$userID."'";
			$this->dbhandler->qry($qry) ? null : $qryOK=false;
			$check = $this->dbhandler->affected_rows;
			
			$qry = "DELETE FROM view WHERE userId = '".$userID."'";
			$sql = $this->dbhandler->qry($qry);
			$this->dbhandler->qry($qry) ? null : $qryOK=false;
			
			$qry = "INSERT INTO view (deptId,userId) VALUES ".$deptArray."";
			$this->dbhandler->qry($qry) ? null : $qryOK=false;
			
			$this->dbhandler->autocommit(TRUE);
			if($qryOK==true){
				$this->dbhandler->commit();
				$text = "Erfolg<br><br>Deine Änderung wurde erfolgreich gespeichert.<br>
								";
					
				Site::innerPopUp('information_blue',$text,'popUpPersDataUpdate');
			}else{
				$this->dbhandler->rollback();
			}
		}

		function insertNewRetouradress($userID,$Postarray){
			foreach($Postarray as $key=>$value){
				$value = $this->dbhandler->real_escape_string($value);
				$arr[$key] = trim($value);
			}
			
			$qry = "INSERT INTO lieferant_retouraddress 
					(supplierID,receiver,toPerson,street,addressAddition,plz,city,userID,date)
					VALUES
					('".$arr["supplierID"]."','".$arr["receiver"]."','".$arr["toPerson"]."','".$arr["street"]."',
					'".$arr["addressAddition"]."','".$arr["plz"]."','".$arr["city"]."','".$userID."',NOW())";
			$res = $this->dbhandler->qry($qry);
			if($this->dbhandler->affected_rows>0){
				$text = "Erfolg<br><br>Deine Eingaben wurde erfolgreich gespeichert.<br>";	
				Site::innerPopUp('information_blue',$text,'popUpPersDataUpdate');
			}else{
				$text = "Fehler<br><br>Deine Eingaben wurde nicht gespeichert.";
				Site::innerPopUp('warning',$text,'popUpPersDataUpdate');
			}
		}
		function deleteRetouradress($userID,$Postarray){		
			$retID = $this->dbhandler->real_escape_string($Postarray["retourID"]);
			$qry = "DELETE FROM lieferant_retouraddress WHERE id='".$retID."'";
			$res = $this->dbhandler->qry($qry);
			if($this->dbhandler->affected_rows>0){
				$text = "Erfolg<br><br>Der Eintrag wurde gelöscht.<br>";
				Site::innerPopUp('information_blue',$text,'popUpPersDataUpdate');
			}else{
				$text = "Fehler<br><br>Deine Eingaben wurde nicht gespeichert.";
				Site::innerPopUp('warning',$text,'popUpPersDataUpdate');
			}
		}
		
	
		function importOverview($filter){			
			$this->configarray = array();
      
			if(isset($filter["supplier"]) AND $filter["supplier"] != 0){
				$dateSince = $filter["dateSince"];
				$supplierID = $filter["supplier"];

				$qry = "SELECT id, eMailAddress, username, password, mailSubject, filename, customer,isMail,isFTP,host,mail_label FROM config_import WHERE supplierID = '".$supplierID."'";
				$res = $this->dbhandler->qry($qry);
				WHILE($row = $res->fetch_assoc()){
					$this->configarray["config_import"][] = $row;
				}
				
				//Mail - Connect
				if($this->configarray["config_import"][0]["isMail"]==1){
					// Connect
					$hostname = '{imap.gmail.com:993/imap/ssl}'.$this->configarray["config_import"][0]["mail_label"];
					$username = $this->configarray["config_import"][0]["username"];			
					$password = $this->configarray["config_import"][0]["password"];
					$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());						
					//Get Mails
					$since= date("Y-m-d", strtotime("-3 days"));
					$emails = imap_search($inbox,'SUBJECT "'.$this->configarray["config_import"][0]["mailSubject"].'" SINCE "'.$since.'"');
					if($emails) {
						/* put the newest emails on top */
						rsort($emails);					
						/* for every email... */
						$i=0;
						
						foreach($emails as $email_number) {
							$i++;
							if($i>10){
								break;
							}
							/* get information specific to this email */
							$overview = imap_fetch_overview($inbox,$email_number,0);
							$info = imap_fetchstructure($inbox, $email_number);	
							//Get Att. of each Mail
							if(count($info->parts)>0){
								$pCount=0;
								foreach ($info->parts as $pCount=>$part) {
									$name=false;									
									$attachments[$pCount]=array("attachment"=>"");
									if ($part->type==3 && $part->disposition == "ATTACHMENT") {
										if(isset($part->dparameters)){
											foreach($part->dparameters as $dpara){
												if($dpara->attribute=="FILENAME" && $dpara->value==$this->configarray["config_import"][0]["filename"]){
													$name=$dpara->value;
													break;
												}
											}
										}else if(isset($part->parameters)){
											foreach($part->parameters as $para){
												if($para->attribute=="NAME" && $para->value==$this->configarray["config_import"][0]["filename"]){
													$name=$para->value;
													break;
												}
											}
										}
										if($name!=false){
											
											$attachments[$pCount]['attachment'] = imap_fetchbody($inbox, $email_number,$pCount+1);											
											$orderdate=date("d.m.Y",strtotime((string)$overview[0]->date));
											// check if this is base64 encoding
											if ($part->encoding == 3) { // 3 = BASE64
												$attachments[$pCount]['decode'] = "base64";												
												$rows = explode("\n",base64_decode($attachments[$pCount]['attachment']));
												
												$ordertyp=0;
												$rowset=array();
												$fehlerhaftezeilen=array();
												foreach($rows as $r=>$c){													
													$thisRow=explode(";", $c);
													$newRow=false;
													if($this->configarray["config_import"][0]["customer"]=="Zalando VM" && count($thisRow)>5){
														$thisRow[0]=(int)$thisRow[0];														
														if(is_numeric($thisRow[0]) && $thisRow[0]>0){
															$format = 'Y-m-d';
															$date = DateTime::createFromFormat($format, '1899-12-30');
															$int = 'P'.$thisRow[0].'D';
															$date->add(new DateInterval($int));
															$format2 = 'd.m.Y';
															$date2 = DateTime::createFromFormat($format2, date("d.m.Y",strtotime((string)$overview[0]->date)));
															if($date==$date2){
																//SKU -> WGPfad -> wgID,proID,gender
																try{
																	$ch = curl_init();
																	$base=$_SERVER["SERVER_ADDR"]."/lv";
																	//$base="localhost/gitLV/lagerverwaltung";
																	curl_setopt($ch,CURLOPT_URL,$base."/req/ajaxExternal.php?getWGBySKU=".$thisRow[1]);
																	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
																	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
																	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
																	$headers = array();
																	//$host   = 'z-produktion';
																	//$headers[] = "Host: $host";
																	//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
																	$output=curl_exec($ch);
																	$obj = json_decode($output);
																	curl_close($ch);
																	$saison="";
																	if(is_object($obj)){
																		if(isset($obj->data)){
																			$prodParam=$this->getProdParamFromExtWG(20,$obj->data->wg);																			
																			if(is_null($prodParam)){
																				if(isset($fehlerhaftezeilen_wg[$orderdate][$ordertyp])){
																					$fehlerhaftezeilen_wg[$orderdate][$ordertyp][]=$obj->data->wg;
																				}else{
																					$fehlerhaftezeilen_wg[$orderdate][$ordertyp]=array();
																					$fehlerhaftezeilen_wg[$orderdate][$ordertyp][]=$obj->data->wg;
																				}
																			}
																			$saison=$obj->data->saison;
																		}else{																				
																			if(isset($fehlerhaftezeilen[$orderdate][$ordertyp])){
																				$fehlerhaftezeilen[$orderdate][$ordertyp][]=$thisRow[1];
																			}else{
																				$fehlerhaftezeilen[$orderdate][$ordertyp]=array();
																				$fehlerhaftezeilen[$orderdate][$ordertyp][]=$thisRow[1];
																			}
																			
																			$prodParam=array("wgID"=>"0","prozessID"=>"0","gender"=>"0");
																			$saison="";																				
																		}																		
																	}else{
																		
																	}
																}catch(Exception $e){var_dump($e);}
																if(isset($thisRow[6]) && !empty($thisRow[6])){
																	$rformat = 'Y-m-d';
																	$rdate = DateTime::createFromFormat($rformat, '1899-12-30');
																	$rint = 'P'.$thisRow[6].'D';
																	$rdate->add(new DateInterval($rint));
																	$thisRow[6]=$rdate->format("d.m.Y");
																}
																/*
																* Datum SKU QL Standort EAN WG Retour KW Monat Jahr
																*
																* SKU EAN WG Pro gender Saison Groesse Retour Info
																*/																
																if(!isset($prodParam["wgID"]) || $prodParam["wgID"]==""){$prodParam["wgID"]=0;}
																if(!isset($prodParam["prozessID"]) || $prodParam["prozessID"]==""){$prodParam["prozessID"]=0;}
																if(!isset($prodParam["gender"]) || $prodParam["gender"]==""){$prodParam["gender"]=0;}
																
																if(isset($thisRow[3]) && strpos($thisRow[3],'Zuumeo +')!==false){
																	$produkt = "Plus";
																}else{
																	$produkt ="";
																}
																$newRow=array($thisRow[1],ltrim($thisRow[4],'0'),$prodParam["wgID"],$produkt,$prodParam["prozessID"],$prodParam["gender"],$saison,"",$thisRow[6],$thisRow[2],"datum"=>$thisRow[0]);
																$ordertyp="Erstorder";
															}
														}																										
													}
													if($this->configarray["config_import"][0]["customer"]=="Zalando SalesOrder" && count($thisRow)>5){
														$thisRow[11]=(int)$thisRow[11];
														
														if(is_numeric($thisRow[11]) && $thisRow[11]>0){
															$format = 'Y-m-d';
															$date = DateTime::createFromFormat($format, '1899-12-30');
															$int = 'P'.$thisRow[11].'D';
															$date->add(new DateInterval($int));
															$format2 = 'd.m.Y';
															$date2 = DateTime::createFromFormat($format2, date("d.m.Y",strtotime((string)$overview[0]->date)));
															if($date==$date2){
																//SKU -> WGPfad -> wgID,proID,gender
																try{
																	$ch = curl_init();
																	$base=$_SERVER["SERVER_ADDR"]."/lv";
																	//$base="localhost/gitLV/lagerverwaltung";
																	curl_setopt($ch,CURLOPT_URL,$base."/req/ajaxExternal.php?getWGBySKU=".$thisRow[13]);
																	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
																	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
																	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
																	$headers = array();
																	//$host   = 'z-produktion';
																	//$headers[] = "Host: $host";
																	//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
																	$output=curl_exec($ch);
																	$obj = json_decode($output);
																	curl_close($ch);
																	$saison="";
																	if(is_object($obj)){
																		if(isset($obj->data)){
																			$prodParam=$this->getProdParamFromExtWG(20,$obj->data->wg);
																			if(is_null($prodParam)){
																				if(isset($fehlerhaftezeilen_wg[$orderdate][$ordertyp])){
																					$fehlerhaftezeilen_wg[$orderdate][$ordertyp][]=$obj->data->wg;
																				}else{
																					$fehlerhaftezeilen_wg[$orderdate][$ordertyp]=array();
																					$fehlerhaftezeilen_wg[$orderdate][$ordertyp][]=$obj->data->wg;
																				}
																			}
																			$saison=$obj->data->saison;
																		}else{
																			
																			if(isset($fehlerhaftezeilen[$orderdate][$ordertyp])){
																				$fehlerhaftezeilen[$orderdate][$ordertyp][]=$thisRow[13];
																			}else{
																				$fehlerhaftezeilen[$orderdate][$ordertyp]=array();
																				$fehlerhaftezeilen[$orderdate][$ordertyp][]=$thisRow[13];
																			}
																			$prodParam=array("wgID"=>"0","prozessID"=>"0","gender"=>"0");
																			$saison="";
																			
																		}									
																	}
																	}catch(Exception $e){var_dump($e);}
																/*
																 * AufArt AufNr AufName SKU EAN Anz X Stat Liefer Insel Ordertyp Datum Ziel Config Lager
																*
																* SKU EAN WG Pro gender Saison Groesse Retour Info
																*/
																if(!isset($prodParam["wgID"]) || $prodParam["wgID"]==""){$prodParam["wgID"]=0;}
																if(!isset($prodParam["prozessID"]) || $prodParam["prozessID"]==""){$prodParam["prozessID"]=0;}
																if(!isset($prodParam["gender"]) || $prodParam["gender"]==""){$prodParam["gender"]=0;}
																
																if(isset($thisRow[9]) && strpos($thisRow[9],'Zuumeo +')!==false){
																	$produkt = "Plus";
																}else{
																	$produkt ="";
																}
																
																$newRow=array($thisRow[13],ltrim($thisRow[4],'0'),$prodParam["wgID"],$produkt,$prodParam["prozessID"],$prodParam["gender"],$saison,"","","","datum"=>(int)$thisRow[11]);	
																$ordertyp=$thisRow[10];
															}
														}
														
													}
													if($newRow!=false){													
														$rowset[$orderdate][$ordertyp][]=$newRow;
													}
												}								
											}
											//Generate Row for each Mail
											if(isset($rowset) && is_array($rowset)){
												foreach($rowset as $date=>$ordersDay){
													foreach($ordersDay as $oTyp=>$oArray){	
														$link1_href=$link1_text=$link2_href=$link2_text="";
														
														if(isset($fehlerhaftezeilen[$date][$oTyp])){
															$link1_href=base64_encode(serialize($fehlerhaftezeilen[$date][$oTyp]));
															$link1_text=count($fehlerhaftezeilen[$date][$oTyp])." ohne Stammdaten";
														}	
														if(isset($fehlerhaftezeilen_wg[$date][$oTyp])){
															$wgs=array_unique($fehlerhaftezeilen_wg[$date][$oTyp]);
															$link2_href=SITE::arrayToTable($wgs,false);
															$link2_text=count($wgs)." unbekannte WG";
														}											
														$results[] = array(
															'name' => $name,
															'ordertyp'=>$oTyp,
															'timestamp' => $orderdate,
															'rows' => count($oArray),
															'errorrows' => "<a target='_blank' href='index.php?site=usermail&to=1&form=1&data=".$link1_href."'>".$link1_text."</a>".
																			"<a class='linkBlue marginLeft10 inline-block' onclick='createPopup(\"".$link2_href."\")'>".$link2_text."</a>",
															'button'=>'<form method="POST" target="importSO">
								                					<input type="hidden" name="dateFile" value="'.date("d.m.Y",strtotime((string)$overview[0]->date)).'">
								                					<input type="hidden" name="parseData" value="'.base64_encode(serialize($oArray)).'">
																
																	<input type="hidden" name="genderValue" value="'.base64_encode(serialize(array("u"=>0,"m"=>1,"w"=>2,"um"=>3,"k"=>4))).'">
								                					<input type="hidden" name="col[]" value="Artikelnummer">
										                			<input type="hidden" name="col[]" value="Scancode">
								                					<input type="hidden" name="col[]" value="WarengruppenCode">
																	<input type="hidden" name="col[]" value="Produkt">
								                					<input type="hidden" name="col[]" value="ProzessCode">
										                			<input type="hidden" name="col[]" value="Geschlecht">
										                			<input type="hidden" name="col[]" value="Saison">
								                					<input type="hidden" name="col[]" value="Groesse">
																	<input type="hidden" name="col[]" value="Retourdatum">
								                					<input type="hidden" name="col[]" value="Artikelinformation">
								    							    <input type="hidden" name="decode" value="'.$attachments[$pCount]['decode'].'">
								                					<input type="submit" name="transform" value="waehlen" >
								                					<input type="hidden" name="tab_lieferant" value="'.$_POST["tab_lieferant"].'">		
																	<input type="hidden" name="hidden_ordertyp" value="'.$this->getOrdertypByString($oTyp,$supplierID).'">			
																	<input type="hidden" name="hidden_comment" value="">				                					
							                					</form>',
				                							'button_dl'=>'<form method="POST" action="csv_dl.php" target="_blank">
							                						<input type="submit" name="csv" value="CSV DL">
							                						<input type="hidden" name="parseData" value="'.$attachments[$pCount]['attachment'].'">
							                						<input type="hidden" name="decode" value="'.$attachments[$pCount]['decode'].'">
							                					</form>'
							                				);
													}
												}
											}
										}
									}
								}
							}
							
						}	
							usort($results, function($a, $b) {							
								if ($a['timestamp'] == $b['timestamp']){								
									// order by ordertyp (Erstorder, Reshoot,..)
									if (strcmp($a['ordertyp'], $b['ordertyp'])>0) return 1;
								}
								// sort by desc date:	
								return strtotime($b['timestamp'])-strtotime($a['timestamp']) ;
							});
								
							$this->array["tableImportable"]["header"] = array("Dateiname","Ordertyp","Datum","Zeilen","unvollständige Zeilen","Importieren","Download");
							$this->array["tableImportable"]["content"] = $results;

					}
					
					/* close the connection */
					imap_close($inbox);
				}
				// FTP - Connect
				if($this->configarray["config_import"][0]["isFTP"]==1){
					$conn_id = ftp_connect($this->configarray["config_import"][0]["host"]);					 
					
					$login_result = ftp_login($conn_id, $this->configarray["config_import"][0]["username"], $this->configarray["config_import"][0]["password"]);
					//List all Files
					if (is_array($rawlist = @ftp_rawlist($conn_id, $this->configarray["config_import"][0]["filename"]))) {
						include_once('classes/module/class.xml.php');
						$xml = new XML();						
			            $items = array();			
			            foreach ($rawlist as $child) {
			                list($perms, $links, $user, $group, $size, $d1, $d2, $d3, $name) = preg_split('/\s+/', $child, 9);
			                // Date of File > dateSince
			                $dateFile = date("Y-m-d",strtotime(substr($name, 0,10)));
			                if($dateSince<=$dateFile){
			                	if (ftp_get($conn_id, 'csv/'.$name, $this->configarray["config_import"][0]["filename"]."/".$name, FTP_BINARY)) {			                		
				                	$xml->setPath('csv/'.$name);
				                	$arr = $xml->getArray();
				                	$arraySerialize=array();
				                	$rowcount=0;
				                	foreach($arr as $k=>$row){
				                		$rowcount++;				                		
				                		if($k!="product"){continue;}	
				                		$shotstr="";
				                		foreach($row->ordered_shots as $x=>$y){
				                			foreach($y as $shot){
				                			$shotstr .= (string)$shot->tag.": ".(string)$shot->background." #  ";
				                			}
				                		}               		
				                		$tempRow=array();
				                		$tempRow[]= (string)$row->collins_product_variant_id;
				                		$tempRow[]= (string)$row->ean;
				                		$tempRow[]= (string)$row->category;	
				                		$tempRow[]= (string)"";
				                		$tempRow[]= (string)"7";
				                		$tempRow[]= (string)$row->gender;
				                		$tempRow[]= (string)$row->season;
				                		$tempRow[]= (string)$row->photo_sample_size;
				                		$tempRow[]= date("d.m.Y", strtotime("+1Week"));
				                		$tempRow[]= $shotstr;
				                		$arraySerialize[]=$tempRow;
				                	}
									if($rowcount>1){
				                	$results[] = array(
				                		'name' => $name, 
				                		'timestamp' => $dateFile, 
				                		'rows' => $rowcount,
				                		'button'=>'<form method="POST">
				                					<input type="hidden" name="dateFile" value="'.date("d.m.Y",strtotime((string)$arr->document->date)).'">
				                					<input type="hidden" name="parseData" value="'.base64_encode(serialize($arraySerialize)).'">
				                					<input type="hidden" name="col[]" value="Artikelnummer">
						                			<input type="hidden" name="col[]" value="Scancode">
				                					<input type="hidden" name="col[]" value="WarengruppenCode">	
				                					<input type="hidden" name="col[]" value="Produkt">
				                					<input type="hidden" name="col[]" value="ProzessCode">					                								                			
						                			<input type="hidden" name="col[]" value="Geschlecht">
						                			<input type="hidden" name="col[]" value="Saison">
				                					<input type="hidden" name="col[]" value="Groesse">
													<input type="hidden" name="col[]" value="Retourdatum">
				                					<input type="hidden" name="col[]" value="Artikelinformation">
				                					
				                					<input type="submit" name="transform" value="waehlen">
				                					<input type="hidden" name="tab_lieferant" value="'.$_POST["tab_lieferant"].'">
				                					<a class="marginSide10" href="xml_dl.php?path='.$name.'" target="popUpDl">XML-Download</a>
				                					</form>');
									}
			                	}else{
			                		echo "Fehler: Kein FTP-Zugriff";
			                	}
			                }
						   
			            }
			            usort($results, function($a, $b) { 
			            	$x=strtotime($a['timestamp']);
			            	$y=strtotime($b['timestamp']);			            	
			            	return $y-$x; 
			            });		
			                
			        }			         
			        $this->array["tableImportable"]["header"] = array("Dateiname","Datum","Zeilen","Importieren");
			        $this->array["tableImportable"]["content"] = $results;
					
       				// close the connection
					ftp_close($conn_id);
				}

	    	}
			return $this->array;
		}
		
	
	function select_new_orders($since, $supplierID){
	  	$qryForTablename = $this->dbhandler->qry("SELECT tableOrderImport FROM tab_lieferant WHERE supplierID = '".$supplierID."'");
	  	$resForTablename->fetch_assoc();
	  	$tableName = $resForTablename["tableOrderImport"];
	  	if($tableName == ""){
	  		return false;
	  	}
	    $result = '';
		$qry = "SELECT tab_lieferant.name, config, ean, GROUP_CONCAT(DISTINCT wg_wg.name ORDER BY depth) AS warengruppe,  GROUP_CONCAT(DISTINCT prozess_station.short ORDER BY sort SEPARATOR '+') AS 
				prozess , IF(ext_zalando_wgmatch.gender=1,'m',IF(ext_zalando_wgmatch.gender=2,'w','u')) as gender 
				FROM ".$tableName."
				LEFT JOIN order_log ON order_import_zalando.order_number = order_log.zalando_order_name
				LEFT JOIN ext_zalando_wgmatch ON ext_zalando_wgmatch.wgPfad = order_import_zalando.warengruppe
				LEFT JOIN wg_articlegroup ON wg_articlegroup.id = ext_zalando_wgmatch.wgID
				LEFT JOIN wg_wg ON wg_wg.id = wg_articlegroup.wgID
				LEFT JOIN prozess_stationmatch ON prozess_stationmatch.prozessID = ext_zalando_wgmatch.prozessID
				LEFT JOIN prozess_station on prozess_station.id = prozess_stationmatch.stationID
				INNER JOIN tab_lieferant ON tab_lieferant.id = order_import_zalando.supplierID
				WHERE order_log.zalando_order_name IS NULL 
				AND order_date >=  '".$since."'
				AND supplierID = '".$supplierID."'
				GROUP BY order_import_zalando.id
				ORDER BY order_number
							
	        	LIMIT 500";
		$res = $this->dbhandler->qry($qry);
		while($row = $res->fetch_assoc()){
			$result[] = $row;
		}
	   
	    return $result;
	      
	}
	
	function summarize_new_orders($since,$supplierID)
	{
		$qry = "SELECT tab_lieferant.name, COUNT( * ) AS line_count, MAX( mail_date ) as mail_date , SUM( IF( warengruppe =  '', 1, 0 ) ) AS missing_wg, SUM( IF( ean =  '', 1, 0 ) ) AS missing_ean, IF( order_date > NOW( ) ,  'datum in zukunft', 'datum ok' ) AS date_ok
				FROM order_import_zalando
				LEFT JOIN order_log ON order_import_zalando.order_number = order_log.zalando_order_name
				INNER JOIN tab_lieferant ON tab_lieferant.id = order_import_zalando.supplierID
				WHERE order_log.zalando_order_name IS NULL 
				AND order_date >=  '".$since."'
				AND supplierID = '".$supplierID."'
				GROUP BY tab_lieferant.name";
		$res = $this->dbhandler->qry($qry);
		$row = $res->fetch_assoc();
		return $row;
	}
	
	function create_order_name()
    {
      $ASCII_OFFSET = 64;
      $year = date("y");
      $month_number = date("n");
      $month_as_letter = chr(intval($month_number) + $ASCII_OFFSET);
      $new_retour;
        $qry = "SELECT MAX(substr(name,7)) as max_order FROM tab_order";
        $result = $this->dbhandler->qry($qry);
        $last_retour = $result->fetch_assoc();
        $new_retour = "ZU".$year.$month_as_letter.sprintf('%05d',intval($last_retour['max_order'])+1);
      return $new_retour;
    }
    
    function show_last_import($filename)
    {
      $qry = "SELECT count(sku) as article_count, delivery_number FROM orders_temp LEFT JOIN tab_order ON kunde_auftragsnr = delivery_number WHERE tab_order.kunde_auftragsnr IS NULL AND filename LIKE '%".$filename."' GROUP BY delivery_number";
      
      $res = $this->dbhandler->qry($qry);
      $this->array["tableImported"]["header"] = array("Kunde","Auftragsnummer","Datum","Artikel","Aktion");
      $this->array["tableImported"]["content"] = array(array("R1C1","R1C2","","",'<input type="hidden" name="orderID[]" value=""><input type="submit" name="deleteImport[]" value="löschen">'),array("R2C1","R2C2","","",'<input type="hidden" name="orderID[]" value=""><input type="submit" name="deleteImport[]" value="löschen">'));
      $this->array["tableToImport"]["header"] = array("Anzahl Artikel", "Auftragsnummer", "Aktion");
      while($row = $res->fetch_assoc())
      {
        $row["button"] = '<form method=POST><input type="hidden" name="filename" value="yolo"><input type="submit" name="Import" value="importieren"></form>';
        $this->array["tableToImport"]["content"][] = $row;
      }
      return $this->array;
    }
    
	function import_zalando_order($supplierID,$since)
    {
	  #  $since is the date since when it should import orders , requires type: date
	  # ex: zalando salesorder shouldnt be imported before 01.06, so $since is 01.06
      # Insert new ordername, supplier_id, date, retour, ordertyp into tab_order
      $success = TRUE;
    
      $qry_select = "SELECT * FROM (
						SELECT supplierID, ltmin, order_number,config, IF(ean='',config,ean) as ean, delivery_order, order_date, mail_date, tab_ordertyp.id as ordertyp_id 
						FROM order_import_zalando
						LEFT JOIN order_log ON order_log.zalando_order_name = order_import_zalando.order_number
      					
           				INNER JOIN tab_ordertyp ON tab_ordertyp.name = order_type
						WHERE order_date >=  '" .$since. "'
						AND order_log.zalando_order_name IS NULL
            			AND supplierID = '".$supplierID."' 
						) AS t1
						GROUP BY order_date, ordertyp_id";
      $res1 = $this->dbhandler->qry($qry_select);
      
      if($res1 == FALSE)
      {
       
      }
      else
      {
        while($row  = $res1->fetch_assoc())
        {
          $result_select[] = $row;
        }
      if(!isset($result_select)){
      	return false;
      }
      foreach($result_select as $key => $value)
      {
        
        $this->dbhandler->autocommit(FALSE);
        $qry = "INSERT INTO tab_order (lieferantID, number, date, delivery, retour, shipping, orderTyp) SELECT '". $supplierID ."', create_order_name(), '".$value['order_date']."', DATE_ADD('".$value['order_date']."',INTERVAL 1 DAY),DATE_ADD('".$value['order_date']."',INTERVAL 5 DAY), DATE_ADD('".$value['order_date']."',INTERVAL 5 DAY),". $value['ordertyp_id'];
        $res = $this->dbhandler->qry($qry) ? null : $success = FALSE;
        $new_order_id = $this->dbhandler->insert_id;
        
       
        // insert article into database
        $insert_article = "INSERT INTO tab_article (orderID, san, scancode, gender, retour, processCode, articlegroupID,claspID,detailsID,seasonID,sizeID,staticID,surfaceID) 
        SELECT '". $new_order_id ."',config, ean, gender, retour, prozessID, wgID,claspID,detailsID,seasonID,sizeID,staticID,surfaceID
        FROM (SELECT config, ean, IF(ltmin='0000-00-00',DATE_ADD(order_date,INTERVAL 5 DAY),ltmin) as retour, 
        		ext_zalando_wgmatch.gender as gender,ext_zalando_wgmatch.wgID as wgID,ext_zalando_wgmatch.prozessID as prozessID,
        		claspID,detailsID,seasonID,sizeID,staticID,surfaceID
				FROM order_import_zalando 
				LEFT JOIN order_log ON order_log.zalando_order_name = order_import_zalando.order_number
        		LEFT JOIN ext_zalando_wgmatch ON ext_zalando_wgmatch.wgPfad = order_import_zalando.warengruppe
        		LEFT JOIN wg_produktion_default ON wg_produktion_default.articlegroupID = ext_zalando_wgmatch.wgID
        		INNER JOIN tab_ordertyp ON tab_ordertyp.name = order_type
      			WHERE order_date >= '" .$since. "' AND order_date = '". $value['order_date'] ."' AND order_log.zalando_order_name IS NULL AND tab_ordertyp.id = '". $value['ordertyp_id']."' AND supplierID = '".$supplierID."'
      	) as t1";
        $this->dbhandler->qry($insert_article)? null : $success = FALSE;
       
        // insert zalando auftragsnummern into table with corresponding zuumeo ordername
        $insert_order_log = "INSERT INTO order_log (order_id, zalando_order_name, imported_at) 
        SELECT distinct '". $new_order_id."', order_number, NOW()
        FROM order_import_zalando 
        LEFT JOIN order_log ON order_log.zalando_order_name = order_import_zalando.order_number
        INNER JOIN tab_ordertyp ON tab_ordertyp.name = order_type
        WHERE order_date >= '" .$since. "' AND order_date = '". $value['order_date'] ."' AND order_log.zalando_order_name IS NULL AND tab_ordertyp.id = '". $value['ordertyp_id']."' AND supplierID = '".$supplierID."'";
        $this->dbhandler->qry($insert_order_log)? null : $success = FALSE;
        
        $success ? $this->dbhandler->commit() : $this->dbhandler->rollback();
        
        
      }
        $this->dbhandler->autocommit(TRUE);
      }
      
    }
	
    function check_imported_data()
    {
      $qry = "SELECT 'name', mail_date, filename, 'yolo', count(*) as Anzahl FROM orders_temp GROUP BY filename";
      $res = $this->dbhandler->qry($qry);
      $this->array["tableImported"]["header"] = array("Kunde","Auftragsnummer","Datum","Artikel","Aktion");
      $this->array["tableImported"]["content"] = array(array("R1C1","R1C2","","",'<input type="hidden" name="orderID[]" value=""><input type="submit" name="deleteImport[]" value="löschen">'),array("R2C1","R2C2","","",'<input type="hidden" name="orderID[]" value=""><input type="submit" name="deleteImport[]" value="löschen">'));
      $this->array["tableToImport"]["header"] = array("Kunde","eMail vom","Anhang (Datei,Größe)","gefundene Zeilen","Fehler","Aktion");
      while($row = $res->fetch_assoc())
      {
        $filename = explode("/",$row['filename']);
        $fn = end($filename);
        $row["button"] = '<form method=POST><input type="hidden" name="filename" value="'.$fn.'"><input type="submit" name="Import" value="importieren"></form>';
        $this->array["tableToImport"]["content"][] = $row;
      }
      
      return $this->array;
    }
    
    function getProdParamFromSAN($supplierID,$sku){
    	$this->array = array();
    	
    	if($supplierID != 20 && $supplierID != 21){
    		$text = "Funktion nur für Zalando nutzbar.";
    		Site::innerPopUp('warning',$text,'popUpPersDataUpdate');
    		return false;
    	}
    	
		if(strlen($sku)<13){
			return false;
		}
		$zalDB = new mysqli("10.160.18.141", "reporting", "reporting", "contentcreationDB");
		$str = "SELECT ARTIKEL_CONFIG_SKU as san,EAN as scancode,CG_Path as wg,ERP_SAISONNR as saison,FLAG_SPORTS as sport,FLAG_PREMIUM as premium FROM stock WHERE ARTIKEL_CONFIG_SKU='".$zalDB->real_escape_string($sku)."' LIMIT 1";
		$sql = $zalDB->query($str);
		$res = $sql->fetch_assoc();			
		if($sql->num_rows>0){
			$wg = $res["wg"];
		}else{
			$ret["error"] = "Keine Daten gefunden";
			return $ret;
		}
		$this->array = $this->getProdParamFromExtWG($supplierID,$wg);
		$this->array["wgPfad"]=$wg;
    	return $this->array;
    }
    function getProdParamFromExtWG($supplierID,$extWG){
    	$this->array = array();
    	$qry = "SELECT wgTranslateTable FROM tab_lieferant WHERE id='".$this->dbhandler->real_escape_string($supplierID)."' LIMIT 1";
    	$res = $this->dbhandler->qry($qry);
    	if($res->num_rows==0){
    		$text = "Keine Tabelle vorhanden.";
    		Site::innerPopUp('warning',$text,'popUpProdParam');
    		return false;
    	}
    	$row = $res->fetch_assoc();
    	$tabName = $row["wgTranslateTable"];
    	$qryWG = "SELECT wgID,prozessID,gender FROM ".$this->dbhandler->real_escape_string($tabName)."
    			WHERE wgPfad = '".$this->dbhandler->real_escape_string($extWG)."' LIMIT 1";
    	$resWG = $this->dbhandler->qry($qryWG);
    	$this->array = $resWG->fetch_assoc();
    	return $this->array;
    }
    function getExtWGTablename($supplierID){
    	$qry = "SELECT wgTranslateTable FROM tab_lieferant WHERE id='".$this->dbhandler->real_escape_string($supplierID)."' LIMIT 1";
    	$res = $this->dbhandler->qry($qry);
    	$row = $res->fetch_assoc();
    	$tabName = $row["wgTranslateTable"];
    	if($tabName==""){
    		$text = "Keine Tabelle vorhanden.";
    		Site::innerPopUp('warning',$text,'popUpExtWG');
    		return false;
    	}
    	return $tabName;
    }
    function getOrdertypByString($ordertyp_s,$supplierID){
    	$qry = "SELECT orderTypId FROM order_translate WHERE supplierText='".$this->dbhandler->real_escape_string($ordertyp_s)."' AND supplierID='".$this->dbhandler->real_escape_string($supplierID)."' LIMIT 1";
    	$res = $this->dbhandler->qry($qry);
    	$row = $res->fetch_assoc();
    	$ordertyp = $row["orderTypId"];
    	if($ordertyp==""){
    		$text = "Keine Tabelle vorhanden. <br> {".$ordertyp_s.":".$supplierID."}";
    		Site::innerPopUp('warning',$text,'popUpOrdertypByS');
    		return false;
    	}
    	return $ordertyp;
    }
    
    function updateExtWG($supplierID,$extWG,$wgID,$prozessID,$gender){
    	$qry = "SELECT wgTranslateTable FROM tab_lieferant WHERE id='".$this->dbhandler->real_escape_string($supplierID)."' LIMIT 1";
    	$res = $this->dbhandler->qry($qry);
    	$row = $res->fetch_assoc();
    	$tabName = $row["wgTranslateTable"];
    	
    	$qryUp = "INSERT INTO ".$this->dbhandler->real_escape_string($tabName)."
    			(wgPfad,wgID,prozessID,gender)
    		VALUES
    			('".$this->dbhandler->real_escape_string($extWG)."','".$this->dbhandler->real_escape_string($wgID)."','".$this->dbhandler->real_escape_string($prozessID)."','".$this->dbhandler->real_escape_string($gender)."')
    		ON DUPLICATE KEY UPDATE
    			wgID='".$this->dbhandler->real_escape_string($wgID)."',
    			prozessID ='".$this->dbhandler->real_escape_string($prozessID)."',
    			gender='".$this->dbhandler->real_escape_string($gender)."'";
    	$resUP = $this->dbhandler->qry($qryUp);
    	$check = $this->dbhandler->affected_rows;
    	
    	if($check==1){
    		$text = "Die externe Warengruppe wurde erfolgreich angelegt.";
    		Site::innerPopUp('information_blue',$text,'popUpPersDataUpdate');
    	}else if($check==2){
    		$text = "Die externe Warengruppe wurde erfolgreich aktualisiert.";
    		Site::innerPopUp('information_blue',$text,'popUpPersDataUpdate');
    	}else{
    		$text = "Keine Änderung<br><br>Es wurden keine Daten geändert.";
    		Site::innerPopUp('warning',$text,'popUpPersDataUpdate');
    	}
    	
    }
    function getInvoiceData($supplierID){
    	$whitelist = array(24);
    	if(in_array($supplierID,$whitelist)){
    		$qry = "
    				SELECT auftrag, sum(we) as we, sum(finished) as finished,ordernr,date_format(min(we_timestamp),'%d.%m.') as minwe FROM
    				(SELECT tab_order.number as ordernr,IF(scancode LIKE 'DE%',LEFT(scancode,9),IF(san LIKE 'DE%',LEFT(san,9),'')) as auftrag,
    						IF(logistik_log.we_timestamp>0,1,0) as we,IF(produktion_log.finished>0,1,0) as finished,we_timestamp FROM tab_article     				
    				LEFT JOIN tab_order ON tab_order.id=tab_article.orderID AND tab_order.lieferantID='".$this->dbhandler->real_escape_string($supplierID)."'
    				LEFT JOIN produktion_log ON produktion_log.articleID = tab_article.id 
    				LEFT JOIN logistik_log ON logistik_log.articleID = tab_article.id 
    				WHERE tab_order.id is not null   
    				GROUP BY tab_article.id 				
    				) as t1
    				GROUP BY auftrag
    				ORDER BY min(we_timestamp) DESC
    				";
    		$res = $this->dbhandler->qry($qry);
    		WHILE($row = $res->fetch_assoc()){
    			$order[$row["auftrag"]][]=$row;
    		}
    		$ret["overview"] = $order;
    		$qry = "SELECT tab_order.number as ordernr,IF(scancode LIKE 'DE%',LEFT(scancode,9),IF(san LIKE 'DE%',LEFT(san,9),'')) as auftrag,
    						logistik_log.we_timestamp as we,produktion_log.finished as finished,san,scancode,GROUP_CONCAT(DISTINCT wg_wg.name ORDER BY depth) FROM tab_article     				
    				LEFT JOIN tab_order ON tab_order.id=tab_article.orderID AND tab_order.lieferantID='".$this->dbhandler->real_escape_string($supplierID)."'
    				LEFT JOIN produktion_log ON produktion_log.articleID = tab_article.id 
    				LEFT JOIN logistik_log ON logistik_log.articleID = tab_article.id 
    				LEFT JOIN wg_articlegroup ON wg_articlegroup.id = tab_article.articleGroupID
					LEFT JOIN wg_wg ON wg_wg.id = wg_articlegroup.wgID 
    				WHERE tab_order.id is not null   
    				GROUP BY tab_article.id 
    				";
    		$res = $this->dbhandler->qry($qry);
    		WHILE($row = $res->fetch_assoc()){
    			$details[$row["auftrag"]][]=$row;
    		}
    		$ret["details"] = $details;
    		return $ret;
    	}
    	
    }
    
}

?>