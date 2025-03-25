<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('title', 'mb2_shortcode_title');

function mb2_shortcode_title ($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'tag'=> 'h4',
		'align' =>'left',
		'subtext' =>'',
		'size' => 'n',
		'style' => 1,
		'margin' => '',
		'custom_class'=> ''
	), $atts));

	$output = '';

	$cls = $custom_class ? ' ' . $custom_class : '';
	$cls .= ' title-' . $align;
	$cls .= ' title-' . $size;
	$cls .= ' style-' . $style;

	// Title container style
	$cstyle = $margin !='' ? ' style="margin:' . $margin . ';"' : '';

	$output .= '<div class="theme-title' . $cls . '"' . $cstyle . '>';
	$output .= '<' . $tag . ' class="title"><span>';
	$output .= mb2_do_shortcode( theme_mb2mcl_get_highlight_text( $content ) );
	$output .= '</span></' . $tag . '>';
	$output .= $subtext ? '<span class="title-subtext">' . $subtext . '</span>' : '';
	$output .= '</div>';

	return $output;

}
