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
global $THEME;

$customLoginPage = theme_mb2mcl_is_login($PAGE, true);
$socilaTt = theme_mb2mcl_theme_setting($PAGE, 'socialtt', 0) == 1 ? 'top' : '';
$isPageBg = theme_mb2mcl_pagebg_image($PAGE);
$menuPos = 1;

?>
<body <?php echo $OUTPUT->body_attributes(theme_mb2mcl_body_cls($PAGE)) . $isPageBg; ?>>
<?php echo $OUTPUT->standard_top_of_body_html(); ?>
<?php if (theme_mb2mcl_theme_setting($PAGE, 'loadingscr',0) == 1) : ?>
	<?php echo theme_mb2mcl_loading_screen($PAGE); ?>
<?php endif; ?>
<div id="page-outer">
<div id="page"<?php echo theme_mb2mcl_ajax_data_atts();?>>
<?php if ($customLoginPage) : ?>
	<?php echo $OUTPUT->theme_part('logo'); ?>
<?php else : ?>
	<div id="page-a">
		<?php if (theme_mb2mcl_theme_setting($PAGE,'topinfo') || theme_mb2mcl_theme_setting($PAGE,'socialheader') || theme_mb2mcl_theme_setting($PAGE,'fontsizer')) : ?>
			<div id="top-panel">
		    	<div class="container-fluid">
		        	<div class="row">
		            	<div class="col-md-12">
		                    <?php if (theme_mb2mcl_theme_setting($PAGE,'topinfo')) : ?>
		                        <div class="top-info-content">
		                            <?php echo theme_mb2mcl_static_content(theme_mb2mcl_theme_setting($PAGE,'topinfo')); ?>
		                        </div>
							<?php endif; ?>
		                    <?php if (theme_mb2mcl_theme_setting($PAGE,'socialheader')) : ?>
		                        <?php echo theme_mb2mcl_social_icons($PAGE,array('ttpos'=>'bottom')); ?>
		                    <?php endif; ?>
							<?php echo theme_mb2mcl_userfriendly_el(); ?>
		        		</div>
		 			</div>
				</div>
		    </div>
		<?php endif; ?>
	    <?php if ( theme_mb2mcl_theme_setting( $PAGE, 'stickyheader' ) ) : ?>
	    	<div class="sticky-header-element-offset"></div>
	    <?php endif; ?>
	    <div id="main-header">
			<div class="main-header-inner">
		        <div class="container-fluid">
		            <div class="row">
		                <div class="col-md-12">
							<div class="header-a">
								<div class="menu-bar">
									<div class="menu-bar-inner">
										<a class="show-menu" href="#"><i class="lni-menu"></i></a>
									</div>
								</div>
								<?php echo $OUTPUT->theme_part('logo'); ?>
								<div class="main-nav">
									<?php echo $OUTPUT->custom_menu(); ?>
								</div>
							</div>
							<div class="header-b">
								<div class="header-tools">
									<?php echo theme_mb2mcl_panel_links(); ?>
									<a href="#" class="tools-close"><i class="lni-close"></i></a>
								</div>
								<div class="tools-show">
									<div class="tools-show-inner">
									<a href="#"><i class="lni-more"></i></a>
									</div>
								</div>
							</div>
		                </div>
		            </div>
		        </div>
	    	</div>
		</div>
		<?php echo theme_mb2mcl_notice('top'); ?>
	</div><!-- //end #page-a -->
<?php endif; ?>
<div id="page-b">
