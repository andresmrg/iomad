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


$isCourse = (isset($COURSE->id) && $COURSE->id > 1);
$course_access = theme_mb2mcl_site_access();
$can_manage = array('admin','manager','editingteacher','teacher');
$course_manage_string = in_array($course_access,$can_manage) ? get_string('coursemanagement','theme_mb2mcl') : get_string('coursedashboard','theme_mb2mcl');
$cname = format_text( $COURSE->fullname, FORMAT_HTML );

if (theme_mb2mcl_theme_setting($PAGE,'coursepanel') && $isCourse && $course_access !== 'none' && $course_access !== 'user') :
?>
<div class="modal fade" id="course-panel" role="dialog" aria-labelledby="course-panel-label">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    		<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="course-panel-label"><?php echo $course_manage_string . ': ' . theme_mb2mcl_wordlimit( $cname ,6 ); ?></h4>
      		</div>
            <div class="course-panel-content">
            <?php if (in_array($course_access,$can_manage)) : ?>
            	<div class="teacher-panel">
                    <div class="container-fluid">
                        <div class="row">
                            <?php if (theme_mb2mcl_is_module_context()) : ?>
                                <div class="col-md-3"><?php echo theme_mb2mcl_course_panel('activities') . theme_mb2mcl_course_panel('badges'); ?></div>
                                <div class="col-md-3"><?php echo theme_mb2mcl_course_panel('modulenav'); ?></div>
                                <div class="col-md-3"><?php echo theme_mb2mcl_course_panel('course_settings') . theme_mb2mcl_course_panel('badges2'); ?></div>
                                <div class="col-md-3"><?php echo theme_mb2mcl_course_panel('students') . theme_mb2mcl_course_panel('students2'); ?></div>
                            <?php else : ?>
                                <div class="col-md-3"><?php echo theme_mb2mcl_course_panel('activities'); ?></div>
                                <div class="col-md-3"><?php echo theme_mb2mcl_course_panel('qbank') . theme_mb2mcl_course_panel('badges'); ?></div>
                                <div class="col-md-3"><?php echo theme_mb2mcl_course_panel('course_settings') . theme_mb2mcl_course_panel('badges2'); ?></div>
                                <div class="col-md-3"><?php echo theme_mb2mcl_course_panel('students') . theme_mb2mcl_course_panel('students2'); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
            	<div class="student-panel-a">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-5"><?php echo theme_mb2mcl_course_panel('course'); ?></div>
                            <div class="col-md-3"><?php echo theme_mb2mcl_course_panel('activities'); ?></div>
                            <div class="col-md-4"><?php echo theme_mb2mcl_course_panel('contacts'); ?></div>
                        </div>
                   	</div>
            	</div>
              	<div class="student-panel-b">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4"><?php echo theme_mb2mcl_course_panel('grade'); ?></div>
                            <div class="col-md-4"><?php echo theme_mb2mcl_course_panel('studentbadges'); ?></div>
                            <div class="col-md-4"><?php echo theme_mb2mcl_course_panel('competencies'); ?></div>
                        </div>
                	</div>
            	</div>
                <?php echo theme_mb2mcl_course_panel('progress'); ?>
            <?php endif; ?>
            </div>
		</div>
	</div>
</div>
<?php endif; ?>
