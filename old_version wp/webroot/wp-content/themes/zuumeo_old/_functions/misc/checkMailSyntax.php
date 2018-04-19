<?php

function checkMailSyntax ($mail) {
	return preg_match("/^[a-z][a-z0-9_.-]+@[a-z0-9][a-z0-9-]+\.[a-z]+(\.[a-z]+)*$/i", $mail);
}

?>