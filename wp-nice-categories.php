<?php
/*
Plugin Name: Nice Categories
Plugin URI: http://txfx.net/code/wordpress/nice-categories/
Description: Displays the categories conversationally, like: <em>Category1, Category2 and Category3</em>
Version: 1.5.4
Author: Mark Jaquith
Author URI: http://txfx.net/
*/

function the_nice_category_filter($content) {
	global $nice_category_sep;

/* SETTINGS */
/* ------------------------------------------ */

$normalSeparator = ', ';
$penultimateSeparator = ' and ';

/* ------------------------------------------ */
/* END SETTINGS */

	
	if ( !isset($nice_category_sep) ) {
		preg_match('/<\/a>(.*?)<a /i', $content, $matches);
		if ($matches[1]) $nice_category_sep = '</a>' . $matches[1];
else return $content;
	}
	
	$categories = explode($nice_category_sep, $content);

	if(empty($categories))
		return _e('Uncategorized');
		
	$theList = '';
	$theLast = '';
	
	// push the last element of the array, then implode the others
	// with $normalSeparator and append the last element with
	// $penultimateSeparator
	$theLast = array_pop($categories);
	
	if (count($categories)) {
		$theList  = implode('</a>' . $normalSeparator, $categories);
		$theList .= '</a>' . $penultimateSeparator . $theLast;
	} else {
		$theList = $theLast;
	}

	// return the list
	return $theList;
}

add_filter('the_category', 'the_nice_category_filter');
?>