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
 * Method to display site menu links
 *
 */
function theme_mb2mcl_site_menu()
{

	global $PAGE,$COURSE,$USER;
	$output = '';
	$isCourse = (isset($COURSE->id) && $COURSE->id > 1);
	$context = context_course::instance($COURSE->id);
	$enrolled = is_enrolled($context, $USER->id,'',true);
	$siteMenuIems = explode(',',theme_mb2mcl_theme_setting($PAGE,'sitemnuitems','dashboard,frontpage,calendar,badges,courses'));

	// Additional menu items
	$siteMenuIems[] = 'buildfrontpage';
	$siteMenuIems[] = 'turneditingcourse';
	$siteMenuIems[] = 'editpage';

	$course_access = theme_mb2mcl_site_access();
	$can_manage = array('admin','manager','editingteacher','teacher');
	$course_manage_string = in_array($course_access,$can_manage) ? get_string('coursemanagement','theme_mb2mcl') : get_string('coursedashboard','theme_mb2mcl');


	$output .= '<ul class="site-menu-list dropdown-list">';

	if (theme_mb2mcl_theme_setting($PAGE,'sitemnu'))
	{

		foreach ($siteMenuIems as $item)
		{
			foreach (theme_mb2mcl_site_menu_items() as $k=>$el)
			{
				if ($k === trim($item) && in_array($course_access,$el['access']) && $el['course'])
				{

					$shown = true;

					if (isset($el['shown']))
					{
						$shown = $el['shown'];
					}

					if ($shown)
					{
						$output .= '<li class="item-' . $k . '">';
						$output .= '<a class="btn btn-sm isicon" href="' . $el['link'] . '">';
						$output .= '<span class="btn-icon"><i class="' . $el['icon'] . '"></i></span>';
						$output .= '<span class="item-text">' . $el['text'] . '</span>';
						$output .= '</a>';
						$output .= '</li>';
					}
				}
			}
		}
	}

	$output .= '</ul>';

	return $output;

}






/*
 *
 * Method to display site menu item
 *
 *
 */
function theme_mb2mcl_site_menu_items()
{

	global $COURSE,$CFG,$PAGE,$DB,$USER;
	$isCourse = (isset($COURSE->id) && $COURSE->id > 1);
	$m27 = 2014051220; // Last formal release of Moodle 2.7

	// Check if is frontpage
	$isfp = $PAGE->pagetype === 'site-index';
	$isds = $PAGE->pagelayout === 'mycourses' ? true : $PAGE->pagetype !== 'my-index';

	// Check if front page builde can be use
	$ispb = ($isfp && is_dir($CFG->dirroot . '/local/mb2builder'));

	// Check if is page added to the front page
	$isFpPage = ( $PAGE->pagetype === 'mod-page-view' && $COURSE->id == 1);

	// Check is is course page or admin pages
    $showmanage = (
 	   $PAGE->pagetype === 'site-index' ||
 	   $PAGE->pagetype === 'course-index' ||
 	   $PAGE->pagetype ==='course-index-category' ||
 	   $PAGE->pagetype === 'my-index');


   // Get front page editing links
   $fpedit = 'on';
   $fpedit_string = get_string('turneditingon');

   if ($PAGE->user_is_editing())
   {
 	 $fpedit = 'off';
 	 $fpedit_string = get_string('turneditingoff');
   }


	$items = array(
		'addcourse' => array(
			'access' => array('admin','manager','coursecreator'),
			'course' => true,
			'icon' => 'fa fa-plus',
			'text' => get_string('createnewcourse'),
			'link' => new moodle_url($CFG->wwwroot . '/course/edit.php',array('category'=>theme_mb2mcl_get_category()->id))
		),
		'addcategory' => array(
			'access' => array('admin','manager'),
			'course' => true,
			'icon' => 'fa fa-plus',
			'text' => get_string('createnewcategory'),
			'link' => new moodle_url($CFG->wwwroot . '/course/editcategory.php',array('parent'=>1))
		),
		'editcourse' => array(
			'access' => array('admin','manager','editingteacher'),
			'course' => $isCourse,
			'icon' => 'fa fa-edit',
			'text' => get_string('editcoursesettings'),
			'link' => new moodle_url($CFG->wwwroot . '/course/edit.php',array('id'=>$COURSE->id))
		),
		'editpage' => array(
			'access' => array('admin','manager','editingteacher'),
			'course' => $isFpPage,
			'icon' => 'fa fa-edit',
			'text' => get_string('editsettings'),
			'link' => isset( $PAGE->cm->id ) ? new moodle_url( $CFG->wwwroot . '/course/modedit.php',array( 'update' => $PAGE->cm->id, 'return' => 1 )) : ''
		),
		'editcategory' => array(
			'access' => array('admin','manager'),
			'course' => $isCourse,
			'icon' => 'fa fa-edit',
			'text' => get_string('editcategorysettings'),
			'link' => new moodle_url($CFG->wwwroot . '/course/editcategory.php',array('id'=>$COURSE->category))
		),
		'calendar' => array(
			'access' => array('admin','manager','editingteacher','teacher','coursecreator','student','user'),
			'course' => true,
			'icon' => 'fa fa-calendar',
			'text' => get_string('calendar','calendar'),
			'link' => new moodle_url($CFG->wwwroot . '/calendar/view.php',array('view'=>'month'))
		),
		'badges' => array(
			'access' => array('admin','manager','editingteacher','teacher','coursecreator','student','user'),
			'course' => true,
			'icon' => 'fa fa-bookmark',
			'text' => ($CFG->version > $m27) ? get_string('badges','badges') : get_string('mybadges','badges'),
			'link' => new moodle_url($CFG->wwwroot . '/badges/mybadges.php')
		),
		'mycourses' => array(
			'access' => array('admin','manager','editingteacher','teacher','coursecreator','student','user'),
			'course' => true,
			'shown' => ( $CFG->version >= 2022041900 && theme_mb2mcl_get_mycourses() && $PAGE->pagelayout !== 'mycourses' ),
			'icon' => 'fa fa-graduation-cap',
			'text' => get_string('mycourses'),
			'link' =>  new moodle_url('/my/courses.php')
		),
		'courses' => array(
			'access' => array('admin','manager','editingteacher','teacher','coursecreator','student','user'),
			'course' => true,
			'icon' => 'fa fa-book',
			'text' => get_string('fulllistofcourses'),
			'link' =>  new moodle_url($CFG->wwwroot . '/course/')
		),
		'frontpage' => array(
			'access' => array('admin','manager','editingteacher','teacher','coursecreator','student','user'),
			'course' => true,
			'shown' => !$isfp,
			'icon' => 'fa fa-home',
			'text' => get_string('sitehome'),
			'link' => new moodle_url($CFG->wwwroot . '/?redirect=0')
		),
      'editfrontpage' => array(
			'access' => array('admin','manager'),
         	'course' => true,
			'shown' => $isfp,
			'icon' => 'fa fa-edit',
			'text' => $fpedit_string,
			'link' => new moodle_url($CFG->wwwroot . '/course/view.php',array('id'=>$COURSE->id,'sesskey'=>$USER->sesskey,'edit'=>$fpedit))
		),
		'turneditingcourse' => array(
			'access' => array('admin','manager','editingteacher'),
			'course' => ($isCourse || $isfp),
			'icon' => theme_mb2mcl_site_menu_turnediting_text(true),
			'text' => theme_mb2mcl_site_menu_turnediting_text(),
			'link' => theme_mb2mcl_site_menu_turnediting_url()
		),
		'buildfrontpage' => array(
			'access' => array('admin','manager'),
         	'course' => true,
			'shown' => $ispb,
			'icon' => 'fa fa-columns',
			'text' => get_string('frontpagebuilder','theme_mb2mcl'),
			'link' => new moodle_url($CFG->wwwroot . '/admin/settings.php',array('section'=>'local_mb2builder_builder'))
		),
		'managecoursesandcats' => array(
			'access' => array('admin','manager'),
         	'course' => true,
			'shown' => $showmanage,
			'icon' => 'fa fa-cogs',
			'text' => get_string('coursemgmt','admin'),
			'link' => new moodle_url($CFG->wwwroot . '/course/management.php',array())
		),
		'dashboard' => array(
			'access' => array('admin','manager','editingteacher','teacher','coursecreator','student','user'),
			'course' => true,
			'shown' => $isds,
			'icon' => 'fa fa-tachometer',
			'text' => get_string('myhome'),
			'link' => new moodle_url($CFG->wwwroot . '/my')
		)
	);

	return $items;


}



