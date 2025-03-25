<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('boxes', 'mb2_shortcode_boxes');
mb2_add_shortcode('boxesicon', 'mb2_shortcode_boxes');
mb2_add_shortcode('boxesimg', 'mb2_shortcode_boxes');
mb2_add_shortcode('boxescontent', 'mb2_shortcode_boxes');


function mb2_shortcode_boxes ($atts, $content= null){
	extract(mb2_shortcode_atts( array(
		'columns' =>'1', // max 5
		'size' => '',
		'margin' => '',
		'type' => 1,
		'height' => '',
		'gutter' => 'normal',
		'custom_class' => ''
	), $atts));

	$output = '';

	$GLOBALS['box_type'] = $type;
	$GLOBALS['box_height'] = $height;

	$cls = $size === 'small' ? ' boxes-small' : '';
	$cls .= ' gutter-' . $gutter;
	$cls .= $custom_class ? ' ' . $custom_class : '';

	$style = $margin !='' ? ' style="padding:' . $margin . ';"' : '';

	$output .= '<div class="theme-boxes theme-col-' . $columns . $cls . ' clearfix"' . $style . '>';

	$output .= mb2_do_shortcode($content);

	$output .= '</div>';

	return $output;

}





mb2_add_shortcode('boximg', 'mb2_shortcode_boximg');


function mb2_shortcode_boximg ($atts, $content = null){
	extract(mb2_shortcode_atts( array(
		'image' =>'',
		'link' =>'',
		'type' => '',
		'text2' => '',
		'link_target' =>'',
		'color' =>''
	), $atts));

	$output = '';
	$cls = '';
	$style_3 = '';
	$after_title = '';

	if ($type == '' && isset($GLOBALS['box_type']))
	{
		$type = $GLOBALS['box_type'];
	}

	if ($type == 1 || $type == 3)
	{
		$style_3 = $color ? ' style="background-color:' . $color . ';"' : '';
	}

	if ($type == 1)
	{
		$after_title = '<span class="after-title"></span>';
	}

	$cls .= ' type-' . $type;
	$cls .= $color ? ' box-color' : '';
	$cls .= $text2 ? ' istext2' : '';

	$style = $color ? ' style="background-color:' . $color . ';"' : '';

	$output .= '<div class="theme-box">';
	$output .= $link !='' ? '<a href="' . $link . '" class="theme-box-link" target="' . $link_target . '">' : '';
	$output .= '<div class="theme-boximg' . $cls . '">';
	$output .= '<div class="theme-boximg-image"><img src="' . $image . '" alt=""></div>';
	$output .= '<div class="theme-boxcontent">';
	$output .= '<div class="theme-boxcontent-inner">';
	$output .= '<div class="theme-boxcontent-inner2">';
	$output .= '<div class="theme-boxcontent-inner3">';
	$output .= '<h4 class="text1">' . $content . $after_title . '</h4>';
	$output .= $text2 ? '<div class="text2">' . $text2 . '</div>' : '';
	$output .= '<div class="bg"' . $style_3 . '></div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	$output .= '<div class="bg"' . $style . '></div>';

	$output .= '</div>';
	$output .= $link !='' ? '</a>' : '';
	$output .= '</div>';

	return $output;

}







mb2_add_shortcode('boxicon', 'mb2_shortcode_boxicon');


