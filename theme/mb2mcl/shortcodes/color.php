<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('color', 'mb2_shortcode_color');


function mb2_shortcode_color ($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'color' => 'default',
		'class'=> ''
	), $atts));


	$output = '';


	$cls = $class !='' ? ' ' . $class : '';


	$output .= '<span class="theme-color color-' . $color . $cls .  '">';
	$output .= mb2_do_shortcode($content);	
	$output .= '</span>';


	return $output;


}
