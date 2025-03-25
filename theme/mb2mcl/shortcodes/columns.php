<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('columns', 'mb2_shortcode_columns');


function mb2_shortcode_columns ($atts, $content= null){
	
	extract(mb2_shortcode_atts( array(), $atts));
	
	
	$output = '';	
	
	$output .= '<div class="row theme-cols">';
	
	$output .= mb2_do_shortcode($content);
		
	$output .= '</div>';	
	
	
	return $output;
	
}




mb2_add_shortcode('column', 'mb2_shortcode_column');


function mb2_shortcode_column ($atts, $content= null){
	
	extract(mb2_shortcode_atts( array(	
		'size' => '4',
		'class' => ''		
	), $atts));
	
	
	$isClass = $class !='' ? ' ' . $class : '';
		
			
	$output = '';	
	
	$output .= '<div class="col-md-' . $size . $isClass . '">';
	
	$output .= mb2_do_shortcode($content);
		
	$output .= '</div>';	
	
	
	return $output;
	
}