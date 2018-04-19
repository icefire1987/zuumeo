<?php

function addCacheID($id) {
	$q_insert = '
    INSERT IGNORE INTO
        `'.TABLE_PREFIX.'individole_caches`
    (`post_id`)
    VALUES
    ('.$id.')
    ';
    
    mysql_query($q_insert);
}