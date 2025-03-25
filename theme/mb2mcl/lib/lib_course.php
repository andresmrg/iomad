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
 * Method to get course banner
 *
 */
function theme_mb2mcl_course_banner()
{

	global $CFG, $COURSE, $PAGE, $OUTPUT;

	$output = '';
	$banner = theme_mb2mcl_theme_setting( $PAGE, 'banner' );
	$course_image = theme_mb2mcl_course_image_url( $COURSE->id );
	$imgurl = '';

	if ( $course_image )
	{
		$imgurl = $course_image;
	}
	elseif ( $banner )
	{
		$bannerimages = theme_mb2mcl_get_fileareaimages( 'bannerimg' );

		if ( count( $bannerimages ) > 0 )
		{
			$key = array_rand( $bannerimages, 1 );
			$imgurl = $bannerimages[$key];
		}
		else
		{
			$imgurl = $OUTPUT->image_url('header-defult','theme');
		}
	}

	if ( ! $imgurl )
	{
		return;
	}

	$cls = ' isimage';
	$banner_style = ' style="background-image:url(\'' . $imgurl  . '\');"';

	$output .= '<div class="theme-banner' . $cls . '"' . $banner_style . '>';
	$output .= '</div>';

	return $output;

}





/*
 *
 * Method to get image from course summary files
 *
 */
function theme_mb2mcl_course_image_url( $courseid = null )
{
	global $CFG, $PAGE;

	$iscourse = ( $courseid > 1 );

	if ( ! $courseid || ! theme_mb2mcl_theme_setting( $PAGE, 'cbannerimg' ) || ! $iscourse )
	{
		return;
	}

	require_once( $CFG->libdir . '/filelib.php' );

	$url = '';
	$context = context_course::instance( $courseid );
	$fs = get_file_storage();
	$files = $fs->get_area_files( $context->id, 'course', 'overviewfiles', 0 );

	foreach ( $files as $f )
	{
		if ( $f->is_valid_image() )
		{
			$url = moodle_url::make_pluginfile_url(
				$f->get_contextid(), $f->get_component(), $f->get_filearea(), null, $f->get_filepath(), $f->get_filename(), false );
		}
	}

	return $url;

}





/*
 *
 * Method to set block class
 *
 *
 */
function theme_mb2mcl_page_cls($page, $course = false)
{

	$output = '';

	$isPage = $page->pagetype === 'mod-page-view';

	if ( ! isset( $page->cm->id ) )
	{
		return;
	}

	if ($course)
	{
		$pageId = $isPage ? $page->course->id : 0;
		$output .= theme_mb2mcl_line_classes(theme_mb2mcl_theme_setting($page, 'coursecls'), $pageId);
	}
	else
	{
		$pageId = $isPage ? $page->cm->id : 0;
		$output .= theme_mb2mcl_line_classes(theme_mb2mcl_theme_setting($page, 'pagecls'), $pageId);
	}


	return $output;

}







/*
 *
 * Method to set block class
 *
 *
 */
function theme_mb2mcl_course_cls($page)
{

	$output = '';

	$output .= theme_mb2mcl_line_classes(theme_mb2mcl_theme_setting($page, 'coursescls'), $page->course->id);

	return $output;

}





/*
 *
 * Method to set body class for course category theme
 *
 */
function theme_mb2mcl_courselist_cls($page)
{

	$output = '';

	$isCourse = $page->pagetype === 'course-index';
	$isCourseCat = $page->pagetype === 'course-index-category';
	$catId = ($isCourseCat && isset($page->category->id)) ? $page->category->id : 0;
	$clsPreff = 'coursetheme-';

	if ($catId > 0)
	{
		$output .= $clsPreff . theme_mb2mcl_line_classes(theme_mb2mcl_theme_setting($page, 'coursecattheme'), $catId);
	}
	else
	{
		$output .= $clsPreff . theme_mb2mcl_theme_setting($page, 'coursetheme');
	}

	return $output;

}






/*
 *
 * Method to get activity header in Moodle 4
 *
 */
