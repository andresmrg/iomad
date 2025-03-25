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
* Method to get predefined scss variables
*
*/
function theme_mb2mcl_get_pre_scss($theme)
{
    global $CFG;
    $scss = '';
    $vars = theme_mb2mcl_get_style_vars();

    foreach ($vars as $k => $v)
    {
        switch ($k)
        {

            // Font family
            case 'ffgeneral' :
            $fname = $theme->settings->ffgeneral;
            $isv = (isset($theme->settings->$fname) && $theme->settings->$fname != '')  ? $theme->settings->$fname : NULL;
            break;

            case 'ffheadings' :
            $fname = $theme->settings->ffheadings;
            $isv = (isset($theme->settings->$fname) && $theme->settings->$fname != '')  ? $theme->settings->$fname : NULL;
            break;

            case 'ffmenu' :
            $fname = $theme->settings->ffmenu;
            $isv = (isset($theme->settings->$fname) && $theme->settings->$fname != '')  ? $theme->settings->$fname : NULL;
            break;

            case 'ffddmenu' :
            $fname = $theme->settings->ffddmenu;
            $isv = (isset($theme->settings->$fname) && $theme->settings->$fname != '')  ? $theme->settings->$fname : NULL;
            break;

            // In all other cases get theme setting
            default :
            $isv = isset($theme->settings->$k) ? $theme->settings->$k : NULL;

	   }

	   if (empty($isv))
       {
		   continue;
	   }

	   $issuffix = isset($v[1]) ? $v[1] : '';

	   $scss .= '$' . $v[0] . ':' . $isv . $issuffix . ';';

   }

   return $scss;

}





/*
 *
 * Method to set inline styles
 *
 */
function theme_mb2mcl_get_pre_scss_raw ($theme)
{

	global $PAGE;
	$output = '';

	$output .= theme_mb2mcl_custom_typography();
    $output .= theme_mb2mcl_admin_regions_hide_options();
	$output .= theme_mb2mcl_theme_setting($PAGE,'customcss','',false,$theme);

	return $output;

}







/*
 *
 * Method to get theme settings for scss file
 *
 */
function theme_mb2mcl_get_style_vars()
{
    global $PAGE;

    $vars = array(

		// General settings
	    'navddwidth' => array('navddwidth','px'),
		'pagewidth' => array('pagewidth','px'),
        'sidebarw' => array('sidebarw','px'),
        'logoh' => array('logoh','rem'),
        'logomtb' => array('logomtb','rem'),

		// Colors
		'accent1' =>  array('accent1'),
		'accent2' =>  array('accent2'),
		'accent3' =>  array('accent3'),
		'textcolor' =>  array('textcolor'),
        'textcolor_lighten' => array('textcolor_lighten'),
        'textcolor_footer' => array('textcolor_footer'),
		'linkcolor' =>  array('linkcolor'),
		'linkhcolor' =>  array('linkhcolor'),
		'headingscolor' =>  array('headingscolor'),
        'btncolor' =>  array('btncolor'),
        'btnprimarycolor' =>  array('btnprimarycolor'),
        'btnsecondarycolor' => array('btnsecondarycolor'),

		// Page background
		'pbgcolor' => array('pbgcolor'),
		'pbgrepeat' => array('pbgrepeat'),
		'pbgpos' => array('pbgpos'),
		'pbgattach' => array('pbgattach'),
		'pbgsize' => array('pbgsize'),
		'pbgcolor' => array('pbgcolor'),

		// Login page background
		'loginbgcolor' => array('loginbgcolor'),
		//'loginbgrepeat' => array('loginbgrepeat'),
		//'loginbgpos' => array('loginbgpos'),
		//'loginbgattach' => array('loginbgattach'),
		//'loginbgsize' => array('loginbgsize'),
		'loginbgcolor' => array('loginbgcolor'),

		// Fonts family
		'ffgeneral' =>  array('ffgeneral'),
		'ffheadings' =>  array('ffheadings'),
		'ffmenu' =>  array('ffmenu'),
		'ffddmenu' =>  array('ffddmenu'),
        'fwbold' =>  array('fwbold'),

		// Font size
		'fsbase'=> array('fsbase','px'),
		'fsbase2'=> array('fsbase2','px'),
		'fsbase3'=> array('fsbase3','px'),

		// Headings font size
        'fsheading1'=> array('fsheading1','rem'),
		'fsheading2'=> array('fsheading2','rem'),
		'fsheading3'=> array('fsheading3','rem'),
		'fsheading4'=> array('fsheading4','rem'),
		'fsheading5'=> array('fsheading5','rem'),
		'fsheading6'=> array('fsheading6','rem'),

        // Menu font size
		'fsmenu'=> array('fsmenu','rem'),
		'fsddmenu'=> array('fsddmenu','rem'),

		// Font weight
		'fwgeneral'=> array('fwgeneral'),
		'fwheadings'=> array('fwheadings'),
		'fwmenu'=> array('fwmenu'),
		'fwddmenu'=> array('fwddmenu'),

		// Text transform
		'ttheadings'=> array('ttheadings'),
		'ttmenu'=> array('ttmenu'),
		'ttddmenu'=> array('ttddmenu'),

		// Font style
		'fstheadings'=> array('fstheadings'),
		'fstmenu'=> array('fstmenu'),
		'fstddmenu'=> array('fstddmenu')

   	);

	return $vars;

}
