<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('tabs', 'mb2_shortcode_tab');
mb2_add_shortcode('tab_item', 'mb2_shortcode_tab_item');

function mb2_shortcode_tab($atts, $content = null ) {

	$unique = mt_rand();

	extract( mb2_shortcode_atts( array(
		  'tabpos' => 'top',
		  'height'=>'200',
		  'custom_class' => '',
		  'margin' => ''
	), $atts ));


	$regex = '\\[(\\[?)(tab_item)\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
	preg_match_all("/$regex/is",$content,$match);
	$content = $match[0];


	// Define tabs style
	$style = ' style="';
	$style .= 'min-height:' . $height . 'px;';
	$style .= $margin !='' ? 'margin:' . $margin . 'px;' : '';
	$style .= '"';


	$cls = $tabpos;
	$cls .= $custom_class ? ' ' . $custom_class : '';


	$output = '<div class="theme-tabs tabs ' . $cls . '"' . $style . '>';
	$i = -1;


	$output .= '<ul class="nav nav-tabs">';

	foreach($content as $c)
	{
		$i++;
		$unique_id = 'tab_' . $unique . '_' . $i;
		preg_match('/\[tab_item ([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)/', $c, $matchattr);
		$attr = shortcode_parse_atts($matchattr[1]);

		$tab_selected = 'false';
		$title = $attr['title'];
		$icon = isset($attr['icon']) ? $attr['icon'] : '';

		if ($i == 0)
		{
			$tab_selected = 'true';
		}

		if($icon){

			// Check what is the icon and set prefix
			// and set preffix
			$isfa = preg_match('@fa-@', $icon);
			$isglyphicon = preg_match('@glyphicon-@', $icon);

			if ($isfa)
			{
				$iconpref = 'fa ';
			}
			elseif($isglyphicon)
			{
				$iconpref = 'glyphicon ';
			}
			else
			{
				$iconpref = '';
			}

			$title = '<i class="'. $iconpref . $icon . '"></i> ' . $title;

		}

		$output .= '<li class="nav-item"><a class="nav-link'. (($i==0) ? ' active' : '') .'" id="' . $unique_id . '_tab" href="#' . $unique_id
		. '" data-toggle="tab" role="tab" aria-controls="' . $unique_id . '" aria-selected="' . $tab_selected . '">' . format_text($title, FORMAT_HTML) . '</a></li>';
		$content[$i] = str_replace('[tab_item ','[tab_item '.(($i==0) ? 'class="active"' : '') . ' id="' . $unique_id . '" ', $content[$i]);

	}


	$output .= '</ul>';
	$output .= '<div class="tab-content">';


	foreach($content as $c){
		$output .= mb2_do_shortcode($c);
	}


	$output .= '</div>';
	$output .= '</div>';


	return $output;

}




function mb2_shortcode_tab_item( $atts, $content = null ) {
	extract( mb2_shortcode_atts( array(
		'title' => '',
		'id' =>'',
		'icon' => '',
		'class' =>''
	), $atts ) );

	$isclass = $class ? ' ' .$class : '';

	$output = '<div class="tab-pane' . $isclass . '" id="' . $id . '" role="tabpanel" aria-labelledby="' . $id . '">';

	$output .= mb2_do_shortcode(format_text($content, FORMAT_HTML));

	$output .= '</div>';

	return $output;
}