function theme_mb2mcl_activityheader()
{
	global $CFG, $PAGE;

	$output = '';

	// Only for Moodle 4+
	if ( $CFG->version < 2022041900 )
	{
		return;
	}

	$header = $PAGE->activityheader;
	$headercontent = $header->export_for_template($PAGE->get_renderer('core'));

	$output .= '<span id="maincontent"></span>';
	
	if ( isset( $headercontent['title'] ) && $headercontent['title'] )
	{
		$output .= '<h2 class="activity-name">' . $headercontent['title'] . '</h2>';
	}

	$output .= '<div class="activity-header" data-for="page-activity-header">';

	if ( isset( $headercontent['completion'] ) && $headercontent['completion'] )
	{
		$output .= '<span class="sr-only">' . get_string('overallaggregation', 'completion') . '</span>';
		$output .= $headercontent['completion'];
	}

	if ( isset( $headercontent['description'] ) && $headercontent['description'] )
	{
		$output .= $headercontent['description'];
	}

	if ( isset( $headercontent['additional_items'] ) && $headercontent['additional_items'] )
	{
		$output .= $headercontent['additional_items'];
	}

	$output .= '</div>'; // activity-header

	return $output;

}



/*
 *
 * Method to get course sections array
 *
 */
function theme_mb2mcl_get_course_sections( $ccourse = false, $sectionid = 0, $onlyvisible = false )
{
	global $CFG, $COURSE;

    $csections = [];
    $courseobj = $ccourse ? $ccourse : $COURSE;
    $iscourse = $courseobj->id > 1;
    $coursecontext = context_course::instance($courseobj->id);

    if (!$iscourse) {
        return $csections;
    }

    $modinfo = get_fast_modinfo($courseobj);
    $sections = $modinfo->get_section_info_all();
    $viewhidden = has_capability('moodle/course:viewhiddensections', $coursecontext);

    foreach ($sections as $section) {
        if (( !$section->visible && !$viewhidden && !$onlyvisible ) || !$section->sequence || ($sectionid > 0 && $sectionid
        != $section->id)) {
            continue;
        }

        $sectionsarr = [
            'num' => $section->section,
            'id' => $section->id,
            'visible' => $section->visible,
            'name' => get_section_name($courseobj, $section),
            'notavailable' => !$section->visible && !$viewhidden ? get_string('notavailable') : 0,
            // Get avalibility info to hide section modules on TOC,
            // and hide whole section on enrolment page.
            'availableinfo' => !empty($section->availableinfo),
            // Subsections.
            'subsections' => [],
        ];

        $csections[$section->id] = $sectionsarr;

        // Subsection for Moodle 4.5+.
        if ($CFG->version >= 2024100700) {
            if ($sectiondelegated = $section->get_component_instance()) {
                unset($csections[$section->id]);

                if ($parentsection = $sectiondelegated->get_parent_section()) {
                    $csections[$parentsection->id]['subsections'][] = $sectionsarr;
                }
            }
        }
    }

    return $csections;

}



/*
 *
 * Method to get section activities
 *
 */
function theme_mb2mcl_get_section_activities( $sectionid = 0, $label = false, $onlyvisible = false, $onlyuservisible = true )
{

	global $CFG, $OUTPUT, $COURSE;

	$coursecontext = context_course::instance($COURSE->id);
	$viewhidden = has_capability( 'moodle/course:viewhiddenactivities', $coursecontext );
    $modinfo = get_fast_modinfo( $COURSE );
    $modules = array();

	foreach ( $modinfo->cms as $cm )
	{

		if ( $sectionid !== false && $cm->section != $sectionid )
		{
			continue;
		}

        if ( ! $cm->visible && ! $viewhidden )
		{
            continue;
        }

		if ( $onlyuservisible && ! $cm->uservisible )
		{
            continue;
        }

		if ( $cm->deletioninprogress )
		{
			continue;
		}

		$mod = array();
		$archetype = plugin_supports('mod', $cm->modname, FEATURE_MOD_ARCHETYPE, MOD_ARCHETYPE_OTHER);

		$mod['id'] = $cm->id;
		$mod['name'] = $cm->name;
		$mod['modname'] = $cm->modname;
		$mod['icon'] = $OUTPUT->image_url( 'icon', $cm->modname );
		$mod['url'] = $cm->url;
		$mod['section'] = $cm->section;
		$mod['visible'] = $cm->visible;
		$mod['uservisible'] = $cm->uservisible;
		$mod['issubsection'] = ($cm->modname === 'subsection');

		if ( $archetype == MOD_ARCHETYPE_RESOURCE )
		{
			$mod['isresource'] = 1;
		}
		else
		{
			$mod['isresource'] = 0;
		}

		$modules[] = $mod;
    }

    return $modules;

}




