<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('categories', 'mb2_shortcode_categories');


function mb2_shortcode_categories($atts, $content= null){

	extract(mb2_shortcode_atts(array(
		'limit' => 8,
		'catids' => 0,
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
		'margin' => ''
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
		'colors'=>$colors,
		'layout'=> $layout,
		'col_cls' => $col_cls,
		'link' => $link,
		'titlelimit' => $titlelimit,
		'desclimit' => $desclimit,
		'colnum' => $colnum,
		'readmoretext' => $readmoretext
	);

	$categories = theme_mb2mcl_shortcodes_categories_get_items($items_opt);
	$itemCount = count($categories);
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

	$output .= '<div class="mb2-pb-content mb2-pb-categories clearfix' . $cls . '">';
	$output .= '<div class="mb2-pb-content-inner clearfix">';
	$output .= '<div class="mb2-pb-content-list' . $list_cls . '"' . $slider_data . '>';

	if ($itemCount>0)
	{
		$output .= theme_mb2mcl_shortcodes_content_template($categories, $items_opt);
	}
	else
	{
		$output .= get_string('nothingtodisplay');
	}

	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}





/*
 *
 * Method to get categories list
 *
 */
function theme_mb2mcl_shortcodes_categories_get_items ($options)
{

	global $CFG, $USER, $DB, $OUTPUT;

	require_once($CFG->dirroot . '/course/lib.php');
	if (!theme_mb2mcl_moodle_from(2018120300))
	{
		require_once($CFG->libdir . '/coursecatlib.php');
	}

	$categories = array();

	$catids = str_replace(' ', '', $options['catids']);
	$exCats = $options['excats'] === 'exclude' ? ' NOT' : '';

	$query = 'SELECT * FROM ' . $CFG->prefix . 'course_categories';
	$query .= ($options['excats'] && $catids > 0) ? ' WHERE id' . $exCats . ' IN (' . $catids . ')' : '';
	$query .= ' ORDER BY sortorder';
	//$query .= ' ORDER BY sortorder LIMIT ' . $options['limit'] . ' OFFSET 0';
	$categories = $DB->get_records_sql($query);

	$itemCount = count($categories);

	if ($itemCount>0)
	{
		foreach ($categories as $category)
		{

			$context = context_coursecat::instance($category->id);
			$coursecat_canmanage = has_capability('moodle/category:manage', $context);
			$category->showitem = true;


			if ((!isset($category->visible) || !$category->visible) && !$coursecat_canmanage)
			{
				$category->showitem = false;
			}

			// Get category image
			$image_options = array('context'=>$context->id,'mod'=>'coursecat','area'=>'description','itemid'=>0);
			$imgUrlAtt = theme_mb2mcl_shortcodes_content_get_image($image_options, false, $category->description);
			$imgNameAtt = theme_mb2mcl_shortcodes_content_get_image($image_options, true, $category->description);

			$moodle33 = 2017051500;
			$placeholder_image = $CFG->version >= $moodle33 ? $OUTPUT->image_url('course-default','theme') : $OUTPUT->pix_url('course-default','theme');
			$category->imgurl = $imgUrlAtt ? $imgUrlAtt : $placeholder_image;
			$category->imgname = $imgNameAtt;

			// Define item elements
			$category->link = new moodle_url($CFG->wwwroot . '/course/index.php', array('categoryid'=>$category->id));
			$category->link_edit = new moodle_url($CFG->wwwroot . '/course/editcategory.php', array('id'=>$category->id));
			$category->edit_text = get_string('editcategorythis', 'core');

			$category->title = $category->name;
			$category->description = file_rewrite_pluginfile_urls($category->description, 'pluginfile.php', $context->id, 'coursecat', 'description', NULL);
			$category->description = format_text($category->description);

			if (isset($category->visible) && !$category->visible)
			{
				$category->title .= ' (' . get_string('hidden','theme_mb2mcl') . ')';
			}

			// Get course count in a category
			$coursesList = array();

			if ($category->id && $category->visible)
			{
				if (theme_mb2mcl_moodle_from(2018120300))
				{
					$coursesList = core_course_category::get($category->id)->get_courses(array('recursive' => false));
				}
				else
				{
					$coursesList = coursecat::get($category->id)->get_courses(array('recursive' => false));
				}
			}

			$courseCount = count($coursesList);
			$courseString = $courseCount > 1 ? get_string('courses') : get_string('course');
			$category->details = $courseCount > 0 ? $courseCount . ' ' . $courseString : get_string('nocourseincategory', 'theme_mb2mcl');
			$category->redmoretext = '';
			$category->price = '';



		}
	}

	return $categories;

}
