<?php

function removeSpaceBug($str) {
	return str_replace("\xC2\xA0", " ", $str);
}

?>