/*
 *
 * Method to get section complete percentage
 *
 */
function theme_mb2mcl_section_complete( $section, $iscomplete = false )
{
	global $COURSE, $USER;

	$total = 0;
	$complete = 0;
	$modinfo = get_fast_modinfo( $COURSE );
	$completioninfo = new completion_info( $COURSE );
	$cancomplete = isloggedin() && ! isguestuser();

	if ( ! $cancomplete || ! $completioninfo->is_tracked_user( $USER->id ) )
	{
		return false;
	}

	foreach ( $modinfo->sections[$section] as $cmid )
	{
		$thismod = $modinfo->cms[$cmid];

		if ($thismod->uservisible)
		{
			if ( $cancomplete && $completioninfo->is_enabled($thismod) != COMPLETION_TRACKING_NONE )
			{
				$total++;
				$completiondata = $completioninfo->get_data($thismod, true);
				if ( $completiondata->completionstate == COMPLETION_COMPLETE || $completiondata->completionstate == COMPLETION_COMPLETE_PASS )
				{
					$complete++;
				}
			}
		}
	}

	if ( $iscomplete && $total > 0 && $total == $complete )
	{
		return true;
	}

	if ( ! $iscomplete && $total > 0 )
	{
		return round( ($complete/$total) * 100, 2 );
	}

	return false;

}



/*
 *
 * Method to get section activities
 *
 */
