<?php

function remove_wbr($content) {
	$result = str_replace("<wbr>", "", trim($content));
	return $result;
}

?>