<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('cpanel', 'mb2_shortcode_cpanel');


function mb2_shortcode_cpanel ($atts, $content = null){
	extract(mb2_shortcode_atts( array(
		'image' =>'',
		'title' => '',
		'link' =>'',
		'linktext' => 'Read more',
		'link_target' =>'',
		'margin' => '',
		'imagepos'=> 'right',
		'fw' => 0,
		'custom_class' => ''
	), $atts));

	$output = '';

	$style = ' style="';
	$style .= $margin ? 'margin:' . $margin . ';' : '';
	$style .= '"';

	$cls = $fw ? ' fw' : '';
	$cls .= ' imgpos-'. $imagepos;
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$output .= '<div class="theme-cpanel' . $cls . '"' . $style . '>';
	$output .= $fw ? '<div class="container-fluid">' : '';
	$output .= $fw ? '<div class="row">' : '';
	$output .= $fw ? '<div class="col-md-12">' : '';
	$output .= '<div class="inner">';
	$output .= $title ? '<h3 class="title">' . $title . '</h3>' : '';
	$output .= mb2_do_shortcode($content);
	$output .= $link ? '<p class="readmore"><a class="btn btn-primary" href="' . $link . '">' . $linktext . '</a></p>' : '';
	$output .= '</div>';
	$output .= $fw ? '</div>' : '';
	$output .= $fw ? '</div>' : '';
	$output .= $fw ? '</div>' : '';
	$output .= '<div class="bg"></div>';
	$output .= $image ? '<div class="bg-img" style="background-image:url(\'' . $image . '\');"></div>' : '';
	$output .= '</div>';

	return $output;

}
