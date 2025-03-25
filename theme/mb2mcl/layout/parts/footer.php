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

$footThemeContent =  theme_mb2mcl_theme_setting($PAGE, 'foottext');
$footeMenu = theme_mb2mcl_theme_setting($PAGE, 'footmenu');
$footLogin =  theme_mb2mcl_theme_setting($PAGE, 'footlogin', 0);
$footerTools = (is_siteadmin() || $footLogin == 1);
?>
<footer id="footer">
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-md-12">
				<div class="footer-text">
					<p>
						<?php if ( $footThemeContent ) : ?>
							<?php echo format_text( $footThemeContent ); ?>
						<?php else: ?>
							<?php echo '&copy; ' . $SITE->shortname . ' ' . date('Y'). '.'; ?>
						<?php endif; ?>
					</p>
				</div>
				<?php if ($footeMenu) : ?>
					<div class="footer-menu">
						<?php echo theme_mb2mcl_static_content($footeMenu); ?>
					</div>
				<?php endif; ?>
	           </div>
		   </div>
	</div>
	<?php if ( $footerTools ) : ?>
	<div class="system-footer">
	    <div class="container-fluid">
	    	<div class="row">
	        	<div class="col-md-12">
	           		<div class="footer-tools">
	               		<?php if ($footLogin) : ?>
	                 		<?php echo $OUTPUT->login_info(); ?>
	              		<?php endif; ?>
	                   	<?php if ($OUTPUT->course_footer()) : ?>
	                      	<p id="course-footer"><?php echo $OUTPUT->course_footer(); ?></p>
	                   	<?php endif; ?>
	                  	<?php if ($OUTPUT->page_doc_link()) : ?>
	                       	<p class="helplink"><?php echo $OUTPUT->page_doc_link(); ?></p>
						<?php endif; ?>	                	
						<?php if ( $CFG->version >= 2022041900 ) : ?>
							<?php echo $OUTPUT->debug_footer_html(); ?>
						<?php endif; ?>
	        		</div>
					<?php echo $OUTPUT->standard_footer_html(); ?>
				</div>
			</div>
	    </div>
	</div>
	<?php endif; ?>
</footer>
</div><!-- //end #page-b -->
</div><!-- //end #page -->
<div class="sidebar-overlay"></div>
</div><!-- //end #page-outer -->
<?php echo $OUTPUT->theme_part('page_sidebar'); ?>
<?php echo theme_mb2mcl_iconnav($PAGE); ?>
<?php echo $OUTPUT->theme_part('course_panel'); ?>
<?php if ( theme_mb2mcl_panel_link( 'fixedbar' ) || theme_mb2mcl_show_hide_sidebars( $PAGE, $vars ) ) : ?>
<div class="fixed-bar">
	<?php echo theme_mb2mcl_panel_link( 'fixedbar' ); ?>
	<?php echo theme_mb2mcl_show_hide_sidebars( $PAGE, $vars ); ?>
</div>
<?php endif; ?>
<?php echo $OUTPUT->theme_part('course_panel'); ?>
<?php echo theme_mb2mcl_user_bookmarks_modal(); ?>
<?php if (is_siteadmin()) : ?>
	<?php echo theme_mb2mcl_theme_links(); ?>
<?php endif; ?>
<?php if (theme_mb2mcl_theme_setting($PAGE, 'scrolltt') == 1) :?>
	<?php echo theme_mb2mcl_scrolltt($PAGE); ?>
<?php endif; ?>
<?php echo theme_mb2mcl_php2js(); ?>
<?php echo $OUTPUT->standard_end_of_body_html(); ?>
</body>
</html>
