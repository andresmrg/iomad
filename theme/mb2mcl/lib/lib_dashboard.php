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



function theme_mb2mcl_dashboard()
{

    $output = '';

    $output .= theme_mb2mcl_dashboard_courses();

    return $output;
}





/*
 *
 * Method to get courses tab
 *
 */
function theme_mb2mcl_dashboard_courses ()
{

    $output = '';

    $output .= '<div class="theme-tabs tabs top">';

    $output .= '<ul class="nav nav-tabs">';
    $output .= '<li class="active"><a href="#theme_dashboard_courses_inprogress" data-toggle="tab">' . get_string('inprogress','completion');
    $output .= '<span class="theme-dashboard-count">' . theme_mb2mcl_dashboard_course_count('inprogress') . '</span>';
    $output .= '</a></li>';

    $output .= '<li><a href="#theme_dashboard_courses_future" data-toggle="tab">' . get_string('future','block_myoverview');
    $output .= '<span class="theme-dashboard-count">' . theme_mb2mcl_dashboard_course_count('future') . '</span>';
    $output .= '</a></li>';

    $output .= '<li><a href="#theme_dashboard_courses_past" data-toggle="tab">' . get_string('past','block_myoverview');
    $output .= '<span class="theme-dashboard-count">' . theme_mb2mcl_dashboard_course_count('past') . '</span>';
    $output .= '</a></li>';
    $output .= '</ul>';

    $output .= '<div class="tab-content">';

    $output .= '<div id="theme_dashboard_courses_inprogress" class="tab-pane active">';
    $courses_inprogress = theme_mb2mcl_dashboard_courses_template('inprogress');
    if ($courses_inprogress === 'nocourses')
    {
        $output .= get_string('nocoursesinprogress','block_myoverview');
    }
    else
    {
        $output .= $courses_inprogress;
    }
    $output .= '</div>';

    $output .= '<div id="theme_dashboard_courses_future" class="tab-pane">';
    $courses_future = theme_mb2mcl_dashboard_courses_template('future');

    if ($courses_future === 'nocourses')
    {
        $output .= get_string('nocoursesfuture','block_myoverview');
    }
    else
    {
        $output .= $courses_future;
    }
    $output .= '</div>';

    $output .= '<div id="theme_dashboard_courses_past" class="tab-pane">';
    $courses_past = theme_mb2mcl_dashboard_courses_template('past');
    if ($courses_past === 'nocourses')
    {
        $output .= get_string('nocoursespast','block_myoverview');
    }
    else
    {
        $output .= $courses_past;
    }
    $output .= '</div>';

    $output .= '</div>'; // End tab content
    $output .= '</div>'; // End tab

    return $output;


}





/*
 *
 * Method to get courses classify list
 *
 */
function theme_mb2mcl_dashboard_courses_template ($classify)
{

    $output = '';
    $i = 0;
    $courses = theme_mb2mcl_dashboard_courses_items($classify);

    foreach ($courses as $course)
    {
        if ($course->showitem)
        {
            $i++;

            $link = new moodle_url($CFG->wwwroot . '/course/view.php', array('id' => $course->id));

            // $output .= '<div class="theme-dashboard-course-item">';
            // $output .= '<div class="theme-dashboard-course-item-inner">';
            // $output .= '<div class="theme-dashboard-course-image">';
            // $output .= '<img src="' . $course->imgurl . '" alt="' . $course->imgname . '" />';
            // $output .= '</div>';
             $output .= '<h4 class="theme-dashboard-course-title"><a href="' . $link . '">' . $course->title . '</a></h4>';
            // $output .= '<div class="theme-dashboard-course-item-desc">';
            // $output .= $course->description;
            // $output .= '</div>';
            $output .= theme_mb2mcl_dashboard_course_progress_bar($course);
            // $output .= '</div>';
            // $output .= '</div>';
        }
    }

    if ($i == 0)
    {
        $output = 'nocourses';
    }

    return $output;
}





/*
 *
 * Method to get course progressbar
 *
 */
function theme_mb2mcl_dashboard_course_progress_bar ($course)
{
    $output = '';

    $completion = new \completion_info($course);

    if ($completion->is_enabled() && method_exists('\core_completion\progress','get_course_progress_percentage'))
    {

        $progress = \core_completion\progress::get_course_progress_percentage($course);
		$isprogress = ! is_null($progress) ? floor($progress) : 0;

        $color = 'success';

		if ($isprogress < 33)
		{
			$color	= 'danger';
		}
		elseif ($isprogress < 66)
		{
			$color	= 'warning';
		}
		elseif ($isprogress < 100)
		{
			$color	= 'info';
		}

        // $output .='<div class="theme-dashboard-course-progress progress">';
		// $output .='<div class="progress-bar progress-bar-' . $color . '" role="progressbar" aria-valuenow="' .
		// $progress . '" aria-valuemin="0" aria-valuemax="100" style="width:' . $isprogress . '%">' .  $isprogress . '%';
		// $output .=' </div>';
		// $output .='</div>';

        $output .= $isprogress;
    }

    return $output;

}





/*
 *
 * Method to get courses array
 *
 */
function theme_mb2mcl_dashboard_courses_items($classify)
{

	global $CFG,$PAGE,$USER,$DB,$OUTPUT,$COURSE;

	require_once($CFG->dirroot . '/course/lib.php');
    if (!theme_mb2mcl_moodle_from(2018120300))
	{
		require_once($CFG->libdir . '/coursecatlib.php');
	}

	$output = array();
	$i = 0;

	$context = context_course::instance($COURSE->id);
	$coursecat_canmanage = has_capability('moodle/category:manage', $context);

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

            // Show only courses which user is enrolled in
            $course_context = context_course::instance($course->id);

            if (!is_enrolled($course_context,$USER))
            {
                $course->showitem = false;
            }

            $classified = course_classify_for_timeline($course);
            if ($classified !== $classify)
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

		}
	}

	return $coursesList;
}



/*
 *
 * Method to get course progressbar
 *
 */
function theme_mb2mcl_dashboard_course_count ($classify)
{
    $i = 0;
    $courses = theme_mb2mcl_dashboard_courses_items($classify);

    foreach ($courses as $course)
    {
        if ($course->showitem)
        {
            $i++;
        }
    }

    return $i;


}
