<?php

function setColumnGridError($amount_columns, $amount_grid) {
	if(isAdmin() && $amount_grid > 0 && ($amount_grid != $amount_columns)) {
		$return = '
			<div class="column_grid_error">
				Spaltenraster ('.$amount_grid.')<br>und Anzahl Spalten ('.$amount_columns.')<br>stimmen nicht &uuml;berein!
			</div>
		';
		
		return $return;
	}
}

?>