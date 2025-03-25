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
 * Method to display slider items
 *
 */
function theme_mb2mcl_slider ()
{
    global $CFG, $PAGE;

    $slider = theme_mb2mcl_theme_setting($PAGE, 'slider');
    $slider_plugin = $CFG->dirroot . '/local/mb2slides/index.php';
    $opt = get_config('local_mb2slides');
	$uniqid = uniqid();
    $output = '';
    $cls = '';

    // Check if user want to use slider on front page
    if (!$slider)
    {
        return;
    }

    // Cehck if local slides plugi is installed
	if ( ! file_exists( $CFG->dirroot . '/local/mb2slides/index.php' ))
	{
        if (is_siteadmin())
        {
            return '<div class="alert alert-warning" style="max-width:90%;margin:1rem auto;" role="alert">' . get_string('mb2slides_plugin','theme_mb2mcl') . '</div>';
        }
        else
        {
            return;
        }
	}
    else
    {
        // Slides plugin is installed!
        // Get slides api
        if (!class_exists('Mb2slidesApi'))
        {
            require_once ( $CFG->dirroot . '/local/mb2slides/classes/api.php' );
        }

        // Get slides
        $items = Mb2slidesApi::get_sortorder_items();

        // Check if some slides exists
        if (!count($items))
        {
            if (is_siteadmin())
            {
                return '<div class="alert alert-success" style="max-width:90%;margin:0 auto 1rem auto;" role="alert">' .
                get_string('mb2slides_plugin_empty','theme_mb2mcl', array('link' => $CFG->wwwroot . '/local/mb2slides/index.php')) . '</div>';
            }
            else
            {
                return;
            }
        }
    }

    // Set slider css classes and styles
    $cls .= ' navdir' . $opt->navdir;
    $style_slider = $opt->slidermargin ? ' style="padding:' . $opt->slidermargin . '"' : '';

    $output .= '<div id="main-slider" class="mb2slides mb2slides-mainslider mb2slides' . $uniqid . $cls . '"' . $style_slider . '>';
    $output .= '<div class="mb2slides-inner">';
    $output .= '<ul class="mb2slides-slide-list"' . theme_mb2mcl_slider_data_attr($uniqid) . '>';

    foreach ($items as $itemid)
    {
        $output .= theme_mb2mcl_slider_item($itemid);
    }

    $output .= '</ul>';     // mb2slides-slide-list
    $output .= '</div>';    // mb2slides-inner
    $output .= '</div>';    // mb2slides
    $output .= '';
    $output .= '';

    return $output;

}



/*
 *
 * Method to display slider item
 *
 */
