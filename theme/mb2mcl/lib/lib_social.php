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
 * Method to get social icons list
 *
 */
function theme_mb2mcl_social_icons( $page, $attribs = array() )
{

	$output = '';
	$linkTarget = theme_mb2mcl_theme_setting($page,'sociallinknw') == 1 ? ' target="_balnk"' : '';
	$tt = theme_mb2mcl_theme_setting($page,'socialtt',0);

	$output .= '<ul class="social-list">';

	$output .= isset( $attribs['first'] ) ? '<li class="title-item">' . $attribs['first'] . ':</li>' : '';

	for ($i = 1; $i <=10; $i++)
	{
		$socialName = explode(',', theme_mb2mcl_theme_setting($page, 'socialname' . $i));
		$socialLink = theme_mb2mcl_theme_setting($page, 'sociallink' . $i);

		if ( isset( $socialName[0] ) && $socialName[0] !== '' )
		{
			$isTt = $tt ? ' data-toggle="tooltip" data-placement="'. $attribs['ttpos'] . '" data-trigger="hover"' : '';
			$output .= '<li class="li-' . $socialName[0] . '"><a href="' . $socialLink . '" title="' . $socialName[1] . '"' .
            $linkTarget . $isTt . '><i class="fa fa-' . $socialName[0] . '"></i></a></li>';
		}
	}

	$output .= '</ul>';

	return $output;

}
