<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('text', 'mb2_shortcode_text');


function mb2_shortcode_text ($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'align' =>'',
		'size' => 'n',
		'color' => '',
		'title' => '',
		'margin' => '',
		'custom_class'=> ''
	), $atts));

	$output = '';

	$cls = $custom_class ? ' ' . $custom_class : '';
	$cls .= ' text-' . $align;
	$cls .= ' text-' . $size;
	$cls .= ' text-' . $color;

	// Text container style
	$cstyle = $margin !='' ? ' style="margin:' . $margin . ';"' : '';

	$output .= '<div class="theme-text' . $cls . '"' . $cstyle . '>';
	$output .= $title ? '<h4>' . $title . '</h4>' : '';
	$output .= mb2_do_shortcode($content);
	$output .= '</div>';


	return $output;


}


mb2_add_shortcode('loggedin', 'mb2_shortcode_loggedin');

function mb2_shortcode_loggedin ($atts, $content= null){

	extract(mb2_shortcode_atts( array(), $atts));

	 if (isloggedin() && !isguestuser())
	 {
		 return mb2_do_shortcode($content);
	 }
}




mb2_add_shortcode('notloggedin', 'mb2_shortcode_notloggedin');

function mb2_shortcode_notloggedin ($atts, $content= null){

	extract(mb2_shortcode_atts( array(), $atts));

	 if (!isloggedin() || isguestuser())
	 {
		 return mb2_do_shortcode($content);
	 }

}
