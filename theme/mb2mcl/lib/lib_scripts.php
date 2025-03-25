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
 * Method to get theme scripts
 *
 */
function theme_mb2mcl_theme_scripts ($page, $attribs = array())
{

	global $USER, $CFG;

	// jQuery framework
	$page->requires->jquery();

	// Sf menu script
	$page->requires->js('/theme/mb2mcl/assets/superfish/superfish.custom.js');

	// Main slider
	$page->requires->js('/theme/mb2mcl/assets/lightslider/lightslider.custom.min.js');

	// OWL carousel
	$page->requires->css('/theme/mb2mcl/assets/OwlCarousel/assets/owl.carousel.min.css');
	$page->requires->js('/theme/mb2mcl/assets/OwlCarousel/owl.carousel.min.js');

	// Inview: http://github.com/zuk/jquery.inview/
	$page->requires->js('/theme/mb2mcl/assets/inview.js');

	// Animate number plugin: https://github.com/aishek/jquery-animateNumber
	$page->requires->js('/theme/mb2mcl/assets/animateNumber.js');

	// https://github.com/js-cookie/js-cookie
	$page->requires->js('/theme/mb2mcl/assets/js.cookie.js');

	// Spectrum color
	if ( is_siteadmin() )
	{
		$page->requires->css('/theme/mb2mcl/assets/spectrum/spectrum.min.css');
		$page->requires->js('/theme/mb2mcl/assets/spectrum/spectrum.min.js');
	}

	// Theme amd script from Boost theme scripts
	// $page->requires->js('/theme/mb2mcl/javascript/theme-amd.js');
	$page->requires->js('/theme/mb2mcl/javascript/theme.js');

	// Youtube api player
	//$page->requires->js('/theme/mb2mcl/assets/youtube/player_api.js');

	// Custom scripts
	$cssFiles = theme_mb2mcl_get_custom_files(1);
	$jsFiles = theme_mb2mcl_get_custom_files(2);
	$themename = theme_mb2mcl_themename();

	if (count($cssFiles)>0)
	{
		foreach ($cssFiles as $cssF)
		{
			$page->requires->css('/theme/' . $themename . '/style/custom/' . $cssF . '.css');
		}
	}

	if (count($jsFiles)>0)
	{
		foreach ($jsFiles as $jsF)
		{
			$page->requires->js('/theme/' . $themename . '/javascript/custom/' . $jsF . '.js');
		}
	}

}