/*
 *
 * Method to display site menu item
 *
 *
 */
function theme_mb2mcl_get_category()
{

	global $CFG;
	if (!theme_mb2mcl_moodle_from(2018120300))
	{
		require_once($CFG->libdir . '/coursecatlib.php');
	}
	$category = 0;


	if (!has_capability('moodle/course:changecategory', context_system::instance()))
	{
		if (theme_mb2mcl_moodle_from(2018120300))
		{
			$category = core_course_category::get($CFG->defaultrequestcategory, IGNORE_MISSING, true);
		}
		else
		{
			$category = coursecat::get($CFG->defaultrequestcategory, IGNORE_MISSING, true);
		}
	}


	if (!$category) {

		if (theme_mb2mcl_moodle_from(2018120300))
		{
			$category = core_course_category::get_default();
		}
		else
		{
			$category = coursecat::get_default();
		}
	}


	return $category;


}







/*
 *
 * Method to set course editing link
 *
 */
function theme_mb2mcl_site_menu_turnediting_url()
{

	global $CFG, $COURSE, $USER, $PAGE;

	if ( isset($USER->gradeediting[$COURSE->id]) && $PAGE->pagetype === 'grade-report-grader-index' )
	{
		return new moodle_url( 'index.php', array('id' => $COURSE->id, 'sesskey'=> sesskey(), 'plugin' => 'grader',
		'edit'=> $USER->gradeediting[$COURSE->id] ? 0 : 1 ) );
	}
	else
	{
		return new moodle_url( $CFG->wwwroot . '/course/view.php', array('id'=>$COURSE->id, 'sesskey'=> sesskey(),
		'edit'=> $PAGE->user_is_editing() ? 'off' : 'on', 'return'=> $PAGE->url->out_as_local_url() ) );
	}

}




/*
 *
 * Method to set course editing text
 *
 */
function theme_mb2mcl_site_menu_turnediting_text( $icon = false )
{

	global $USER, $PAGE, $COURSE;

	$texton = get_string('turneditingon');
	$textoff = get_string('turneditingoff');
	$iconon = 'fa fa-edit';
	$iconoff = 'fa fa-power-off';
	$ifvar = isset($USER->gradeediting[$COURSE->id]) && $PAGE->pagetype === 'grade-report-grader-index' ? $USER->gradeediting[$COURSE->id] : $PAGE->user_is_editing();

	if ( $icon )
	{
		return $ifvar ? $iconoff : $iconon;
	}
	else
	{
		return $ifvar ? $textoff : $texton;
	}

}
