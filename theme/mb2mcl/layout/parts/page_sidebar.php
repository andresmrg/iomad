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

?>
<div id="page-sidebar">
    <div class="page-sidebar-inner">
        <a href="#" class="close-sidebar" title="<?php echo get_string( 'closebuttontitle' ); ?>"><i class="lni-close"></i></a>
        <div class="sidebar-main-nav sidebar-menu sidebar-nav">
            <?php echo $OUTPUT->custom_menu(); ?>
        </div>
        <?php if ( theme_mb2mcl_is_toc() ) : ?>
            <?php echo theme_mb2mcl_module_sections(true); ?>
        <?php endif; ?>
        <?php if ( theme_mb2mcl_isblock( $PAGE, 'page-sidebar' ) ) : ?>
            <?php echo $OUTPUT->blocks( 'page-sidebar', theme_mb2mcl_block_cls( $PAGE, 'page-sidebar', 'sidebar' ) ); ?>
        <?php endif; ?>
    </div>
</div>
