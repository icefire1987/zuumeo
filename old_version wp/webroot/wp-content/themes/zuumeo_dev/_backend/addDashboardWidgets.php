<?php

class addDashboardWidgets_Handler{
	var $option;
	function addDashboardWidgets_Handler($option = array()){
		$this->option = (object)$option;
	}

	function addDashboardWidgets_1(){
		addDashboardWidget($this->option->id);
	}
	
	function addDashboardWidgets_2(){
		addDashboardWidget($this->option->id, $this->option->lang);
	}
}


// Hook into the 'wp_dashboard_setup' action to register our other functions
if(is_admin()) {
	add_action('wp_dashboard_setup', 'addDashboardWidgets' );
}

function addDashboardWidgets() {
	global $configs_dashboard;
	
	if(!empty($configs_dashboard)) {
		foreach($configs_dashboard AS $filename => $title) {
			$file = get_stylesheet_directory().'/_dashboard/'.$filename.'.php';
			
			if(file_exists($file) && current_user_can("dashboard_default_".$filename)) {
			  	include_once($file);
			  	
			  	$someoptions = (object)array('id'=>$filename);
			  	$bodyWidget = new addDashboardWidgets_Handler($someoptions);
			    		
			  	wp_add_dashboard_widget('my_widget_'.$filename, $title, array($bodyWidget, 'addDashboardWidgets_1'));
			}
		}
	}
}

?>