function theme_mb2mcl_slider_item ($itemid)
{
    global $CFG;

    // Get slider api
    if (!class_exists('Mb2slidesApi'))
    {
        require_once ( $CFG->dirroot . '/local/mb2slides/classes/api.php' );
    }

    if (!class_exists('Mb2slidesHelper'))
    {
        require_once ( $CFG->dirroot . '/local/mb2slides/classes/helper.php' );
    }

    $output = '';
    $cls = '';
    $cls_caption = '';
    $style_caption = '';
    $style_caption3 = '';
    $cls_caption_content = '';
    $style_title = '';
    $item = Mb2slidesApi::get_record($itemid);
    //$can_manage = has_capability('local/mb2slides:manageitems', context_system::instance());
    $opt = get_config('local_mb2slides');
    $attribs = json_decode($item->attribs);
    $cstylepre = Mb2slidesHelper::get_param($itemid, 'cstylepre');
    $titlefs = str_replace(',', '.', Mb2slidesHelper::get_param($itemid, 'titlefs'));
    $titlefs = trim($titlefs);
    $link_slide = ($attribs->link && !Mb2slidesHelper::get_param($itemid, 'linkbtn') && !theme_mb2mcl_check_for_tags(Mb2slidesHelper::get_item_content($item), 'a'));
    $link_target = $attribs->linktarget ? ' target="_blank"' : '';

    if ( ! Mb2slidesHelper::can_see( $item ) )
    {
        return;
    }

    // Caption classes
    $cls_caption .= ' hor-' . Mb2slidesHelper::get_param($itemid, 'chalign');
    $cls_caption .= ' ver-' . Mb2slidesHelper::get_param($itemid, 'cvalign');
    $cls_caption .= ' anim' . $opt->captionanim;
    $cls_caption .= ( $cstylepre === 'custom' && Mb2slidesHelper::get_param( $itemid, 'cbgcolor' )  === '' ) ? ' nobg' : '';
    $cls_caption .= $attribs->showtitle ? ' istitle' : ' notitle';

    // Caption content classes
    if ($cstylepre === 'circle' && $opt->navdir == 2)
    {
        $cls_caption_content .= ' nocircle';
    }
    elseif ($cstylepre === 'border')
    {
        $cls_caption_content .= ' csborder';
    }
    else
    {
        $cls_caption_content .= ' ' . $cstylepre;
    }
    $cls_caption_content .= Mb2slidesHelper::get_param($itemid, 'cshadow') ? ' isshadow' : '';

    // Caption style
    $style_caption .= ' style="';

    // Caption style for circle
    if ( $cstylepre === 'circle' && $opt->navdir != 2 )
    {
        $style_caption .= 'width:' . Mb2slidesHelper::get_param( $itemid, 'captionw' ) . 'px;';
        $style_caption .= 'height:' . Mb2slidesHelper::get_param( $itemid, 'captionw' ) . 'px;';
    }
    elseif ( $cstylepre === 'fullwidth' )
    {
        $style_caption3 = ' style="max-width:' . Mb2slidesHelper::get_param( $itemid, 'captionw' ) . 'px;"';
    }
    else
    {
        $style_caption .= 'max-width:' . Mb2slidesHelper::get_param( $itemid, 'captionw' ) . 'px;';
    }

    $style_caption .= Mb2slidesHelper::get_param($itemid, 'cbgcolor') ? 'background-color:' . Mb2slidesHelper::get_param($itemid, 'cbgcolor') . ';' : '';
    $style_caption .= '"';

    // Title style
    $style_title .= ' style="';
    $style_title .= Mb2slidesHelper::get_param($itemid, 'titlecolor') ? 'color:' . Mb2slidesHelper::get_param($itemid, 'titlecolor') . ';' : '';
    $style_title .= 'font-size:' . $titlefs . 'rem;';
    $style_title .= '"';

    // Content width
    $contentwidth_style = $opt->contentwidth !== '' ? 'width:' . str_replace('px', '', $opt->contentwidth) . 'px;' : '';

    $output .= '<li class="mb2slides-slide-item caption-' . $cstylepre . '">';
    $output .= theme_mb2mcl_slider_actions($item);
    $output .= $link_slide ? '<a class="fillslide-link" href="' . $attribs->link . '"' . $link_target . '>' : '';
    $output .= '<div class="mb2slides-slide-item-inner">';
    $output .= '<div class="mb2slides-slide-media" style="background-image:url(\'' . Mb2slidesHelper::get_image_url($item->id) . '\');">';
    $output .= '<img class="mb2slides-slide-img" src="' . Mb2slidesHelper::get_image_url($item->id) . '" alt=""/>';
    $output .= '</div>'; // mb2slides-slide-media

    if ( Mb2slidesHelper::get_item_content( $item ) || $attribs->showtitle )
    {
        $output .= '<div class="mb2slides-caption' . $cls_caption . '">';
        $output .= '<div class="mb2slides-caption1" style="' . $contentwidth_style . 'margin:0 auto;">';
        $output .= '<div class="mb2slides-caption2">';
        $output .= '<div class="mb2slides-caption3">';
        $output .= '<div class="mb2slides-caption-content' . $cls_caption_content . '"' . $style_caption . '>'; // caption style and pre style
        $output .= '<div class="mb2slides-caption-content2">';
        $output .= '<div class="mb2slides-caption-content3"' . $style_caption3 . '>'; // caption width in full width style
        $output .= $attribs->showtitle ? '<h4 class="mb2slides-title"' . $style_title . '>' .
        format_text( theme_mb2mcl_get_highlight_text( $item->title ) ) . '</h4>' : '';
        $output .= theme_mb2mcl_slider_item_desc($item);

        // Caption 'border' style
        $cborder_style = Mb2slidesHelper::get_param($itemid, 'cbordercolor') != '' ? ' style="background-color:' . Mb2slidesHelper::get_param($itemid, 'cbordercolor') . ';"' : '';
        $output .= $cstylepre === 'border' ? '<span class="mb2slides-border"' . $cborder_style . '></span>' : '';

        $output .= '</div>'; // mb2slides-caption-content3
        $output .= '</div>'; // mb2slides-caption-content2
        $output .= '</div>'; // mb2slides-caption-content
        $output .= '</div>'; // mb2slides-caption3
        $output .= '</div>'; // mb2slides-caption2
        $output .= '</div>'; // mb2slides-caption1
        $output .= '</div>'; // mb2slides-caption
    }

    $output .= Mb2slidesHelper::get_param($itemid, 'imagecolor') ? '<div class="mb2slides-overlay-bg" style="background-color:' .
    Mb2slidesHelper::get_param($itemid, 'imagecolor') . ';"></div>' : '';
    $output .= '</div>';    // mb2slides-slide-item-inner
    $output .= $link_slide ? '</a>' : '';
    $output .= '</li>';     // mb2slides-slide-item

    return $output;


}




