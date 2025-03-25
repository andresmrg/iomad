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
 * @package   theme_boost
 * @copyright 2016 Ryan Wyllie
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * @package   theme_boost
 * @copyright 2016 Ryan Wyllie
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_mb2mcl_admin_settingspage_tabs extends admin_settingpage {

    /** @var The tabs */
    protected $tabs = array();



    /**
     * Add a tab.
     *
     * @param admin_settingpage $tab A tab.
     */
    public function add_tab(admin_settingpage $tab) 
    {
        foreach ($tab->settings as $setting) 
        {
            $this->settings->{$setting->name} = $setting;
        }

        $this->tabs[] = $tab;

        return true;
    }





    public function add($tab) 
    {
        return $this->add_tab($tab);
    }




    /**
     * Get tabs.
     *
     * @return array
     */
    public function get_tabs() 
    {
        return $this->tabs;
    }





    /**
     * Generate the HTML output.
     *
     * @return string
     */
    public function output_html()
    {
        global $OUTPUT, $PAGE;

        $outpt = '';

        $outpt .= '<div class="ts_container mb-4">';
        $outpt .= '<div class="ts_tools d-flex justify-content-end align-items-center">';
        $outpt .= '<button class="themereset ts-toggleall collapsed tsizesmall tcolorn" type="button" aria-expanded="false">' . get_string('expandall') . '</button>';
        $outpt .= '</div>'; // ts_cat

        foreach ($this->get_tabs() as $tab) 
        {            
            $outpt .= '<div id="' . $tab->name . '" class="ts_cat">';
            $outpt .= '<div class="ts_cheader d-flex align-items-center my-3">';            
            $outpt .= '<button class="themereset ts-btn ts-togglecat ts_togglejs collapsed p-0 lhsmall mr-2" type="button" aria-expanded="false" aria-label="' . get_string('settingstogglecat','theme_mb2mcl', $tab->visiblename) . '"><span class="toggle-icon d-inline-flex align-items-center" aria-hidden="true"></span></button>';
            $outpt .= '<div class="ts_cname h4 mb-0">' . $tab->visiblename . '</div>';
            $outpt .= '</div>'; // theme-settings_catheader
            $outpt .= '<div class="ts_ccontent ts_jsontent d-none">';
            $outpt .= $tab->output_html();
            $outpt .= '</div>'; // theme-settings_catcontent
            $outpt .= '</div>'; // ts_cat         
        }

        $outpt .= '</div>'; // ts_container

        return $outpt;
    }

}