<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('heading', 'mb2_shortcode_heading');


function mb2_shortcode_heading ($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'tag'=> 'h4',
		'align' =>'left',
		'margin' => '',
		'color' => '',
		'custom_class'=> ''
	), $atts));


	$output = '';


	$cls = $custom_class ? ' ' . $custom_class : '';
	$cls .= ' heading-' . $align;

	// Title container style
	$cstyle = $margin ? ' style="margin:' . $margin . ';"' : '';

	// Title style
	$style = ' style="';
	$style .= $color !='' ? 'color:' . $color . ';' : '';
	$style .= $margin !='' ? 'margin:' . $margin . ';' : '';
	$style .= '"';

	$output .= '<' . $tag . $style . ' class="heading' . $cls . '">';
	$output .= mb2_do_shortcode($content);
	$output .= '</' . $tag . '>';

	return $output;


}
