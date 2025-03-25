<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('slider', 'mb2_shortcode_slider');
mb2_add_shortcode('carousel', 'mb2_shortcode_slider');
mb2_add_shortcode('slider_item', 'mb2_shortcode_slider_item');
mb2_add_shortcode('carousel_item', 'mb2_shortcode_slider_item');

function mb2_shortcode_slider($atts, $content= null){
	extract(mb2_shortcode_atts( array(
		'margin' => '',
		'width' => '',
		'custom_class' => '',
		'prestyle' => '',
		'columns' => 1,
		'gutter' => 'normal',
		'sloop' => 1,
		'snav' => 1,
		'sdots' => 0,
		'autoplay' => 1	,
		'spausetime' => 5000,
		'sanimtime' => 450,
		'link' => 1,
		'link_target' => '',
		'readmoretext' => ''
	), $atts));


	$output = '';
	$sData = '';
	$style = '';
	$GLOBALS['link'] = $link;
	$GLOBALS['link_target'] = $link_target;
	$GLOBALS['readmoretext'] = $readmoretext;
	$GLOBALS['prestyle'] = $prestyle;
	$GLOBALS['custom_class'] = $custom_class;


	$cls = ' ' . $prestyle;
	$cls .= $custom_class ? ' ' . $custom_class : '';

	if ($width !='' || $margin !='')
	{
		$style .= ' style="';
		$style .= $margin !='' ? 'margin:' . $margin . ';' : '';
		$style .= $width !='' ? 'width:' . $width . 'px;max-width:100%;' : '';
		$style .= '"';
	}


	// Get corousel options
	$carousel_opt = array(
		'colnum' => $columns,
		'sdots' => $sdots,
		'sloop' => $sloop,
		'snav' => $snav,
		'sautoplay' => $autoplay,
		'spausetime' => $spausetime,
		'sanimate' => $sanimtime,
		'gridwidth' => $gutter
	);

	$sData = theme_mb2mcl_shortcodes_slider_data($carousel_opt);


	$cls .= $sdots == 1 ? ' isdots' : '';
	$cls .= $columns > 1 ? ' carousel-mode' : ' slider-mode';

	$output .= '<div class="theme-slider-wrap"' . $style . '>';
	$output .= '<div class="theme-slider owl-carousel' . $cls . '"' . $sData  . '>';
	$output .= mb2_do_shortcode($content);
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}





function mb2_shortcode_slider_item($atts, $content = null){
	extract(mb2_shortcode_atts( array(
		'title' => '',
		'desc' => '',
		'image' => '',
		'color' => '',
		'link' => '',
		'target' => ''
		), $atts)
	);

	$output = '';
	$cls = '';
	$content4_style = '';

	if ($color)
	{
		$cls = ' iscolor';
	}

	if (isset($GLOBALS['custom_class']) && preg_match('@mb2mcl@', $GLOBALS['custom_class']))
	{
		$content4_style = ' style="background-color:' . $color . ';"';
	}

	$isTarget = $GLOBALS['link_target'] === '_blank' ? ' target="_blank"' : '';
	$link_type = $GLOBALS['link'];

	$color_style = $color ? ' style="background-color:' . $color . ';"' : '';

	$output .= '<div class="theme-slider-item' . $cls . '">';
	$output .= '<div class="theme-slider-item-inner"' . $color_style . '>';

	$output .= ($link && $link_type == 2) ? '<a href="' . $link . '"' . $isTarget . '>' : '';

	$output .= '<div class="theme-slider-img">';
	$output .= '<img src="' . $image . '" alt="' . $title . '">';
	$output .= '</div>';

	if ($content || $desc || $title)
	{

		$output .= '<div class="theme-slide-content1">';
		$output .= '<div class="theme-slide-content2">';
		$output .= '<div class="theme-slide-content3">';
		$output .= '<div class="theme-slide-content4"' . $content4_style . '>';

		if ($title)
		{
			$output .= '<h4 class="theme-slide-title">';
			$output .= ($link && $link_type == 1) ? '<a href="' . $link . '"' . $isTarget . '>' : '';
			$output .= $title;
			$output .= ($link && $link_type == 1) ? '</a>' : '';
			$output .= '</h4>';
		}

		if ($desc || $content)
		{
			$output .= '<div class="theme-slider-item-details">';

			$desc = $content ? $content : $desc;

			if ($desc)
			{
				$output .= '<div class="theme-slider-desc">';
				$output .= $desc;
				$output .= '</div>';
			}

			if ($link && $link_type == 1)
			{
				$readmoretext = $GLOBALS['readmoretext'] ? $GLOBALS['readmoretext'] : get_string('readmore','theme_mb2mcl');

				$output .= '<div class="theme-slider-readmore">';
				$output .= '<a class="btn btn-primary" href="' . $link . '"' . $isTarget . '>' . $readmoretext . '</a>';
				$output .= '</div>';
			}

			$output .= '</div>';
		}

		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	}
$output .= '<div class="theme-slider-bg"' . $color_style . '></div>';
	$output .= ($link && $link_type == 2) ? '</a>' : '';

	$output .= '</div>';

	$output .= '</div>';


	return $output;


}
