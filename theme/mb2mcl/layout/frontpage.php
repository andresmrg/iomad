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

$sidePre = theme_mb2mcl_isblock($PAGE, 'side-pre');
$sidePost = theme_mb2mcl_isblock($PAGE, 'side-post');
$sidebarPos = theme_mb2mcl_theme_setting($PAGE, 'sidebarpos', 'classic');
$sidebars = theme_mb2mcl_theme_setting($PAGE, 'fpsidebars');
$builder = get_config('local_mb2builder');
$builderfptext = isset($builder->builderfptext) ? json_decode($builder->builderfptext) : array();
$builder_pos = 'after';
$sidebar = ($sidePre || $sidePost);
$contentCol = 'col-md-12';
$sidePreCol = 'col-md-3';
$sidePostCol = 'col-md-3';

if ($sidePre && $sidePost)
{
	$contentCol = 'col-md-6';

	if ($sidebarPos === 'classic')
	{
		$contentCol .= ' order-2';
		$sidePreCol .= ' order-1';
		$sidePostCol .= ' order-3';
	}
	elseif ($sidebarPos === 'left')
	{
		$contentCol .= ' order-3';
		$sidePreCol .= ' order-1';
		$sidePostCol .= ' order-2';
	}

}
elseif ($sidePre || $sidePost)
{
	$contentCol = 'col-md-9';

	if ($sidebarPos === 'classic')
	{
		$contentCol .= ' order-2';
		$sidePreCol .= ' order-1';
		$sidePostCol .= ' order-3';
	}
	elseif ($sidebarPos === 'left')
	{
		$contentCol .= ' order-3';
		$sidePreCol .= ' order-1';
		$sidePostCol .= ' order-2';
	}
}


?>
<?php echo $OUTPUT->theme_part('head'); ?>
<?php echo $OUTPUT->theme_part('header'); ?>
<?php //echo $OUTPUT->theme_part('region_slider'); ?>
<?php echo theme_mb2mcl_slider(); ?>
<?php echo theme_mb2mcl_notice(); ?>
<?php echo $OUTPUT->theme_part('site_menu'); ?>
<?php if ($builder_pos === 'before') : ?>
	<?php echo theme_mb2mcl_page_builder_content($builderfptext); ?>
<?php endif; ?>
<div id="main-content">
<div class="section-inner">
    <div class="container-fluid">
        <div class="row">
            <section id="region-main" class="content-col <?php echo $contentCol; ?>">
                <div id="page-content">
					<?php if (theme_mb2mcl_frontpage_courses() && theme_mb2mcl_theme_setting($PAGE, 'courseswitchlayout')) : ?>
						<?php echo theme_mb2mcl_course_layout_switcher(); ?>
					<?php endif; ?>
					<?php if (is_siteadmin()): ?>
						<?php echo theme_mb2mcl_check_plugins(); ?>
                    <?php endif; ?>
                	<?php echo $OUTPUT->course_content_header(); ?>
					<?php if (theme_mb2mcl_isblock($PAGE, 'content-top')) : ?>
                		<?php echo $OUTPUT->blocks('content-top', theme_mb2mcl_block_cls($PAGE, 'content-top','none')); ?>
             		<?php endif; ?>
                	<?php echo $OUTPUT->main_content(); ?>
                    <?php if (theme_mb2mcl_isblock($PAGE, 'content-bottom')) : ?>
                		<?php echo $OUTPUT->blocks('content-bottom', theme_mb2mcl_block_cls($PAGE, 'content-bottom','none')); ?>
             		<?php endif; ?>
                    <?php echo theme_mb2mcl_moodle_from(2017111300) ? $OUTPUT->activity_navigation() : ''; ?>
                	<?php echo $OUTPUT->course_content_footer(); ?>
                </div>
            </section>
     		<?php if ($sidePre) : ?>
            	<div class="sidebar-col <?php echo $sidePreCol; ?>">
                	<?php echo $OUTPUT->blocks('side-pre', theme_mb2mcl_block_cls($PAGE, 'side-pre')); ?>
                </div>
       		<?php endif; ?>
     		<?php if ($sidePost) : ?>
            	<div class="sidebar-col <?php echo $sidePostCol; ?>">
                	<?php echo $OUTPUT->blocks('side-post', theme_mb2mcl_block_cls($PAGE, 'side-post')); ?>
                </div>
        	<?php endif; ?>
        </div>
    </div>
</div>
</div>
<?php if ($builder_pos === 'after') : ?>
	<?php echo theme_mb2mcl_page_builder_content($builderfptext); ?>
<?php endif; ?>
<?php echo theme_mb2mcl_moodle_from(2018120300) ? $OUTPUT->standard_after_main_region_html() : '' ?>
<?php echo $OUTPUT->theme_part('bottom_info'); ?>
<?php echo $OUTPUT->theme_part('region_bottom_abcd'); ?>
<?php echo $OUTPUT->theme_part('footer_info'); ?>
<?php echo $OUTPUT->theme_part('footer', array('sidebar'=>$sidebar)); ?>
<?php echo $OUTPUT->theme_part('region_adminblock'); ?>
