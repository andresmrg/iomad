<?php

defined('MOODLE_INTERNAL') || die();

function mb2_shortcode_alert($atts, $content= null){
	extract(mb2_shortcode_atts( array(
		'type' => 'info',
		'close' => 0,
		'margin' => '',
		'custom_class' => ''
	), $atts));

	$cls = $close ? ' alert-dismissible' : '';
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$style = $margin !='' ? ' style="margin:' . $margin . ';"' : '';

	$cbutton = $close ? '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' : '';
	return '<div class="alert mb2pb-alert alert-' . $type . $cls . '"' . $style . '>' . $cbutton . mb2_do_shortcode(format_text($content, FORMAT_HTML)) .'</div>';

}

mb2_add_shortcode('alert', 'mb2_shortcode_alert');
