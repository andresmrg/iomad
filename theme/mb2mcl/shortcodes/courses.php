<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('courses', 'mb2_shortcode_courses');


function mb2_shortcode_courses($atts, $content= null){

	extract(mb2_shortcode_atts(array(
		'limit' => 8,
		'catids' => '',
		'courseids' => '',
		'excourses' => 0,
		'excats' => 0,
		'layout' => 'cols',
		'colnum' => 3,
		'sdots' => 0,
		'sloop' => 0,
		'snav' => 1,
		'sautoplay' => 1,
		'spausetime' => 7000,
		'sanimate' => 600,
		'desclimit' => 25,
		'titlelimit' => 6,
		'gridwidth' => 'normal',
		'link' => 1,
		'readmoretext' => '',
		'prestyle' => 0,
		'custom_class' => '',
		'colors' => '',
		'margin' => '',
		'courseprices' => '',
		'currency' => 'USD:24'
	), $atts));


	$output = '';
	$cls = '';
	$list_cls = '';
	$col_cls = '';

	// Set column style
	$col = 0;
	$col_style = '';
	$list_style = '';
	$slider_data = '';

	// Get content source
	$items_opt = array(
		'limit'=>$limit,
		'catids'=>$catids,
		'excats'=>$excats,
		'excourses' => $excourses,
		'courseids' => $courseids,
		'colors'=>$colors,
		'layout'=> $layout,
		'col_cls' => $col_cls,
		'link' => $link,
		'titlelimit' => $titlelimit,
		'desclimit' => $desclimit,
		'colnum' => $colnum,
		'readmoretext' => $readmoretext,
		'courseprices' => $courseprices,
		'currency' => $currency
	);

	$courses = theme_mb2mcl_courses_get_items($items_opt);
	$itemCount = count($courses);
	$carousel = ($layout === 'slidercols' && $itemCount > $colnum);

	// Get corousel options
	$carousel_opt = array(
		'colnum' => $colnum,
		'sdots' => $sdots,
		'sloop' => $sloop,
		'snav' => $snav,
		'sautoplay' => $sautoplay,
		'spausetime' => $spausetime,
		'sanimate' => $sanimate,
		'gridwidth' => $gridwidth
	);


	// Carousel layout
	if ($carousel)
	{
		$list_cls .= ' owl-carousel';
		$col_cls .= ' item';
		$slider_data = theme_mb2mcl_shortcodes_slider_data($carousel_opt);
	}

	if ($layout === 'slidercols' && $itemCount <= $colnum)
	{
		$layout = 'cols';
	}

	$cls .= ' ' . $layout;
	$cls .= ' gwidth-' . $gridwidth;
	$cls .= $colnum > 2 ? ' multicol' : '';
	$cls .= $prestyle ? ' ' . $prestyle : '';
	$cls .= ($carousel) ? ' carousel' : ' nocarousel';

	$output .= '<div class="mb2-pb-content mb2-pb-courses clearfix' . $cls . '">';
	$output .= '<div class="mb2-pb-content-inner clearfix">';
	$output .= '<div class="mb2-pb-content-list' . $list_cls . '"' . $slider_data . '>';


	if ($itemCount>1)
	{
		$output .= theme_mb2mcl_shortcodes_content_template($courses, $items_opt);
	}
	else
	{
		$output .= get_string('nothingtodisplay');

		if (in_array(theme_mb2mcl_site_access(),array('admin','manager','coursecreator')))
		{
			$output .= '<div>';
			$output .= '<a href="' . new moodle_url($CFG->wwwroot . '/course/edit.php',array('category'=>theme_mb2mcl_get_category()->id)) . '">' .
			get_string('createnewcourse') . '</a>';
			$output .= '</div>';
		}
	}

	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
