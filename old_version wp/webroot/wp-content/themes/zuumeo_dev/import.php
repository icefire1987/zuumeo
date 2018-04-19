<?php



/*
$xml = simplexml_load_file(get_stylesheet_directory_uri().'/xml_veranstaltungen.xml');

//$parsed_xml = xml2array($xml);

//debug($parsed_xml['termine']);

foreach ($xml->eintrag AS $eintrag) {
	$datum = (string)$eintrag->attributes()->datum;
	$titel = (string)$eintrag->attributes()->titel;
	$links = (string)$eintrag->attributes()->links;
	$bild = (string)$eintrag->attributes()->bild;
	$text = (string)$eintrag;
	
	$datum_array = explode(".", $datum);
	
	$year = $datum_array[2];
	($datum_array[1] < 10) ? $month = "0".$datum_array[1] : $month = $datum_array[1];
	($datum_array[0] < 10) ? $day = "0".$datum_array[0] : $day = $datum_array[0];
	
	
	$datum_final = $year.'-'.$month.'-'.$day;
	
	
	
	$post = array(
	  'comment_status' 	=> 'closed', // 'closed' means no comments.
	  'ping_status' 		=> 'open', // 'closed' means pingbacks or trackbacks turned off
	  'post_author' 		=> 1, //The user ID number of the author.
	  'post_content' 		=> $text, //The full text of the post.
	  'post_date' 			=> '2012-02-08 15:30:45', //[ Y-m-d H:i:s ] //The time post was made.
	  'post_date_gmt' 	=> '2012-02-08 15:30:45', //[ Y-m-d H:i:s ] //The time post was made, in GMT.
	  'post_name' 			=> $titel, // The name (slug) for your post
	  'post_status' 		=> 'publish', //[ 'draft' | 'publish' | 'pending'| 'future' | 'private' ] //Set the status of the new post. 
	  'post_title' 		=> $titel, //[ <the title> ] //The title of your post.
	  'post_type' 			=> 'veranstaltungen', //[ 'post' | 'page' | 'link' | 'nav_menu_item' | custom post type ] //You may want to insert a regular post, page, link, a menu item or some custom post type
	  //'ID' => [ <post id> ] //Are you updating an existing post?
	  //'menu_order' => [ <order> ] //If new post is a page, sets the order should it appear in the tabs.
	  //'post_excerpt' => [ <an excerpt> ] //For all your post excerpt needs.
	  //'pinged' => [ ? ] //?
	  //'post_category' => [ array(<category id>, <...>) ] //Add some categories.
	  //'post_parent' => [ <post ID> ] //Sets the parent of the new post.
	  //'post_password' => [ ? ] //password for post?
	  //'tags_input' => [ '<tag>, <tag>, <...>' ] //For tags.
	  //'to_ping' => [ ? ] //?
	  //'tax_input' => [ array( 'taxonomy_name' => array( 'term', 'term2', 'term3' ) ) ] // support for custom taxonomies. 
	);
	$the_post_id = wp_insert_post($post);
	add_post_meta($the_post_id, 'datum', $datum_final, true);
	add_post_meta($the_post_id, 'bild', $bild, true);
	add_post_meta($the_post_id, 'link', $links, true);
	
	
	$q = '
		SELECT '.$wpdb->posts.'.ID 
		FROM '.$wpdb->posts.' 
		WHERE '.$wpdb->posts.'.guid LIKE "%'.$bild.'"
	';
	
	echo $q;
	$result = mysql_query($q);
	
	if($result) {
		$bild_id = mysql_result($result, 0, 'ID');
		add_post_meta($the_post_id, 'image', $bild_id, true);
	}
	
	echo '
		<p>datum: '.$datum.' -> '.$datum_final.'
		<br>titel: '.$titel.'
		<br>links: '.$links.'
		<br>bild: '.$bild.'
		<br>bild_id: '.$bild_id.'
		<br>text: '.$text.'
		<hr>
	';
}
*/


?>