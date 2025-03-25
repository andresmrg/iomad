<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('image', 'mb2_image');

function mb2_image( $atts, $content) {

    extract(mb2_shortcode_atts( array(
        'align' => '',
		'width' => '',
        'alt' => '',
		'margin' => '',
		'link' => '',
		'link_target' => '',
        'custom_class' => ''
   	), $atts));


	$output = '';


	$cls = 'mb2-image';
	$cls .= ' align-' . $align;
    $cls .= $custom_class ? ' ' . $custom_class : '';

	$isMargin = $margin !='' ? 'margin:' . $margin . ';' : '';

	$style = ' style="';
	$style .= $width !='' ? 'width:' . $width . 'px;max-width:100%;' : '';
	$style .= $align !== 'center' ? $isMargin : '';
	$style .= '"';

	$isLinkTarget = $link_target ? ' target="' . $link_target . '"' : '';

	$output .= $align === 'center' ? '<div style="text-align:center;' . $isMargin . '">' : '';
	$output .= $link != '' ? '<a href="' . $link . '"' . $isLinkTarget . '>' : '';
	$output .= '<img class="' . $cls . '"src="' . $content . '" alt="' . $alt . '"' . $style . ' >';
	$output .= $link != '' ? '</a>' : '';
	$output .= $align === 'center' ? '</div>' : '';

	return $output;

}
