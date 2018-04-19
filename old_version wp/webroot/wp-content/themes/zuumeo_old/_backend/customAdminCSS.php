<?php

if(is_admin()) {
	add_action('admin_head', 'customAdminCSS');
}

function customAdminCSS() {
	echo '
		<style type="text/css">
			#com-agilebits-onepassword-autosave {
				display: none !important;
			}
			
			#adminmenuback, #adminmenuwrap, #adminmenu, #adminmenu .wp-submenu {
				width: 155px;
			}
			
			#adminmenu .wp-submenu {
				left: 156px;
			}
			
			.wp-menu-arrow {
				right: 145px;
			}
			
			#adminmenu .wp-submenu a {
				/* border-top: 1px solid #d0d0d0; */
				/* white-space: normal; */
				/* font-size: 12px; */
				/* line-height: 1.3em; */
			}
			
			#adminmenu .sub-open a {
				width: 240px;
			}
			
			.ws-submenu-separator-wrap,
			#adminmenu li.wp-menu-separator {
				margin: 3px 0px 3px 0px;
				padding: 0px;
				height: 1px;
				background: #f1f1f1;
				border: none;
				border-top: 1px solid #444444;
				font-size: 0px;
			}
			
			.wp-menu-separator .separator {
				display: none;
			}
			
			.postbox h3.hndle {
				background: #738e96;
				color: #ffffff;
			}
			
			.acf-popup a:link {
				padding-top:3px;
				padding-bottom:3px;
			}
			
			.acf_postbox .field textarea,
			.field-repeater textarea {
				min-height: 20px;
			}
			
			.acf_postbox .field input[type="number"] {
				padding: 2px;
				line-height: 1.0em;
			}
			
			.acf-radio-list input[type=radio] {
				float: left;
			}
			
			.wp-core-ui .button_small_individole {
				padding: 3px 6px 4px 6px;
				line-height: 1.0em;
				height: auto;
			}
			
			.widefat td, 
			.widefat th {
				padding: 4px 10px;
			}
			
			.mceIframeContainer {
				padding:0px;
			}
			
			.acf-input-table {
				width: 100%;
			}
			
			.acf-input-table .repeater .acf-input-table .repeater .acf-input-table {
				padding: 4px 0px 4px 0px;
			}
			
			.acf-input-table.row_layout .repeater td {
				border-bottom: 1px solid #e1e1e1;
			}
			
			.acf-input-table .repeater .acf-input-table .repeater td {
				padding: 3px 10px 3px 10px;
			}
			
			.acf-input-table sup {
				line-height:0.0em;
			}
			
			.acf_flexible_content .acf-input-table {
				//display: none;
			}
			
			.acf-image-uploader img {
				width: auto;
				max-width: 100%;
				max-height: 80px;
			}
			
			.acf-gallery .thumbnails {
				min-height: 100px;
			}
			
			.attachment-info a.delete-attachment:link,
			.attachment-info a.delete-attachment:visited,
			.attachment-info a.delete-attachment:hover {
				color: #ffffff;
			}
			
			.delete-attachment {
				display: block;
				border-radius: 3px;
				border: #21759B solid 1px;
				border-color: #21759B #21759B #1E6A8D;
				background: #21759B;
				background-image: -webkit-gradient(linear, left top, left bottom, from(#2A95C5), to(#21759B));
				background-image: -webkit-linear-gradient(top, #2A95C5, #21759B);
				background-image: -moz-linear-gradient(top, #2A95C5, #21759B);
				background-image: -o-linear-gradient(top, #2A95C5, #21759B);
				background-image: linear-gradient(to bottom, #2A95C5, #21759B);
				color: #FFFFFF;
				font-weight: normal;
				text-shadow: 0 1px 0 rgba(0,0,0,0.5);
				font-size: 13px;
				line-height: 1em;
				padding: 6px 11px;
				box-shadow: 0 1px 3px rgba(0,0,0,0.2), 0 1px 0 rgba(120, 200, 230, 0.5) inset;
				cursor: pointer;
				position: relative;
				text-align: center;
				text-decoration: none;

			}
			
			table.acf_input tbody tr td.label,
			table.acf-input-table tbody tr td.label {
				width:auto;
				max-width: 100px;
			}
			
			.acf-input-table .checkbox_list {
				max-height: 300px;
				overflow-y:auto;
			}
			
			.acf-input-table .checkbox_list li {
				margin-bottom: 1px;
			}
			
			.acf-input-table .checkbox_list label {
				white-space:nowrap;
			}
			
			.acf_flexible_content table.widefat > tbody > tr > td {
				padding: 8px 10px;
			}
			
			.acf-gallery .thumbnail {
				margin: 5px;
				max-height: 90px;
			}
			
			.acf-gallery .thumbnail img {
				max-height: 80px;
			}

			.wp-submenu, 
			#adminmenu .wp-submenu-wrap, 
			.folded #adminmenu .wp-has-current-submenu .wp-submenu {
				width: auto !important;
			}
			
			#adminmenu .wp-submenu a,
			.wp-submenu a {
				white-space: nowrap;
			}
			
			.ws-submenu-separator-wrap a {
				display: none;
			}

			#pageparentdiv #parent_id,
			#pageparentdiv #page_template {
				width: 100% !important;
			}
			
			
			.column-id,
			.column-var { 
				color: #bbbbbb !important;
			}
			
			ul.admin_tablecolumn_repeater {
				list-style-position:outside;
				list-style-type: disc;
				margin: 0px 0px 0px 14px;
				padding: 0px;
				
				/* background: red; */
			}
			
			ul.admin_tablecolumn_repeater li {
				padding: 0px;
				margin: 0px 0px 2px 0px;
			}
			
			.column-language,
			.column-language_de,
			.column-language_ru,
			.column-language_en,
			.column-language_cn,
			.column-language_es { 
				width:10px !important;
			}
			
			#tooltip {
				position: absolute;
				top: 100px;
				left: 100px;
				padding: 3px;
				z-index: 999999999999999;
				
				-webkit-box-shadow: 0px 0px 5px #777777;
				-moz-box-shadow: 0px 0px 5px #777777;
				box-shadow: 0px 0px 5px #777777;
				
				background: #ffffff;
			}
			
			.tooltip_text {
				padding: 7px 10px 7px 10px;
				word-break: break-word;
			}
			
			/*
			#adminmenuback, #adminmenuwrap, #adminmenu, #adminmenu .wp-submenu, #adminmenu .wp-submenu-wrap, .folded #adminmenu .wp-has-current-submenu .wp-submenu {
				width: 200px;
			}
			
			#wpcontent, #footer {
				margin-left: 220px;
			}
			*/
			
			.sortable_table .drag { 
			    cursor:pointer; 
			    padding-left:25px;
			    background: transparent url('.get_stylesheet_directory_uri().'/_backend/_images/drag.gif) 10px 8px no-repeat;
			}
			
			.sortable_table td.drag:hover { 
			    background-color: #6dcca7;
			}
			
			.sortable_table a {
			    text-decoration: none;
			}
			
			.clearer { clear: both; }
		</style>
	';
}

?>