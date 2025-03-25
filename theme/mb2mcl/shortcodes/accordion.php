<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('accordion', 'mb2_shortcode_accordion');
mb2_add_shortcode('accordion_item', 'mb2_shortcode_accordion_item');


function mb2_shortcode_accordion($atts, $content= null){

	extract(mb2_shortcode_atts( array(
		'show_all' => 0,
		'custom_class' => '',
		'accordion_active' => theme_mb2mcl_shortcodes_global_opts('accordion', 'accordion_active', 1),
		'margin' => '',
		'parent' => 1
		), $atts)
	);

	$output = '';


	if(isset($GLOBALS['accordion_count']))
	{
	  $GLOBALS['accordion_count']++;
	}
	else
	{
	  $GLOBALS['accordion_count'] = 0;
	}

	$GLOBALS['show_all'] = $show_all;
	$GLOBALS['accordion_active'] = $accordion_active;
	$GLOBALS['parent'] = $parent;

	$cls = $custom_class ? ' ' . $custom_class : '';

	$style = $margin !='' ? ' style="margin:' . $margin . ';"' : '';

	$output .= '<div class="mb2-accordion accordion' . $cls . '"' . $style;

	if($parent)
	{
		$output .= ' id="theme-accordion-' . $GLOBALS['accordion_count'] . '"';
	}

	$output .= '>' . mb2_do_shortcode($content) . '</div>';

	unset($GLOBALS['accordion_item_count']);

	return $output;

}





function mb2_shortcode_accordion_item($atts, $content= null){
	extract(mb2_shortcode_atts( array(
		'title' => '',
		'active' => 0,
		'icon' => ''
		), $atts)
	);


	// Get globals
	$accordion_count = isset($GLOBALS['accordion_count']) ? $GLOBALS['accordion_count'] : 0;

	// Get collapse id
	if (isset($GLOBALS['accordion_item_count']))
	{
		$GLOBALS['accordion_item_count']++;
	}
	else
	{
		$GLOBALS['accordion_item_count'] = 1;
	}

	$col_id = 'acc_item_' . theme_mb2mcl_string_url_safe($title) . '_' . $accordion_count . '_' . $GLOBALS['accordion_item_count'] . '_';


	$output = '';
	$show = '';
	$expanded = 'false';
	$cls = 'collapsed';
	$is_icon = ' no-icon';


	// Check if is active
	if($GLOBALS['accordion_active'] == $GLOBALS['accordion_item_count'])
	{
		$show = ' show';
		$expanded = 'true';
		$cls = '';
	}

	if ($GLOBALS['show_all'])
	{
		$show = ' show';
	}

	$pref = theme_mb2mcl_font_icon_prefix($icon);


	// Check if in title is an icon
	if($icon)
	{
		$is_icon = ' is-icon';
		$title = '<i class="' . $pref . $icon . '"></i> ' . format_text($title, FORMAT_HTML);
	}

	$parent = isset($GLOBALS['parent']) ? $GLOBALS['parent'] : 1;

	$isparent = $parent ? ' data-parent="#theme-accordion-' . $accordion_count . '"' : '';

	$output .= '<div class="card">';

	$output .= '<div class="card-header' . $is_icon . '">';
	$output .= '<h5 class="mb-0">';
	$output .= '<a href="#' . $col_id . '2" data-toggle="collapse" ' . $isparent . ' data-target="#' .
	$col_id . '2" aria-controls="#' . $col_id . '2" aria-expanded="' . $expanded . '">';

	//class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
	$output .= $title;
	$output .= '</a>';
	$output .= '</h5>';
	$output .= '</div>';


	$output .= '<div id="' . $col_id . '2" class="collapse' . $show . '"' . $isparent . '>';
	$output .= '<div class="card-body">';
	$output .= mb2_do_shortcode(format_text($content, FORMAT_HTML));
	$output .= '</div>';
	$output .= '</div>';


	$output .= '</div>';


	return $output;
}