/*
 *
 * Method to display slider item
 *
 */
function theme_mb2mcl_slider_item_desc ($item)
{
    global $CFG;

    if (!class_exists('Mb2slidesHelper'))
    {
        require_once ( $CFG->dirroot . '/local/mb2slides/classes/helper.php' );
    }

    $output = '';

    $style_desc = '';
    $cls_nav = '';
    $style_btn = '';
    $itemid = $item->id;
    $opt = get_config('local_mb2slides');
    $cstylepre = Mb2slidesHelper::get_param($itemid, 'cstylepre');
    $attribs = json_decode($item->attribs);
    $descfs = str_replace(',', '.', Mb2slidesHelper::get_param($itemid, 'descfs'));
    $descfs = trim($descfs);

    if (!Mb2slidesHelper::get_item_content($item))
    {
        return;
    }

    // Description style
    $style_desc .= ' style="';
    $style_desc .= Mb2slidesHelper::get_param($itemid, 'desccolor') ? 'color:' . Mb2slidesHelper::get_param($itemid, 'desccolor') . ';' : '';
    $style_desc .= 'font-size:' . $descfs . 'rem;line-height:' . round($descfs * 1.65, 10) . 'rem;';
    $style_desc .= '"';

    // Button style
    if (Mb2slidesHelper::get_param($itemid, 'btncolor'))
    {
        $style_btn .= ' style="';
        $style_btn .= 'background-color:' . Mb2slidesHelper::get_param($itemid, 'btncolor') . ';';
        $style_btn .= 'border-color:' . Mb2slidesHelper::get_param($itemid, 'btncolor') . ';';
        $style_btn .= '"';
    }

    // Check link button
    $link_btn = ($attribs->link && Mb2slidesHelper::get_param($itemid, 'linkbtn'));
    $link_btn_text = Mb2slidesHelper::get_param($itemid, 'linkbtntext') ? format_text(Mb2slidesHelper::get_param($itemid, 'linkbtntext')) : get_string('readmore','local_mb2slides');
    $link_btn_target = $attribs->linktarget ? ' target="_blank"' : '';
    $link_btn_cls = $opt->navdir == 2 ? '' : Mb2slidesHelper::get_param($itemid, 'linkbtncls');

    // Custom navigation css class
    $cls_nav .= $link_btn ? ' islink' : ' nolink';

    $output .= '<div class="mb2slides-description">';
    $output .= '<div class="mb2slides-text"' . $style_desc . '>';
    $output .= Mb2slidesHelper::get_item_content($item);
    $output .= '</div>'; // mb2slides-text

    $output .= $opt->navdir == 2 ? '<div class="mb2slides-captionnav' . $cls_nav . '">' : '';
    $output .= $opt->navdir == 2 ? '<span class="mb2slides-prevslide"><i class="fa fa-angle-left"></i></span>' : '';

    if ($link_btn)
    {
        $output .= '<a href="' . $attribs->link . '" class="mb2slides-btn ' . $link_btn_cls . '"' . $link_btn_target . $style_btn . '>';
        $output .= $link_btn_text;
        $output .= '</a>';
    }

    $output .= $opt->navdir == 2 ? '<span class="mb2slides-nextslide"><i class="fa fa-angle-right"></i></span>' : '';
    $output .= $opt->navdir == 2 ? '</div>' : ''; // mb2slides-captionnav

    $output .= '</div>'; // mb2slides-description
    $output .= $link_btn ? '<a href="' . $attribs->link . '" class="mb2slides-btn-mobile"' . $link_btn_target . $style_btn . '>&#43;</a>' : '';
    return $output;

}



