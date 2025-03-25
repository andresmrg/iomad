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
 * @copyright 2017 - 2019 Mariusz Boloz (www.lmsstyle.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */


defined('MOODLE_INTERNAL') || die();



require_once($CFG->dirroot . '/course/renderer.php');



class theme_mb2mcl_core_course_renderer extends core_course_renderer {




	protected function coursecat_coursebox(coursecat_helper $chelper, $course, $additionalclasses = '')
	{

	    global $CFG, $USER;

		if (!isset($this->strings->summary))
		{
            $this->strings->summary = get_string('summary');
        }

        if ($chelper->get_show_courses() <= self::COURSECAT_SHOW_COURSES_COUNT)
		{
            return '';
        }

        if ($course instanceof stdClass)
		{
			if (!theme_mb2mcl_moodle_from(2018120300))
		    {
		        require_once($CFG->libdir. '/coursecatlib.php');
		    }

			if (theme_mb2mcl_moodle_from(2018120300))
		    {
				$course = new core_course_list_element($course);
		    }
		    else
		    {
		        $course = new course_in_list($course);
		    }
        }

      	$content = '';
		$showInfoBox = ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_EXPANDED);
		$summaryContent = $chelper->get_course_formatted_summary($course, array('overflowdiv' => true, 'noclean' => true, 'para' => false));
		$summaryHasP = ($course->has_summary() && theme_mb2mcl_check_for_tags($summaryContent, 'p'));
		$infoCls = $summaryHasP ? ' summaryisp' : ' summarynop';
		$infoCls .= !$course->has_summary() ? ' nosummary' : '';
		$infoCls .= $showInfoBox ? ' noinfobox' : ' collapsed isinfobox';
		$infoCls .= (isset($course->visible) && !$course->visible) ? ' course-hidden' : '';
		$infoCls .= is_enrolled(context_course::instance($course->id), $USER->id, '', true) ? ' mycourse' : ' notmycourse';
		$classes = trim('coursebox clearfix '. $additionalclasses . $infoCls);

		// .coursebox
		$content .= html_writer::start_tag('div', array(
			'class' => $classes,
			'data-courseid' => $course->id,
			'data-type' => self::COURSECAT_TYPE_COURSE,
		));

		// Collapsed course list
        if (!$showInfoBox)
		{
            $nametag = 'div';

			$content .= html_writer::start_tag('div', array('class' => 'info'));

			// Course name
			$coursename = $chelper->get_course_formatted_name($course);
			$coursenamelink = html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)),
			$coursename, array('class' => $course->visible ? '' : 'dimmed'));
			$content .= html_writer::tag($nametag, $coursenamelink, array('class' => 'coursename'));

			// If we display course in collapsed form but the course has summary or course contacts, display the link to the info page.
			$content .= html_writer::start_tag('div', array('class' => 'moreinfo'));

			if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED)
			{
				if ($course->has_summary() || $course->has_course_contacts() || $course->has_course_overviewfiles())
				{
					$url = new moodle_url('/course/info.php', array('id' => $course->id));
					$image = $this->output->pix_icon('i/info', $this->strings->summary);
					$content .= html_writer::link($url, $image, array('title' => $this->strings->summary));

					// Make sure JS file to expand course content is included.
					$this->coursecat_include_js();
				}
			}

			$content .= html_writer::end_tag('div'); // .moreinfo

			// Print enrolmenticons
			$content .= $this->theme_mb2mcl_coursecat_coursebox_enroll_icons($course);

			$content .= html_writer::end_tag('div'); // .info

		} // if $showInfoBox


	   $content .= html_writer::start_tag('div', array('class' => 'content'));
       $content .= $this->coursecat_coursebox_content($chelper, $course);
       $content .= html_writer::end_tag('div'); // .content


        $content .= html_writer::end_tag('div'); // .coursebox


        return $content;

    }





	protected function theme_mb2mcl_coursecat_coursebox_enroll_icons($course)
	{
		$content = '';

		// Print enrolmenticons
		if ($icons = enrol_get_course_info_icons($course))
		{

			$content .= html_writer::start_tag('div', array('class' => 'enrolmenticons'));
			foreach ($icons as $pix_icon)
			{
				$content .= $this->render($pix_icon);
			}

			$content .= html_writer::end_tag('div'); // .enrolmenticons
		}

		return $content;
	}





	protected function theme_mb2mcl_coursecat_coursebox_content_image ($chelper, $url, $course)
	{
		$img = html_writer::empty_tag('img', array('src' => $url, 'alt' => $chelper->get_course_formatted_name($course)));
		$output = html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)), $img);
		return $output;
	}





	protected function coursecat_coursebox_content (coursecat_helper $chelper, $course)
	{

		global $CFG,$PAGE,$OUTPUT,$USER;


        if ($chelper->get_show_courses() < self::COURSECAT_SHOW_COURSES_EXPANDED)
		{
            return '';
        }


		$noCollBox = ($chelper->get_show_courses() >= self::COURSECAT_SHOW_COURSES_EXPANDED);


        if ($course instanceof stdClass) {
			if (!theme_mb2mcl_moodle_from(2018120300))
		    {
		        require_once($CFG->libdir. '/coursecatlib.php');
		    }

			if (theme_mb2mcl_moodle_from(2018120300))
		    {
				$course = new core_course_list_element($course);
		    }
		    else
		    {
		       $course = new course_in_list($course);
		    }
        }


      	$content = '';
		$countFiles =  count($course->get_course_overviewfiles());
		$plcImg = theme_mb2mcl_theme_setting($PAGE, 'courseplimg');
		$courseBtn = theme_mb2mcl_theme_setting($PAGE, 'coursebtn');
		$isFile = ($countFiles > 0 || $plcImg);
		$isContacts = ($course->has_course_contacts() > 0);
		$isCategory = ($chelper->get_show_courses() == self::COURSECAT_SHOW_COURSES_EXPANDED_WITH_CAT);
		$isCourseContent = true; //($course->has_summary() || $isContacts || $isCategory || $courseBtn);

		$contentCls = ($isFile && $isCourseContent) ? ' fileandcontent' : '';
		$content .= html_writer::start_tag('div', array('class' => 'content-inner' . $contentCls));

		// display course overview files
      	$contentimages = $contentfiles = '';

		if ($isFile)
		{

			$content .= html_writer::start_tag('div', array('class' => 'course-media'));

			foreach ($course->get_course_overviewfiles() as $file)
			{

				$isimage = $file->is_valid_image();

				$url = file_encode_url("$CFG->wwwroot/pluginfile.php",
				'/'. $file->get_contextid(). '/'. $file->get_component(). '/'.
				$file->get_filearea(). $file->get_filepath() . $file->get_filename(), !$isimage);


				if ($isimage)
				{
					$contentimages .= $this->theme_mb2mcl_coursecat_coursebox_content_image($chelper, $url,$course);
				}
				else
				{
					$image = $this->output->pix_icon(file_file_icon($file, 24), $file->get_filename(), 'moodle');
					$filename = html_writer::tag('span', $image, array('class' => 'fp-icon')) .
					html_writer::tag('span', $file->get_filename(), array('class' => 'fp-filename'));
					$contentfiles .= html_writer::tag('span', html_writer::link($url, $filename), array('class' => 'coursefile fp-filename-icon'));
				}

			}


			// Course placeholder image
			$moodle33 = 2017051500;


			if ($contentimages == '' && $plcImg)
			{

				if ($CFG->version >= $moodle33)
				{
					$isPlcImg = file_exists($OUTPUT->image_url('course-custom','theme')) ? $OUTPUT->image_url('course-custom','theme') : $OUTPUT->image_url('course-default','theme');
				}
				else
				{
					$isPlcImg = file_exists($OUTPUT->pix_url('course-custom','theme')) ? $OUTPUT->pix_url('course-custom','theme') : $OUTPUT->pix_url('course-default','theme');
				}


				$contentimages .= $this->theme_mb2mcl_coursecat_coursebox_content_image($chelper, $isPlcImg,$course);

			}


			$content .= $contentimages . $contentfiles;

			$content .= $this->course_contacts( $course );
			$content .= html_writer::end_tag('div'); // .course-media

		}


      	// display course summary
      	if ($isCourseContent)
		{

			$content .= html_writer::start_tag('div', array('class' => 'course-content'));


			// Course heading
			$coursename = $chelper->get_course_formatted_name($course);
			$coursenamelink = html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)), $coursename);
			$content .= html_writer::start_tag('div', array('class' => 'course-heading'));
			$content .= html_writer::tag('h3', $coursenamelink, array('class' => 'coursename'));
			$content .= $this->theme_mb2mcl_coursecat_coursebox_enroll_icons($course);
			$content .= html_writer::end_tag('div');


		   if ($course->has_summary())
		  	{
				$content .= html_writer::start_tag('div', array('class' => 'summary'));
				$content .= $chelper->get_course_formatted_summary($course, array('overflowdiv' => true, 'noclean' => true, 'para' => false));
				$content .= html_writer::end_tag('div'); // .summary
			}

			$content .= $this->course_contacts( $course );

			 // display course category if necessary (for example in search results)
			if ($isCategory)
			{

				if (!theme_mb2mcl_moodle_from(2018120300))
			    {
			        require_once($CFG->libdir. '/coursecatlib.php');
			    }

				if (theme_mb2mcl_moodle_from(2018120300))
				{
					$cat = core_course_category::get($course->category, IGNORE_MISSING);
				}
				else
				{
					$cat = coursecat::get($course->category, IGNORE_MISSING);
				}

				if ($cat)
				{

					$content .= html_writer::start_tag('div', array('class' => 'coursecat'));

					$content .= '<strong>' . get_string('category').':</strong> '. html_writer::link(new moodle_url('/course/index.php', array('categoryid' => $cat->id)),
					$cat->get_formatted_name(), array('class' => $cat->visible ? '' : 'dimmed'));

					$content .= html_writer::end_tag('div'); // .coursecat

				}
			}


			// Red more button
			if ($courseBtn && $PAGE->pagetype !== 'enrol-index')
			{
				$coursenamebtnlink = html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)), get_string('entercourse', 'theme_mb2mcl'), array('class' =>'btn btn-primary'));
				$content .= html_writer::tag('div', $coursenamebtnlink, array('class' => 'course-readmore'));
			}



			$content .= html_writer::end_tag('div'); // .course-content

        }





		$content .= html_writer::end_tag('div'); // .content-inner


        return $content;

    }




	protected function course_contacts( $course )
	{
		global $PAGE, $USER;
		$content = '';
		$isContacts = ( $course->has_course_contacts() > 0 );
		$context = context_course::instance($course->id);
		$students = get_role_users(theme_mb2mcl_theme_setting($PAGE,'studentsroleid',5),$context);
		$students_count = count($students);
		$is_student = theme_mb2mcl_is_user_role($course->id,theme_mb2mcl_theme_setting($PAGE,'studentsroleid',5),$USER->id);

		if ( ! $isContacts && ! theme_mb2mcl_theme_setting( $PAGE, 'coursestudentscount') )
		{
			return;
		}

		$content .= html_writer::start_tag( 'ul', array( 'class' => 'teachers') );

		if ( $isContacts )
		{
			foreach ($course->get_course_contacts() as $userid => $coursecontact)
			{
				$name = '<strong>' .$coursecontact['rolename'].':</strong> ' . html_writer::link(new moodle_url('/user/view.php', array('id' => $userid, 'course' => SITEID)), $coursecontact['username']);
				$content .= html_writer::tag('li', $name);
			}
		}

		if ( theme_mb2mcl_theme_setting($PAGE,'coursestudentscount') )
		{
			$students_count_text = $students_count ? $students_count : get_string('nostudentsyet');

			if ( $is_student )
			{
				$students_count = $students_count - 1;
				$students_count_text = get_string('studentsandyou','theme_mb2mcl',array('students'=>$students_count));
			}

			$content .= html_writer::tag('li', '<strong>' . get_string('existingstudents') . ':</strong> ' . $students_count_text);
		}

		$content .= html_writer::end_tag('ul'); // .teachers

		return $content;

	}



}
