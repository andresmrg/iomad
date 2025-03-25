<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('line', 'mb2_shortcode_line');


function mb2_shortcode_line ($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'color' =>'',
		'custom_color'=>'',
		'size'=>1,
		'double' => 0,
		'style'=>'solid',
		'margin'=> '',
		'custom_class' => ''
	), $atts));


	$height = $double == 1 ? round(5*$size) : 1;

	$border_style = ' style="';
	$border_style .= $custom_color != '' ? 'border-bottom-color:' . $custom_color  . ';' : '';
	$border_style .= 'border-bottom-style:' . $style . ';';
	$border_style .= 'border-bottom-width:' . $size  . 'px;';
	$border_style .= $margin !='' ? 'margin:' .  $margin . ';' : '';
	$border_style .= 'height:' .  $height . 'px;';



	if ($double == 1 )
	{
		$border_style .= $custom_color != '' ? 'border-top-color:' . $custom_color  . ';' : '';
		$border_style .= 'border-top-style:' . $style . ';';
		$border_style .= 'border-top-width:' . $size  . 'px;';
	}

	$border_style .= '"';

	$cls = $color ? ' ' . $color : '';
	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= $double == 1 ? ' double' : '';

	return '<div class="border-hor' . $cls . '"' . $border_style . '></div>';

}