function mb2_shortcode_boxicon($atts, $content = null){
	extract(mb2_shortcode_atts( array(
		'icon' =>'fa-rocket',
		'type' => '',
		'title'=> '',
		'link' => '',
		'linktext' => '',
		'readmore' => '',
		'color' => 'primary',
		'custom_color' => '',
		'link_target' =>'',
		'image' => ''
	), $atts));

	$output = '';
	$height = 290;
	$heightstyle = '';
	$readmorelink = 0;
	$imageel = '';
	$linktext = $readmore ? $readmore : $linktext;
	$linktext_arr = explode('|', $linktext);
	$btn_cls = isset($linktext_arr[1]) ? $linktext_arr[1] : 'btn btn-primary';

	if ($color !== 'custom')
	{
		$custom_color = 0;
	}

	if ($type == '' && isset($GLOBALS['box_type']))
	{
		$type = $GLOBALS['box_type'];
	}

	if ( ! $linktext && theme_mb2mcl_check_for_tags($content, 'a') )
	{
		$link = 0;
	}

	if ($link && $linktext)
	{
		$readmorelink = 1;
	}

	$pref = theme_mb2mcl_font_icon_prefix($icon);

	$output .= '<div class="theme-box boxicon">';

	$output .= '<div class="theme-boxicon type-' . $type . ' color-' . $color . '">';
	$output .= ($link && !$linktext) ? '<a href="' . $link . '" target="' . $link_target . '">' : '';
	$output .= '<div class="theme-boxicon-inner"' . $heightstyle . '>';
	$output .= '<div class="theme-boxicon-inner2">';
	$output .= '<div class="theme-boxicon-icon">';
	$output .= '<i class="' . $pref . $icon . '"></i>';
	$output .= '</div>';

	$output .= '<div class="theme-boxicon-content">';

	if ($title)
	{
		$output .= '<h4>';
		$output .= theme_mb2mcl_get_highlight_text( $title );
		$output .= '</h4>';
	}

	$output .= $content ? '<div class="theme-boxicon-text">' . mb2_do_shortcode($content) . '</div>' : '';
	$output .= $readmorelink ? '<p class="readmore"><a class="' . $btn_cls . '" href="' . $link . '"  target="' . $link_target . '">' . $linktext_arr[0] . '</a></p>' : '';
	$output .= '</div>';
	$output .= $imageel;
	$output .= '</div>';

	$output .= '</div>';

	$output .= ($link && !$linktext) ? '</a>' : '';
	$output .= '</div>';
	$output .= '</div>';


	return $output;

}





mb2_add_shortcode('boxcontent', 'mb2_shortcode_boxcontent');

function mb2_shortcode_boxcontent ($atts, $content = null){
	extract(mb2_shortcode_atts( array(
		'icon' =>'',
		'type' => '',
		'title'=> '',
		'link' =>'',
		'linktext' => '',
		'height' => '',
		'color' => 'primary',
		'link_target' =>''
	), $atts));

	$output = '';
	$box_style = '';
	$height = ($height === '' && isset($GLOBALS['box_height'])) ? $GLOBALS['box_height'] : $height;
	$pref = theme_mb2mcl_font_icon_prefix($icon);

	if ($type == '' && isset($GLOBALS['box_type']))
	{
		$type = $GLOBALS['box_type'];
	}

	if ( ! $linktext && theme_mb2mcl_check_for_tags($content, 'a') )
	{
		$link = 0;
	}

	if ($height !== '')
	{
		$box_style .= ' style="height:' . $height . 'px;"';
	}

	$boxCls = $icon !='' ? ' isicon' : ' noicon';
	$boxCls .= $link !='' ? ' islink' : '';

	$output .= '<div class="theme-box boxcontent">';
	$output .= '<div class="theme-boxcontent type-' . $type . ' color-' . $color . $boxCls . '"' . $box_style . '>';
	$output .= ($link && !$linktext) ? '<a href="' . $link . '" target="' . $link_target . '"' . $box_style . '>' : '';
	$output .= '<div class="theme-boxcontent-inner">';
	$output .= '<div class="theme-boxcontent-content">';
	$output .=  $icon !='' ?'<div class="theme-boxcontent-icon">' : '';
	$output .=  $icon !='' ? '<i class="' . $pref . $icon . '"></i>' : '';
	$output .=  $icon !='' ?'</div>' : '';
	$output .= $title !='' ? '<h4 class="box-title">' . $title . '</h4>' : '';
	$output .= $content ? '<div class="theme-boxcontent-text">' . mb2_do_shortcode($content) . '</div>' : '';
	$output .= ($link && $linktext) ? '<a class="theme-boxcontent-readmore btn btn-sm" href="' . $link . '" target="' . $link_target . '">' . $linktext . '</a>' : '';
	$output .= '</div>';
	$output .= '</div>';
	$output .= ($link && !$linktext) ? '</a>' : '';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
