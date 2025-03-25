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

echo $OUTPUT->doctype();

// Set variables for js
$morelessjs = array('moretext' => get_string('showmore', 'form'), 'lesstext' => get_string('showless', 'form'));
$togglealljs = array('collapseall' => get_string('collapseall'), 'expandall' => get_string('expandall'));
$dataforjs = array_merge($morelessjs, $togglealljs);

$PAGE->requires->data_for_js('mb2mcljs', $dataforjs);

if ( is_siteadmin() )
{
    $PAGE->requires->js_call_amd('theme_mb2mcl/settings','toggleAll');
    $PAGE->requires->js_call_amd('theme_mb2mcl/settings','toggleCat');
}

// Disable secondary navigation in Moodle 4
// New Learning provide custom navigation
if ( $CFG->version >= 2022041900 )
{
    $PAGE->set_secondary_navigation(false);
}

$themeFaicon = theme_mb2mcl_theme_setting($PAGE,'favicon','', true);
$vafIcon = $themeFaicon !='' ? $themeFaicon : $OUTPUT->favicon();

// Get boost theme amd files
$inline_js = 'require([\'theme_boost/loader\']);';
if ( $CFG->version >= 2020061500 && $CFG->version < 2021051700 ) // Moodle 3.9 - 3.10
{
    $inline_js .= 'require([\'jquery\',\'theme_boost/bootstrap/index\'], function($){$(\'[data-toggle="tooltip"]\').tooltip();$(\'[data-toggle="popover"]\').popover()});';
}
elseif ( $CFG->version < 2020061500 ) // Moodle 3.6 - 3.8
{
    $inline_js .= 'require([\'jquery\',\'theme_boost/tooltip\'], function($){$(\'[data-toggle="tooltip"]\').tooltip()});';
}
$PAGE->requires->js_amd_inline( $inline_js );

?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
   	<link rel="shortcut icon" href="<?php echo $vafIcon; ?>" />
    <?php echo theme_mb2mcl_favicon($PAGE); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo theme_mb2mcl_google_fonts($PAGE); ?>
    <?php theme_mb2mcl_font_icon($PAGE); ?>
	<?php theme_mb2mcl_theme_scripts($PAGE); ?>
    <?php echo $OUTPUT->standard_head_html(); ?>
	<?php echo theme_mb2mcl_ganalytics($PAGE); ?>
</head>