/*
 *
 * Method to display slides actions
 *
 */
function theme_mb2mcl_slider_actions ($item)
{
    global $PAGE;
    $output = '';
    $languages = Mb2slidesHelper::get_languages($item);
    $can_manage = has_capability('local/mb2slides:manageitems', context_system::instance());
    $link_edit = new moodle_url('/local/mb2slides/edit.php', array('itemid' => $item->id, 'returnurl' => $PAGE->url->out_as_local_url()));
    $link_add = new moodle_url('/local/mb2slides/edit.php', array());
    $link_delete = new moodle_url('/local/mb2slides/delete.php', array('deleteid' => $item->id));
    $link_hideshow = new moodle_url('/local/mb2slides/index.php', array('hideshowid' => $item->id, 'returnurl' => $PAGE->url->out_as_local_url()));

    if (!$can_manage)
    {
        return;
    }

    $output .= '<div class="mb2slides-actions">';

    $output .= '<a class="mb2slides-action action-edit" href="' . $link_edit . '" data-toggle="tooltip" title="' . get_string('editslide', 'local_mb2slides') . '">';
    $output .= '<i class="fa fa-pencil"></i>';
    $output .= '</a>';

    $showhideicon = $item->enable ? 'fa-eye' : 'fa-eye-slash';
    $showhidestr = $item->enable ? get_string('disableslide', 'local_mb2slides') : get_string('enableslide', 'local_mb2slides');

    $output .= '<a class="mb2slides-action action-hideshow" href="' . $link_hideshow . '" data-toggle="tooltip" title="' . $showhidestr . '">';
    $output .= '<i class="fa ' . $showhideicon . '"></i>';
    $output .= '</a>';

    $output .= '<a class="mb2slides-action action-add" href="' . $link_add . '" data-toggle="tooltip" title="' . get_string('addslide', 'local_mb2slides') . '">';
    $output .= '<i class="fa fa-plus"></i>';
    $output .= '</a>';

    $output .= '<a class="mb2slides-action action-delete" href="' . $link_delete . '" data-toggle="tooltip" title="' . get_string('deleteslide', 'local_mb2slides') . '">';
    $output .= '<i class="fa fa-trash"></i>';
    $output .= '</a>';

    if ($item->access == 1 || $item->access == 2)
    {
        if ($item->access == 1)
        {
            $visibletostr = get_string('userscansee', 'local_mb2slides');
            $visibletoicon = 'fa-lock';
        }
        elseif ($item->access == 2)
        {
            $visibletostr = get_string('guestscansee', 'local_mb2slides');
            $visibletoicon = 'fa-unlock';
        }

        $output .= '<span class="mb2slides-action action-access" data-toggle="tooltip" title="' . $visibletostr . '">';
        $output .= '<i class="fa ' . $visibletoicon . '"></i>';
        $output .= '</span>';
    }

    if (count($languages))
    {
        $output .= '<span class="mb2slides-action action-languages" data-toggle="tooltip" title="' . get_string('language','moodle') . ': ' . implode(', ', $languages) . '">';
        $output .= '<i class="fa fa-globe"></i>';
        $output .= '</span>';
    }


    $output .= '</div>'; // mb2slides-actions

    return $output;

}



function theme_mb2mcl_slider_data_attr($id = 0)
{

    $output = '';
    $opt = get_config('local_mb2slides');

    $output .= ' data-mode="' . $opt->animtype . '"';
    $output .= ' data-auto="' . $opt->animauto . '"';
    $output .= ' data-aspeed="' . $opt->animspeed . '"';
    $output .= ' data-apause="' . $opt->animpause . '"';
    $output .= ' data-loop="' . $opt->animloop . '"';
    $output .= ' data-pager="' . $opt->navpager . '"';
    $output .= ' data-control="' . $opt->navdir . '"';
    $output .= ' data-items="1"';
    $output .= ' data-moveitems="1"';
    $output .= ' data-margin=""';
    $output .= ' data-aheight="1"';
    $output .= ' data-kpress="1"';
    $output .= ' data-modid="' . $id . '"';
    $output .= ' data-slidescount="2"';

    return $output;

}
