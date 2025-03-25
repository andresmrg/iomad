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
 * @copyright 2018 Mariusz Boloz (https://lmsstyle.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */

defined('MOODLE_INTERNAL') || die();


/*
 *
 * Method to get Google webfonts
 *
 */
function theme_mb2mcl_google_fonts ($page, $attribs = array())
{

	$output = '';
	$font = '';
	$gfontsubset = theme_mb2mcl_theme_setting($page,'gfontsubset');

	for ($i = 1; $i <=3; $i++)
	{

		$gfontname = theme_mb2mcl_theme_setting($page, 'gfont' . $i);
		$gfontstyle = theme_mb2mcl_theme_setting($page, 'gfontstyle' . $i);


		if ($gfontname !='')
		{


			$sep = $i>1 ? '|' : '';

			$font .= $sep . str_replace(' ', '+', $gfontname);

			if ($gfontstyle)
			{
				$font .= ':' . $gfontstyle;
			}


			if ($gfontsubset)
			{
				$font .= '&amp;subset=' . $gfontsubset;
			}


			$output = '<link href="//fonts.googleapis.com/css?family=' . $font . '" rel="stylesheet">';


		}

	}


	return $output;

}








/*
 *
 * Method to typography custom styles
 *
 */
function theme_mb2mcl_custom_typography ()
{

	global $PAGE;
	$output = '';


	// Custom stypography elements
	for ($i = 1; $i <= 3; $i++)
	{

		$el = theme_mb2mcl_theme_setting($PAGE, 'celsel' . $i);
		$ff = theme_mb2mcl_theme_setting($PAGE, 'ffcel' . $i);
		$fw = theme_mb2mcl_theme_setting($PAGE, 'fwcel' . $i);


		if ($el !='')
		{
			$output .= $el;
			$output .= '{';
			$output .= $ff !== '0' ? 'font-family:' . theme_mb2mcl_get_fonf_family($PAGE, $ff) . ';' : '';
			$output .= 'font-weight:' . $fw . ';';
			$output .= '}';
		}

	}


	return $output;


}







/*
 *
 * Method to get font family setting
 *
 */
function theme_mb2mcl_get_fonf_family ($page, $font)
{
	$output = '\'' . theme_mb2mcl_theme_setting($page, $font) . '\'';

	return $output;
}





/*
 *
 * Method to show fontsizer
 *
 */
function theme_mb2mcl_userfriendly_el ()
{
	global $PAGE;
	$output = '';
	$fontSwitcher = theme_mb2mcl_theme_setting($PAGE,'fontsizer');
	$contrast = false;


	if ($fontSwitcher || $contrast)
	{

		$output .= '<div class="theme-usertools">';

		if ($contrast)
		{
			$output .= '<div class="theme-contrast">';
			$output .= '<a class="hc1" href="#" title="' . get_string('highontrast','theme_mb2mcl') . '">A</a>';
			$output .= '</div>';
		}

		if ($fontSwitcher)
		{
			$output .= '<div class="theme-fontsizer">';
			$output .= '<span class="title">' . get_string('fontsize','theme_mb2mcl') . '</span> ';
			$output .= '<a class="fs1" href="#" data-size="1" title="' . get_string('fontsmall','theme_mb2mcl') . '">A</a>';
			$output .= '<a class="fs2" href="#" data-size="2" title="' . get_string('fontmedium','theme_mb2mcl') . '">A</a>';
			$output .= '<a class="fs3" href="#" data-size="3" title="' . get_string('fontbig','theme_mb2mcl') . '">A</a>';
			$output .= '</div>';
		}

		$output .= '</div>';

	}


	return $output;

}
