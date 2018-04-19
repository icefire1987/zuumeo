<?php

if(isset($_POST['data_edit_meta'])) {	
	$basepath = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
	include_once($basepath."/wp-config.php");
	
	
	if(is_user_logged_in()) {
		global $individole;
		
		$post_id = $_POST['post_id'];
		
		$seo = get_field(getIndividoleOption("praefix_seo"), $post_id);
		$seo = $seo[0];
		
		$current_meta_title 		= trim($seo['meta_title']);
		$current_meta_description 	= trim($seo['meta_description']);
		$current_meta_keywords 		= trim($seo['meta_keywords']);
		$current_sitemap 			= trim($seo['sitemap']);
		$current_changefreq			= trim($seo['changefreq']);
		$current_noindex			= trim($seo['noindex']);
		
		
		$options_sitemap = array();
		foreach($individole['choices_sitemap'] AS $option_value => $option_output) {
		   	$selected = '';
		   	if($current_sitemap == $option_value) {
		    	$selected = 'selected';
		   	}
		   	$options_sitemap[] = '<option value="'.$option_value.'" '.$selected.'>'.$option_output.'</option>';
		}
		
		
		$options_changefreq = array();
		foreach($individole['choices_changefreq'] AS $option_value => $option_output) {
		   	$selected = '';
		   	if($current_changefreq == $option_value) {
		    	$selected = 'selected';
		   	}
		   	$options_changefreq[] = '<option value="'.$option_value.'" '.$selected.'>'.$option_output.'</option>';
		}		
		
		
		$checked_noindex = '';
		if($current_noindex == 1) {
			$checked_noindex = 'checked';
		}
		
		$show_save_post_id = '';
		if(isSuperAdmin()) {
			$show_save_post_id = ' &raquo; '.$post_id;
		}
				    	
		$input = '
			<div class="editor_title">Meta-Tags bearbeiten (POST-ID: '.$post_id.')</div>
			<div class="editor_content">
				<table cellpadding="0" cellspacing="0" style="width:100%;">
					<tr>
						<td class="editor_content_title" nowrap>Titel</td>
						<td class="editor_content_data">
							<input type="text" id="data_edit_meta_title" value="'.$current_meta_title.'" class="box data_edit data_edit_meta">
							'.clearer(8).'
							<div><b>MOMENTAN:</b> '.getMetaTitle(array('page_id' => $post_id)).'<div class="editor_table_data_help_info" style="margin-top:5px;">INFO: Seitentitel bzw. Eingabe + <a href="/wp-admin/admin.php?page=acf-options-wrterstze" target="_blank"><u>Standardtitel</u></a></div>
						</td>
					</tr>
					
					<tr>
						<td class="editor_content_title" nowrap>Beschreibung</td>
						<td class="editor_content_data">
							<textarea id="data_edit_meta_description" class="box data_edit data_edit_textarea">'.$current_meta_description.'</textarea>
							'.clearer(8).'
							<div><b>MOMENTAN:</b> '.getMetaDescription(array('page_id' => $post_id)).'<div class="editor_table_data_help_info" style="margin-top:5px;">INFO: Eingabe ersetzt <a href="/wp-admin/admin.php?page=acf-options-wrterstze" target="_blank"><u>Standardbeschreibung</u></a></div>
						</td>
					</tr>
					
					<tr>
						<td class="editor_content_title" nowrap>Keywords</td>
						<td class="editor_content_data">
							<input type="text" id="data_edit_meta_keywords" value="'.$current_meta_keywords.'" class="box data_edit data_edit_meta">
							'.clearer(8).'
							<div><b>MOMENTAN:</b> '.getMetaKeywords(array('page_id' => $post_id)).'<div class="editor_table_data_help_info" style="margin-top:5px;">INFO: Eingabe + <a href="/wp-admin/admin.php?page=acf-options-wrterstze" target="_blank"><u>Standardkeywords</u></a></div>
						</td>
					</tr>
					
					<tr>
						<td class="editor_content_title" nowrap>Sitemap-Prio</td>
						<td class="editor_content_data"><select id="data_edit_sitemap" class="data_edit_select">'.implode("", $options_sitemap).'</select></td>
					</tr>
					
					<tr>
						<td class="editor_content_title" nowrap>Aktualisierung</td>
						<td class="editor_content_data"><select id="data_edit_changefreq" class="data_edit_select">'.implode("", $options_changefreq).'</select></td>
					</tr>
					
					<tr>
						<td class="editor_content_title" nowrap><font color="#ff0000">Seite gar nicht<br>indexieren</font></td>
						<td class="editor_content_data">
							<input type="checkbox" id="data_edit_noindex" class="data_edit_checkbox" '.$checked_noindex.'>
							'.clearer(8).'
							<div><b>ACHTUNG:</b> Die Seite weist Suchmaschinenbots ab - nur anwenden, wenn die Seite tatsächlich nicht in den (Google)Index aufgenommen werden soll.</div>
						</td>
					</tr>
				</table>
			</div>
			
			<div id="ind_fp_editor_footer">
				<div id="ind_fp_editor_footer_inner">
			    	<div class="left acf-button acf-button-draft" onclick="data_edit_close(0); return false;">Abbruch</div>
			    	<div class="right acf-button acf-button-publish" onclick="data_edit_save_meta('.$post_id.'); return false;">Speichern'.$show_save_post_id.'</div>
			    	'.clearer().'
			    </div>
			</div>
		';
		
		
		//!return to javascript
		echo $input.'|||';
	}
}

?>