<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('gap', 'mb2_shortcode_gap');


function mb2_shortcode_gap ($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'smallscreen' => '1',
		'size' => '20'
	), $atts));

	$cls = $smallscreen == 0 ? ' no-smallscreen' : '';
	$style = $size !='' ? ' style="height:' . $size . 'px;"' : '';

	return '<div class="mb2pb-gap gap clearfix' . $cls . '"' . $style . '></div>';

}
