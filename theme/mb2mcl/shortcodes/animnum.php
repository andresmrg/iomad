<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('animnum', 'mb2_shortcode_animnum');


function mb2_shortcode_animnum ($atts, $content= null){
	extract(mb2_shortcode_atts( array(
		'columns' =>'1', // max 5
		'margin' => '',
		'gutter' => 'normal',
		'size_number' => 3,
		'size_icon' => 3,
		'color_icon' => '',
		'color_number' => '',
		'color_title' => '',
		'color_subtitle' => '',
		'custom_class' => ''
	), $atts));


	$output = '';
	$cls = '';
	$GLOBALS['size_number'] = $size_number;
	$GLOBALS['size_icon'] = $size_icon;
	$GLOBALS['color_icon'] = $color_icon;
	$GLOBALS['color_number'] = $color_number;
	$GLOBALS['color_title'] = $color_title;
	$GLOBALS['color_subtitle'] = $color_subtitle;

	$cls = $custom_class ? ' ' . $custom_class : '';

	$output .= '<div class="theme-boxes theme-col-' . $columns . $cls . ' clearfix" data-aspeed="10000">';

	$output .= mb2_do_shortcode($content);

	$output .= '</div>';

	return $output;

}





mb2_add_shortcode('animnum_item', 'mb2_shortcode_animnum_item');


function mb2_shortcode_animnum_item ($atts, $content = null){
	extract(mb2_shortcode_atts( array(
		'number' => 0,
		'icon' => '',
		'title' => '',
		'color_icon' => '',
		'color_number' => '',
		'color_title' => '',
		'color_subtitle' => '',
		'subtitle' => '',
	), $atts));

	$output = '';
	$con_pref = theme_mb2mcl_font_icon_prefix($icon);
	$size_number = isset($GLOBALS['size_number']) ? $GLOBALS['size_number'] : 3;
	$size_icon = isset($GLOBALS['size_icon']) ? $GLOBALS['size_icon'] : 3;
	$color_icon_style = '';
	$color_number_style = '';
	$color_title_style = '';
	$color_subtitle_style = '';

	if ($color_icon || $GLOBALS['color_icon'])
	{
		$color = $color_icon ? $color_icon : $GLOBALS['color_icon'];
		$color_icon_style = 'color:' . $color . ';';
	}

	if ($color_number || $GLOBALS['color_number'])
	{
		$color = $color_number ? $color_number : $GLOBALS['color_number'];
		$color_number_style = 'color:' . $color . ';';
	}

	if ($color_title || $GLOBALS['color_title'])
	{
		$color = $color_title ? $color_title : $GLOBALS['color_title'];
		$color_title_style = ' style="color:' . $color . ';"';
	}

	if ($color_subtitle || $GLOBALS['color_subtitle'])
	{
		$color = $color_subtitle ? $color_subtitle : $GLOBALS['color_subtitle'];
		$color_subtitle_style = ' style="color:' . $color . ';"';
	}


	$output .= '<div class="theme-box">';
	$output .= '<div class="pbanimnum-item">';

	$output .= $icon ? '<div class="pbanimnum-icon" style="font-size:' . $size_icon. 'rem;' . $color_icon_style
	. '"><i class="' . $con_pref . $icon . '"></i></div>' : '';
	$output .= '<span class="pbanimnum-number" data-num="' . $number . '" style="font-size:' . $size_number . 'rem;' . $color_number_style . '">0</span>';

	$output .= '<div class="pbanimnum-text">';
	$output .= $title ? '<h4 class="pbanimnum-title"' . $color_title_style . '>' . $title . '</h4>' : '';
	$output .= $subtitle ? '<span class="pbanimnum-subtitle"' . $color_subtitle_style . '>' . $subtitle . '</span>' : '';
	$output .= '</div>';

	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
