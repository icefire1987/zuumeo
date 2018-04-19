<?php

//add_action('quick_edit_custom_box', 'addQuickeditBox');
// Outputs the new custom Quick Edit field HTML
function addQuickeditBox($column_name) {
	foreach($GLOBALS['custom_fields'] AS $field_key => $field_values) {
		if($column_name == $field_key) {
			echo '
				<fieldset class="inline-edit-col-left" style="clear: both; padding-top: 3px;">
					 <div class="inline-edit-col">
						'.$field_values['start'].'
						<label>
							<span class="title">'.$field_values['title'].'</span>
							<span class="input-text-wrap"><input type="text" name="'.$field_key.'" /></span>
						</label>
					</div>
				</fieldset>
			';
			
			++$i;
		}
	}
}

?>