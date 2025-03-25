<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 *
 * @package   theme_mb2mcl
 * @copyright 2020 - 2022 Mariusz Boloz (https://lmsstyle.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */

defined('MOODLE_INTERNAL') || die();


/*
 *
 * Method to get courses list
 *
 */
function theme_mb2mcl_courses_get_items ($options)
{

	global $CFG,$PAGE,$USER,$DB,$OUTPUT,$COURSE;

	require_once($CFG->dirroot . '/course/lib.php');
	if (!theme_mb2mcl_moodle_from(2018120300))
	{
		require_once($CFG->libdir . '/coursecatlib.php');
	}


	$output = array();
	$i = 0;

	//$context = $PAGE->context;
	$context = context_course::instance($COURSE->id);
	$coursecat_canmanage = has_capability('moodle/category:manage', $context);


	$catsArr = explode(',', str_replace(' ', '', $options['catids']));
	$coursesArr = explode(',', str_replace(' ', '', $options['courseids']));
	$exCats = $options['excats'];
	$exCourses = $options['excourses'];


	$coursesList = get_courses('all');
	$itemCount = count($coursesList);


	if ($itemCount>0)
	{
		foreach ($coursesList as $course)
		{

			// Get course category
			if (theme_mb2mcl_moodle_from(2018120300))
    		{
				$cat = core_course_category::get($course->category, IGNORE_MISSING);
    		}
    	    else
    	    {
    	        $cat = coursecat::get($course->category, IGNORE_MISSING);
    	    }
			$course->showitem = true;

			// Check if some category are included/excluded
			if ($catsArr[0])
			{
				$course->showitem = false;

				if ($exCats === 'exclude')
				{
					if (!in_array($course->category,$catsArr))
					{
						$course->showitem = true;
					}
				}
				elseif ($exCats === 'include')
				{
					if (in_array($course->category,$catsArr))
					{
						$course->showitem = true;
					}
				}
			}


			if ($coursesArr[0])
			{
				$course->showitem = false;

				if ($exCourses === 'exclude')
				{
					if (!in_array($course->id,$coursesArr))
					{
						$course->showitem = true;
					}
				}
				elseif ($exCourses === 'include')
				{
					if (in_array($course->id,$coursesArr))
					{
						$course->showitem = true;
					}
				}
			}

			if ($course->category == 0)
			{
				$course->showitem = false;
			}

			if ((!isset($cat->visible) || !$cat->visible) && !$coursecat_canmanage)
			{
				$course->showitem = false;
			}

			if ($course->id == 1)
			{
				$course->showitem = false;
			}


			// Get image url
			// If attachment is empty get image from post
			$imgUrlAtt = theme_mb2mcl_shortcodes_content_get_image(array(), false, '', $course->id);
			$imgNameAtt = theme_mb2mcl_shortcodes_content_get_image(array(), true, '',  $course->id);

			$moodle33 = 2017051500;
			$placeholder_image = $CFG->version >= $moodle33 ? $OUTPUT->image_url('course-default','theme') : $OUTPUT->pix_url('course-default','theme');

			$course->imgurl = $imgUrlAtt ? $imgUrlAtt : $placeholder_image;
			$course->imgname = $imgNameAtt;


			// Define item elements
			$course->link = new moodle_url($CFG->wwwroot . '/course/view.php', array('id' => $course->id));
			$course->link_edit =  new moodle_url($CFG->wwwroot . '/course/edit.php', array('id' => $course->id));
			$course->edit_text = get_string('editcoursesettings', 'core');
			$course->title = $course->fullname;
			$course->description = $course->summary;
			$course->details = '&nbsp;';

			if ((isset($cat->visible) && !$cat->visible) && $coursecat_canmanage)
			{
				$course->details = $cat->get_formatted_name() . ' (' . get_string('hidden','theme_mb2mcl') . ')';
			}
			elseif ((isset($cat->visible) && $cat->visible))
			{
				$course->details = $cat->get_formatted_name();
			}

			if (isset($course->visible) && !$course->visible)
			{
				$course->title .= ' (' . get_string('hidden','theme_mb2mcl') . ')';
			}

			$course->redmoretext = get_string('readmore', 'theme_mb2mcl');
			$price = theme_mb2mcl_courses_course_price($course->id, $options);
			$course->price = '';

			if ($options['courseprices'])
			{
				$course->price = $price ? $price : '<span class="freeprice">' . get_string('noprice','theme_mb2mcl') . '</span>';
			}

		}
	}

	return $coursesList;
}







function theme_mb2mcl_courses_course_price ($id, $options)
{

	$output = '';

	$prices = $options['courseprices'];
	$pricesArr = explode(',',str_replace(' ','',$prices));
	$currency = theme_mb2mcl_courses_currency($options['currency']);

	foreach($pricesArr as $price)
	{

		$priceArr = explode(':',$price);


		if ($id == $priceArr[0])
		{
			$output .= isset($priceArr[2]) ? '<span class="oldprice"><del>' . $currency . trim($priceArr[2]) . '</del></span>' : '';
			$output .= isset($priceArr[1]) ? '<span class="price">' . $currency . trim($priceArr[1]) . '</span>' : '';
		}

	}

	return $output;

}




function theme_mb2mcl_courses_currency ($currency)
{

	$output = '';
	$is_c = '';


	// Get currency symbol
	$currencyarr = explode(':', $currency);

	$output .= '<span class="currency">';

	if (preg_match('#\\,#', $currencyarr[1]))
	{

		$curr = explode(',', $currencyarr[1]);

		foreach ($curr as $c)
		{
			$output .= '&#x' . $c;
		}
	}
	else
	{
		$output .= '&#x' . $currencyarr[1];
	}

	$output .= '</span>';



	return $output;


}
