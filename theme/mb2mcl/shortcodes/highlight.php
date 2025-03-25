<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('highlight', 'mb2_shortcode_highlight');


function mb2_shortcode_highlight ($atts, $content= null){
	
	extract(mb2_shortcode_atts( array(
		'type' => 1,
		'class'=> ''		
	), $atts));
	
	
	$output = '';
	
	
	$cls = $class !='' ? ' ' . $class : '';
	$cls .= ' type-' . $type;
	
	
	
	$output .= '<span class="theme-highlight' . $cls . '">';
	$output .= mb2_do_shortcode($content);
	$output .= '</span>';
		
	
	return $output;
	
	
}