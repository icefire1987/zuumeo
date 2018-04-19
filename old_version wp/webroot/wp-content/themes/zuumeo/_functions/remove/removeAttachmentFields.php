<?php

function removeAttachmentFields($fields) {
	unset($fields['post_content']);
	unset($fields['image_alt']);
	unset($fields['post_excerpt']); // See wp-admin\includes\media.php line 1071
	
	return $fields;
}
add_filter('attachment_fields_to_edit','removeAttachmentFields');

?>