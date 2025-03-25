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
 * @copyright 2019 - 2020 Mariusz Boloz (https://lmsstyle.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */


defined('MOODLE_INTERNAL') || die();


/*
 *
 * Method to display slider items
 *
 */
function theme_mb2mcl_notice ( $position = 'content')
{
    global $CFG, $PAGE, $COURSE;

    $notice_plugin = $CFG->dirroot . '/local/mb2notices/index.php';
    $opt = get_config('local_mb2notices');
    $output = '';

    // Cehck if local slides plugi is installed
	if ( ! file_exists( $notice_plugin ) )
	{
        return;
	}

    // Get slides api
    if ( ! class_exists( 'Mb2noticesApi' ) )
    {
        require_once ( $CFG->dirroot . '/local/mb2notices/classes/api.php' );
    }

    // Get slides
    $items = Mb2noticesApi::get_sortorder_items();

    $output .= '<div class="mb2notices">';

    foreach ( $items as $itemid )
    {
        $output .= theme_mb2mcl_notice_item( $itemid, $position );
    }

    $output .= '</div>';    // mb2notices
    $output .= '';
    $output .= '';

    return $output;

}



/*
 *
 * Method to display notice item
 *
 */
function theme_mb2mcl_notice_item ( $itemid, $position )
{
    global $CFG, $PAGE;

    // Get slider api
    if ( ! class_exists( 'Mb2noticesApi' ) )
    {
        require_once ( $CFG->dirroot . '/local/mb2notices/classes/api.php' );
    }

    if ( ! class_exists( 'Mb2noticesHelper' ) )
    {
        require_once ( $CFG->dirroot . '/local/mb2notices/classes/helper.php' );
    }

    $output = '';
    $cls = '';
    $noticestyle = '';
    $item = Mb2noticesApi::get_record( $itemid );
    $opt = get_config( 'local_mb2notices' );
    $attribs = json_decode( $item->attribs );
    $can_manage = has_capability('local/mb2notices:manageitems', context_system::instance());
    $link_edit = new moodle_url('/local/mb2notices/edit.php', array( 'itemid' => $item->id, 'returnurl' => $PAGE->url->out_as_local_url() ) );
    $canclose = Mb2noticesHelper::get_param( $itemid, 'canclose' );
    $noticepos = Mb2noticesHelper::get_param( $itemid, 'position' );

    if ( ! Mb2noticesHelper::can_see( $item ) )
    {
        return;
    }

    if ( $position !== $noticepos )
    {
        return;
    }

    $cls .= ' mb2notices-item-' . $item->id;
    $cls .= ' type-' . Mb2noticesHelper::get_param( $itemid, 'noticetype' );
    $cls .= $canclose ? ' canclose' : ' cantclose';

    // Define custom styles
    $textcolor = Mb2noticesHelper::get_param( $itemid, 'textcolor' );
    $bgcolor = Mb2noticesHelper::get_param( $itemid, 'bgcolor' );
    if ( $textcolor || $bgcolor )
    {
        $noticestyle .= ' style="';
        $noticestyle .= $textcolor ? 'color:' . $textcolor .';' : '';
        $noticestyle .= $bgcolor ? 'background-color:' . $bgcolor .';' : '';
        $noticestyle .= '"';
    }

    $output .= '<div class="mb2notices-item' . $cls . '" data-itemid="' . $item->id . '" data-cookieexpiry="' .
    $opt->cookieexpiry . '"' . $noticestyle . '>';
    $output .= '<div class="mb2notices-content">';
    $output .= $canclose ? '<a href="#" class="mb2notices-item-close">&#10005;</a>' : '';
    $output .= $can_manage ? '<a class="mb2notices-action-edit" href="' . $link_edit . '"><i class="fa fa-pencil"></i></a>' : '';
    $output .= Mb2noticesHelper::get_param( $itemid, 'showtitle' ) ? '<h4 class="mb2notices-title">' . $item->title . '</h4>' : '';
    $output .= Mb2noticesHelper::get_item_content( $item );
    $output .= '</div>';
    $output .= '</div>';

    return $output;


}