function theme_mb2mcl_section_module_list( $sectionid, $link = false, $active = false, $visible = false, $uservisible = true, $sectionnum = -1 )
{
	global $COURSE;
    $output = '';
    $modules = theme_mb2mcl_get_section_activities($sectionid, true, $visible, $uservisible);
    $sections = theme_mb2mcl_get_course_sections();
    $section = $sections[$sectionid];
    $subsectioncounter = 0;
    $coursecontext = context_course::instance($COURSE->id);
    $viewhidden = has_capability('moodle/course:viewhiddensections', $coursecontext);

    // Check for available info. Hide items if users can't see it.
    $sectionavailableinfo = $section['availableinfo'];
    $sectionnotavailable = $section['notavailable'];

    if (!count($modules) || (!$viewhidden && $sectionavailableinfo) || $sectionnotavailable) {
        if ($sectionnotavailable) {
            return '<span class="info d-block pt-3 pb-3"><i class="ri-information-line"></i> ' .
            get_string('notavailable') . '</span>';
        } else if (!$viewhidden && $sectionavailableinfo) {
            return '<span class="info d-block pt-3 pb-3"><i class="ri-information-line"></i> ' .
            get_string('accessrestrictions', 'availability') . '</span>';
        } else {
            return '<span class="info d-block pt-3 pb-3"><i class="ri-information-line"></i> ' .
            get_string('nothingtodisplay') . '</span>';
        }
    }

    $output .= '<ul class="section-modules">';

    foreach ($modules as $k => $m) {

        // Hide label module on course nerolment page
        // On this page the $link is set to FALSE
        if (!$link && $m['modname'] === 'label') {
            continue;
        }

        if ($m['issubsection'] && isset($sections[$sectionid]['subsections'][$subsectioncounter])) {

            $subsection = $sections[$sectionid]['subsections'][$subsectioncounter];
            $submodules = theme_mb2mcl_get_section_activities($subsection['id'], $uservisible, false, $COURSE);
            $subsectionavailableinfo = $subsection['availableinfo'];
            $completepercentage = theme_mb2mcl_section_complete($subsection['num']);
            $hiddencls = '';
            $hiddenicon = '';

            if (!$subsection['visible']) {
                $hiddencls = ' hiddensection';
                $hiddenicon .= '<span class="hiddenicon" aria-hidden="true"><i class="fa fa-eye-slash"></i></span>';
                $hiddenicon .= '<span class="sr-only">' . get_string('hiddenfromstudents') . '</span>';
            }

            $sname = empty($subsection['name']) ? get_string('section') : $subsection['name'];

            $output .= '<li class="coursetoc-subsection-listitem">';

            $output .= '<div class="coursetoc-subsection coursetoc-section-' . $subsection['num'] . '"
            data-sid="' . $subsection['id'] . '">';
            $output .= '<div class="coursetoc-subsection-tite">';
            $output .= '<button type="button" class="coursetoc-subsection-toggle themereset" aria-controls="coursetoc-subsection-modules-'
            . $subsection['id'] . '" aria-label="' . $subsection['name'] . '">';
            $output .= '<span class="toggle-icon"></span>';
            $output .= '<span class="title-text">' . $subsection['name'] . $hiddenicon . '</span>';
            $output .= $completepercentage !== false ? '<span class="title-complete">(' . $completepercentage . '%)</span>' : '';
            $output .= '</button>';
            $output .= '</div>';
            $output .= '<div id="coursetoc-subsection-modules-' . $subsection['id'] . '" class="coursetoc-subsection-modules">';

            // Check for submodules and section availability info info. Hide items if users can't see it.
            if (!count($submodules) || (!$viewhidden && $subsectionavailableinfo)) {
                if (!$viewhidden && $subsectionavailableinfo) {
                    $output .= '<span class="info d-block pt-3"><i class="ri-information-line"></i> ' .
                    get_string('accessrestrictions', 'availability') .
                    '</span>';
                } else { // No submodules.
                    $output .= '<span class="info d-block pt-3"><i class="ri-information-line"></i> ' .
                    get_string('nothingtodisplay') . '</span>';
                }
            } else if (count($submodules)) {
                $output .= '<ul class="subsection-modules">';
                foreach ($submodules as $k => $subm) {
                    $output .= theme_mb2mcl_section_module_list_item($subm, $link, $sectionnum, $subsection['id']);
                }
                $output .= '</ul>';
            }

            $output .= '</div>';
            $output .= '</div>';
            $output .= '</li>';

            $subsectioncounter++;

        } else if (!$m['issubsection']) {
            $output .= theme_mb2mcl_section_module_list_item($m, $link, $sectionnum, $sectionid);
        }

    }

    $output .= '</ul>';

    return $output;

}



/**
 *
 * Method to get module list item
 *
 */
function theme_mb2mcl_section_module_list_item($m, $link, $sectionnum, $sectionid) {

    global $PAGE;
    $output = '';

    $linktag = !$m['uservisible'] ? false : $link;
    $modlink = theme_mb2mcl_activityurl($m['url'], $m['id'], $sectionnum, $sectionid);
    $modcomplete = theme_mb2mcl_module_complete($m['id']) ? ' complete' . theme_mb2mcl_module_complete($m['id']) : '';
    $hiddenicon = '';
    $hiddencls = '';

    if (!$m['visible']) {
        $hiddencls = ' hiddenmodule';
        $hiddenicon .= '<span class="hiddenicon" aria-hidden="true"><i class="fa fa-eye-slash"></i></span>';
        $hiddenicon .= '<span class="sr-only">' . get_string('hiddenfromstudents') . '</span>';
    }

    $output .= '<li class="module-' . $m['modname'] . $modcomplete . $hiddencls . '" data-cmid="' . $m['id'] . '">';
    $output .= $linktag ? '<a href="' . $modlink . '">' : '';
    $output .= '<span class="itemimage" aria-hidden="true"><img class="activityicon" src="' . $m['icon'] . '" alt="' . $m['name'] .
    '"></span>';
    $output .= '<span class="itemname">' . $m['name'] . $hiddenicon . '</span>';
    $output .= $linktag ? '</a>' : '';
    $output .= '</li>';


    return $output;

}



/*
 *
 * Method to get activity header in Moodle 4
 *
 */
