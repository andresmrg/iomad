<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('h', 'mb2_shortcode_h');

function mb2_shortcode_h ($atts, $content= null){
	
	extract(mb2_shortcode_atts( array(
		'size'=> '4',
		'margin' => ''
	), $atts));
	

	$style = $margin !='' ? ' style="margin:' . $margin . ';"' : '';	
	return '<h' . $size . $style . '>' . mb2_do_shortcode($content) . '</h' . $size . '>';
	
}