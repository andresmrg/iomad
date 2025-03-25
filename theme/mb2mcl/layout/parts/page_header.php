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

$coursemenu = $OUTPUT->context_header_settings_menu();
$modmenu = $OUTPUT->region_main_settings_menu();
$showheadingbuttons = $OUTPUT->page_heading_button();//( ! $coursemenu && $OUTPUT->page_heading_button() );
$cname = format_text( $COURSE->fullname, FORMAT_HTML );

$coursename = $COURSE->id > 1 ? '<h1 class="h4 coursename"><a href="' . new moodle_url( $CFG->wwwroot . '/course/view.php',array( 'id'=> $COURSE->id ) ) . '">' .
theme_mb2mcl_wordlimit( $cname, theme_mb2mcl_theme_setting( $PAGE, 'mcnamelimit', 6 ) ) . '</a></h1>' : '';
?>
<div class="theme-page-heading">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-heading-left">
                    <div class="breadcrumb">
                        <?php echo $OUTPUT->navbar(); ?>
                    </div>
                    <?php echo $coursename; ?>
                </div>
                <div class="page-heading-right">
                    <?php echo theme_mb2mcl_header_actions(); ?>
                    <?php
                        if ( ! theme_mb2mcl_theme_setting( $PAGE, 'coursepanel' ) )
                    	{
                    		if ( $coursemenu || $modmenu )
                    		{
                    			echo $coursemenu . $modmenu;
                    		}
                    	}
                    	if ( $showheadingbuttons )
                    	{
                    		echo $OUTPUT->page_heading_button();
                    	}
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php echo theme_mb2mcl_course_banner(); ?>
</div>