function theme_mb2mcl_activityurl($url = '', $id = 0, $snum = -1, $sid = 0)
{
	global $CFG, $COURSE, $PAGE;

	$opts = theme_mb2mcl_format_opts();
	$m44 = $CFG->version >= 2024042200;

	// If there is section drop down, We have to back to current section and then scroll to module iD
	$sectionnum = ( theme_mb2mcl_is_module_context() && is_object( $PAGE->cm ) && $PAGE->cm->sectionnum ) ? $PAGE->cm->sectionnum : 0;

	if ( $snum > -1)
	{
		$sectionnum = $snum;
	}

	// Check for activities or resources without URL
	if ( ! $url )
	{
		if ( isset($opts['coursedisplay']) && $opts['coursedisplay'] == 1 )
		{
			if ( ! $m44 )
			{
				return new moodle_url('/course/view.php',array('id'=>$COURSE->id,'section'=>$sectionnum)) . '#module-' . $id;
			}
			
			return new moodle_url('/course/section.php',array('id'=>$sid)) . '#module-' . $id;
		}
		elseif ( theme_mb2mcl_is_cmainpage() )
		{
			return '#module-' . $id;
		}
		else 
		{
			return new moodle_url('/course/view.php',array('id'=>$COURSE->id)) . '#module-' . $id;
		}
	}

	return new moodle_url($url, array('forceview'=>1));

}





/*
 *
 * Method to get course format settings
 *
 */
function theme_mb2mcl_format_opts()
{

	global $COURSE;

	// Get course settings
	$format = course_get_format($COURSE);
	$options = $format->get_format_options();

	return $options;

}




/*
 *
 * Method to check if is course main page
 *
 */
function theme_mb2mcl_is_cmainpage()
{
	global $PAGE;

	if ( $PAGE->pagelayout === 'course' && ! theme_mb2mcl_is_section() )
	{
		return true;
	}

	return false;

}





/*
 *
 * Method to to check if current page is a course section
 *
 */
function theme_mb2mcl_is_section()
{
	
	global $PAGE, $COURSE;

	$snu = optional_param('section', 0, PARAM_INT);

	if ( theme_mb2mcl_is_course() && ($snu || preg_match('@section-@', $PAGE->pagetype )) )
	{
		return true;
	}

	return false;

}







/*
 *
 * Method to check if there is course ID
 *
 */
function theme_mb2mcl_is_course()
{
	
	global $COURSE, $SITE;

	if ( $COURSE && $COURSE->id != $SITE->id )
	{
		return true;
	}

	return false;

}




/*
 *
 * Method to check if toc appears
 *
 */
function theme_mb2mcl_is_toc()
{
	global $PAGE, $COURSE, $SITE;

	$coursetoc = theme_mb2mcl_theme_setting($PAGE, 'coursetoc');
	$sections = theme_mb2mcl_get_course_sections();
	$ismodule = theme_mb2mcl_is_module_context();
	$editing = $PAGE->user_is_editing();

	if ( $COURSE->format === 'singleactivity' || ! $coursetoc || ! count($sections) || $COURSE->id == $SITE->id || $editing )
	{
		return false;
	}

	if ( $ismodule || preg_match( '@course-view@', $PAGE->pagetype ) )
	{
		return true;
	}

	if ( theme_mb2mcl_is_section() )
	{
		return true;
	}

	return false;

}





/*
 *
 * Method to get course sections
 *
 */
