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
 * Method to get page builder shortcode content
 *
 */
function theme_mb2mcl_page_builder_content ($page_data = array())
{

	$output = '';

	if (!is_array($page_data) || empty($page_data) || (isset($page_data[0]->attr) && empty($page_data[0]->attr)))
	{
		return;
	}

	foreach ($page_data as $page)
	{
		foreach ($page->attr as $section)
		{
			$output .= '[section' . theme_mb2mcl_page_builder_el_settings($section->settings, array('admin_label')) . ']';

			foreach ($section->attr as $row)
			{
				$output .= '[row' . theme_mb2mcl_page_builder_el_settings($row->settings, array('admin_label'), array('rowheader_content')) . ']';

				foreach ($row->attr as $col)
				{
					$output .= '[pbcolumn' . theme_mb2mcl_page_builder_el_settings($col->settings, array('admin_label')) . ']';

					foreach ($col->attr as $element)
					{
						$output .= '[' . $element->settings->id . theme_mb2mcl_page_builder_el_settings($element->settings, array('admin_label','id','subelement','text','content')) . ']';

						$output .=  theme_mb2mcl_page_builder_el_content($element);

						$output .= '[/' . $element->settings->id . ']';
					}

					$output .= '[/pbcolumn]';
				}
				$output .= '[/row]';
			}
			$output .= '[/section]';
		}
	}

	if (theme_mb2mcl_check_shortcodes_filter())
	{
		return mb2_do_shortcode($output);
	}

}





/*
 *
 * Method to get page builder elements settings attributes
 *
 */
function theme_mb2mcl_page_builder_el_settings($item, $exclude = array(), $entities = array())
{

	$output = '';

	foreach ($item as $k=>$v)
	{
		if (!in_array($k, $exclude))
		{
			if (in_array($k, $entities))
			{
				$v = htmlentities($v);
			}

			if ($v !== '')
			{
				// We want to display only none-empty values
				// We have to use !=='' because of "0" value which is not empty
				$output .= ' ' . $k . '="' . $v . '"';
			}
		}
	}

	return $output;

}



/*
 *
 * Method to get page builder elements content
 *
 */
function theme_mb2mcl_page_builder_el_content($element)
{

	$output = '';

	foreach ($element->settings as $id => $value)
	{
		$output .= ($id === 'text' || $id === 'content') ? $value : '';
	}

	if (isset($element->attr))
	{
		foreach ($element->attr as $subelement)
		{
			$output .= '[' . $subelement->settings->id . theme_mb2mcl_page_builder_el_settings($subelement->settings, array('admin_label','id','text','content')) . ']';

			foreach ($subelement->settings as $id => $value)
			{
				$output .= ($id === 'text' || $id === 'content') ? $value : '';
			}

			$output .= '[/' . $subelement->settings->id . ']';
		}
	}

	return $output;

}
