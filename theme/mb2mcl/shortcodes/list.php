<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('list', 'mb2_list_shortcode');
mb2_add_shortcode('list_item', 'mb2_list_item_shortcode');

function mb2_list_shortcode($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'type' => 1,
		'style' => '',
		'icon' => '',
		'horizontal' => 0,
		'align' => 'left',
		'custom_class' => '',
		'columns' => 1,
		'margin' => ''
		), $atts)
	);


	$GLOBALS['icon'] = $icon;

	// Define list class
	$cls = $horizontal == 1 ? ' list-horizontal' : '';
	$cls .= ' list-' . $align;
	$cls .= $style ? ' list-' . $style : '';
	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= ' list-col-' . $columns;

	$list_tag = 'ul';

	if ($style === 'number')
	{
		$list_tag = 'ol';
	}

	$style_attr = $margin !='' ? ' style="margin:' . $margin . ';"' : '';

	$output = '';
	$output .= '<' . $list_tag . ' class="theme-list list' . $type . $cls . '"' . $style_attr . '>';
	$output .= mb2_do_shortcode($content);
	$output .= '</' . $list_tag . '>';

	return $output;

}



function mb2_list_item_shortcode ($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'icon' => '',
		'link'=> '',
		'link_target'=> ''
	), $atts));

	$global_icon = isset($GLOBALS['icon']) ? $GLOBALS['icon'] : '';
	$icon = $icon ? $icon : $global_icon;

	$cls = '';
	$output = '';

	$pref = theme_mb2mcl_font_icon_prefix($icon);

	$isicon = $icon ? '<i class="' . $pref . $icon . '"></i> ' : '';

	$target = $link_target ? ' target="' . $link_target . '"' : '';

	$output = '';

	$output .= '<li>';
	$output .= $link !='' ? '<a href="' . $link . '"' . $target . '>' : '';
	$output .= $isicon;
	$output .= mb2_do_shortcode($content);
	$output .= $link !='' ? '</a>' : '';
	$output .= '</li>';


	return $output;


}
