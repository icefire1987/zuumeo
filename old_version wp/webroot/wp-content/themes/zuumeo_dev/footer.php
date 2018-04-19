<?php

ob_start();
wp_footer();
$wp_footer = ob_get_contents();
ob_end_clean(); 

$footer_menu_1 = createMenus(array(
	'menu' 			=> '02_Footer_1', 
	'levels' 		=> 3,
	'all_levels'	=> true,
));

$footer_menu_2 = createMenus(array(
	'menu' 			=> '02_Footer_2', 
	'levels' 		=> 3, 
	'all_levels'	=> true,
	'debug'			=> true,
));

$footer_menu_3 = createMenus(array(
	'menu' 			=> '02_Footer_3', 
	'levels' 		=> 3,
	'all_levels'	=> true,
));

$final_footer_menu_1 = '';
$final_footer_menu_2 = '';
$final_footer_menu_3 = '';

if($footer_menu_1 != "") {
	$final_footer_menu_1 = '
		<div class="left col_footer col_2 col_gap">
			'.$footer_menu_1.'
		</div>
	';
}

if($footer_menu_2 != "") {
	$final_footer_menu_2 = '
		<div class="left col_footer col_2 col_gap">
			'.$footer_menu_2.'
		</div>
	';
}

if($footer_menu_3 != "") {
	$final_footer_menu_3 = '
		<div class="left col_footer col_2 col_gap">
			'.$footer_menu_3.'
		</div>
	';
}

$footer = '
			</div>
		</div>
	</div>
	<div id="footer_container">
		<div id="footer">
			<div id="footer_inner">
		    	<div class="content_inner">
		    		'.$final_footer_menu_1.'
		    		'.$final_footer_menu_2.'
		    		'.$final_footer_menu_3.'
		    		<div class="right col_footer col_2">
		    			'.getOptionText("footer_text_right_2").'
		    		</div>
		    		<div class="right col_footer col_2 col_gap">
		    			'.getOptionText("footer_text_right_1").'
		    		</div>
		    		'.clearer().'
		    	</div>
		    </div>
		</div>
	</div>
	'.clearer().'
	<div class="footer_2 col_12"><img src="'.get_stylesheet_directory_uri().'/_images/logo-footer.gif" /></div>
	'.setGoogleAnalytics().'
	'.createAdminOptions().'
	'.$wp_footer.'
</body>
</html>
';

echo $footer;

//(isSuperAdmin()) ? phpinfo() : "";

?>