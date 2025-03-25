<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('header', 'mb2_shortcode_header');


function mb2_shortcode_header ($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'title'=> '',
		'subtitle' => '',
		'margin' => '',
		'image' => '',
		'type' => 1,
		'custom_class'=> ''
	), $atts));


	$output = '';


	$cls = $custom_class ? ' ' . $custom_class : '';
	$cls .= ' type-' . $type;


	$marginStyle = $margin !='' ? ' style="margin:' . $margin . ';"' : '';
	$bgStyle = $image !='' ? ' style="background-image:url(\'' . $image . '\');"' : '';


	$output .= '<div class="theme-header-wrap"' . $marginStyle . '>';
	$output .= '<div class="theme-header' . $cls . '"' . $bgStyle . '>';
	$output .= '<div class="theme-header-content">';
	$output .= $title !='' ? '<h3 class="theme-header-title">' . format_text($title, FORMAT_HTML) . '</h3>' : '';
	$output .= $subtitle !='' ? '<div><div class="theme-header-subtitle">' . format_text($subtitle, FORMAT_HTML) . '</div></div>' : '';
	$output .= '</div>';
	$output .= '<div class="theme-header-bg"></div>';
	$output .= '</div>';
	$output .= '</div>';


	return $output;


}