function theme_mb2mcl_module_sections( $block = false )
{
	global $CFG, $PAGE;
	$output = '';

	$sections = theme_mb2mcl_get_course_sections();
	$blockstyle = 'default';

	if ( $block )
	{
		$output .= '<div class="style-' . $blockstyle . '">';
		$output .= '<div class="block block_coursetoc">';
		$output .= '<h5 class="header">' . get_string('coursetoc', 'theme_mb2mcl') . '</h5>';

		$output .= '<div class="coursetoc-tool"><button type="button" class="themereset coursetoc-toggleall collapsed" data-collapseall="' .
			get_string('collapseall') . '" data-expandall="' . get_string('expandall') . '">' . get_string('expandall') . '</button></div>';
		$PAGE->requires->js_call_amd( 'theme_mb2mcl/toc', 'toggleAll' );
	}

	$output .= '<div class="coursetoc-sectionlist">';

	foreach ( $sections as $section )
	{
		$modules = theme_mb2mcl_get_section_activities( $section['id'] );

		if ( ! count( $modules ) )
		{
			continue;
		}

		$completepercentage = theme_mb2mcl_section_complete( $section['num'] );
		$iscomplete = theme_mb2mcl_section_complete( $section['num'], true );
		$completecls =  $iscomplete ? ' complete' : '';
		$hiddencls = '';
		$hiddenicon = '';
		$isactive = '';

		if ( (is_object( $PAGE->cm ) && $PAGE->cm->section == $section['id']) || theme_mb2mcl_section_active($section) )
		{
			$isactive = ' active';
		}

		if ( ! $section['visible'] )
		{
			$hiddencls = ' hiddensection';
			$hiddenicon .= '<span class="hiddenicon" aria-hidden="true"><i class="fa fa-eye-slash"></i></span>';
			$hiddenicon .= '<span class="sr-only">' . get_string('hiddenfromstudents') . '</span>';
		}

		$output .= '<div class="coursetoc-section coursetoc-section-' . $section['num'] . $completecls . $isactive . $hiddencls . '" data-id="' . $section['id'] . '">';
		$output .= '<div class="coursetoc-section-tite">';
		$output .= '<button type="button" class="coursetoc-section-toggle themereset" aria-controls="coursetoc-section-modules-' . $section['id'] . '" aria-label="' . $section['name'] . '">';
		$output .= '<span class="toggle-icon"></span>';
		$output .= '<span class="title-text">' . $section['name'] . $hiddenicon . '</span>';
		$output .= $completepercentage !== false ? '<span class="title-complete">(' . $completepercentage . '%)</span>' : '';
		$output .= '</button>';
		$output .= '</div>'; //coursetoc-section-tite
		$output .= '<div id="coursetoc-section-modules-' . $section['id'] . '" class="coursetoc-section-modules">';
		$output .= theme_mb2mcl_section_module_list( $section['id'], true, true, true, $section['num'] );
		$output .= '</div>'; //coursetoc-section-modules
		$output .= '</div>'; //coursetoc-section
	}

	$output .= '</div>'; // coursetoc-sectionlist

	if ( $block )
	{
		$output .= '</div>'; // block block_coursetoc
		$output .= '</div>'; // block
	}

	$PAGE->requires->js_call_amd( 'theme_mb2mcl/toc', 'courseToc' );

	return $output;

}





/*
 *
 * Method to to check if current page is a course section
 *
 */
function theme_mb2mcl_section_active($section)
{
	global $CFG;

	if ( ! theme_mb2mcl_is_section() )
	{
		return;
	}

	$m44 = $CFG->version >= 2024042200;
	$snu = optional_param('section', 0, PARAM_INT);
	$sid = optional_param('id', 0, PARAM_INT);

	// Old Moodle versions < 4.4
	if ( ! $m44 && $section['num'] == $snu )
	{
		return true;
	}
	elseif( $m44 && $section['id'] == $sid )
	{
		return true;
	}

	return;

}




/*
 *
 * Method to check if module is complete
 *
 */
function theme_mb2mcl_module_complete( $mod )
{
	global $COURSE, $USER;
	$completioninfo = new completion_info( $COURSE );
	$cancomplete = isloggedin() && ! isguestuser();
	$modinfo = get_fast_modinfo( $COURSE );
	$thismod = $modinfo->cms[$mod];

	if ( ! $cancomplete || ! $completioninfo->is_tracked_user( $USER->id ) )
	{
		return;
	}

	if ( $thismod->uservisible )
	{
		if ( $cancomplete && $completioninfo->is_enabled($thismod) != COMPLETION_TRACKING_NONE )
		{
			$completiondata = $completioninfo->get_data($thismod, true);

			if ( $completiondata->completionstate == COMPLETION_COMPLETE || $completiondata->completionstate == COMPLETION_COMPLETE_PASS )
			{
				return 1;
			}
			else
			{
				return -1;
			}
		}
	}

	return 2;

}
