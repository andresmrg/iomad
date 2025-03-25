<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('pbcolumn', 'mb2_shortcode_pbcolumn');

function mb2_shortcode_pbcolumn ($atts, $content= null)
{
	extract(mb2_shortcode_atts( array(
		'col' => 12,
		'custom_class' => ''
	), $atts));

	$output = '';
	$cls = !$content ? ' empty' : ' noempty';
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$output .= '<div class="mb2-pb-fpcol col-md-' . $col . $cls . '">';
	$output .= '<div class="column-inner">';
	$output .= !$content ? '&nbsp;' : mb2_do_shortcode($content);
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
