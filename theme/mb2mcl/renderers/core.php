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



class theme_mb2mcl_core_renderer extends \theme_boost\output\core_renderer
{


	protected $language = null;



	/**
     * Returns HTML to display a "Turn editing on/off" button in a form.
     *
     * @param moodle_url $url The URL + params to send through when clicking the button
     * @param string $method
     * @return string HTML the button
     */
    public function edit_button(moodle_url $url, string $method = 'post') {
        return null;
    }



	/**
     * Renders the "breadcrumb" for all pages.
     *
     * @return string the HTML for the navbar.
     */
    public function navbar(): string {
		return $this->render_from_template('core/navbar', $this->page->navbar);
    }


	/**
     * The standard tags that should be included in the <head> tag
     * including a meta description for the front page
     *
     * @return string HTML fragment.
     */
    public function standard_head_html()
	{

		global $SITE, $PAGE, $CFG, $DB;

        $output = parent::standard_head_html();

        // Setup help icon overlays.
        // Prevent to show this code in Moodle 4.2+
        $CFG->version < 2023042400 ? $this->page->requires->yui_module('moodle-core-popuphelp', 'M.core.init_popuphelp') : '';
        $this->page->requires->strings_for_js(array(
            'morehelp',
            'loadinghelp',
        ), 'moodle');

        if ($PAGE->pagelayout === 'frontpage') {
            $summary = s(strip_tags(format_text($SITE->summary, FORMAT_HTML)));
            if (!empty($summary)) {
                $output .= "<meta name=\"description\" content=\"$summary\" />\n";
            }
        }

        // Inject additional 'live' css
        $css = '';

        // Get company colours
        $companyid = \iomad::get_my_companyid(\context_system::instance(), false);
        if ($companyrec = $DB->get_record('company', array('id' => $companyid))) {
            $company = $DB->get_record('company', array('id' => $companyid), '*', MUST_EXIST);
            $linkcolor = $company->linkcolor;
            if ($linkcolor) {
                $css .= 'a {color: ' . $linkcolor . '} ';
            }
            $headingcolor = $company->headingcolor;
            if ($headingcolor) {
                $css .= '#main-header .main-header-inner {background-color: ' . $headingcolor . '!important} ';
            }
            $maincolor = $company->maincolor;
            if ($maincolor) {
                $css .= 'body,
                        .btn-primary,
                        .btn-secondary,
                        [type="submit"],
                        li.item-coursepanel a,
                        li.item-dashboard a,
                        li.item-frontpage a,
                        li.item-calendar a,
                        li.item-badges a,
                        li.item-courses a,
                        li.item-turneditingcourse a,
                        li.item-managecoursesandcats a {
                            background-color: ' . $maincolor . '!important
                        }
                        .btn-primary:hover, .btn-secondary:hover,
                        [type="submit"]:hover,
                        li.item-coursepanel a:hover,
                        li.item-dashboard a:hover,
                        li.item-frontpage a:hover,
                        li.item-calendar a:hover,
                        li.item-badges a:hover,
                        li.item-courses a:hover,
                        li.item-turneditingcourse a:hover,
                        li.item-managecoursesandcats a:hover {
                          background-image: linear-gradient(rgb(0 0 0/40%) 0 0);
                        }
                        ';
            }

            $css .= $company->customcss;
        }

        $output = parent::standard_head_html();

        if ($css) {
            $output .= '<style>' . $css . '</style>';
        }

        return $output;
    }







	/**
     *
     * Method to load theme element form 'layout/elements' folder
     *
     */
    public function theme_part($name, $vars = array())
	{

		global $CFG, $SITE, $USER;

		$OUTPUT = $this;
        $PAGE = $this->page;
        $COURSE = $this->page->course;
        $element = $name . '.php';
        $candidate1 = $this->page->theme->dir . '/layout/parts/' . $element;

		// Require for child theme
		if (is_file($candidate1))
		{
			$candidate = $candidate1;
		}
		else
		{
			$candidate = $CFG->dirroot . '/theme/mb2mcl/layout/parts/' . $element;
		}

		if (!is_readable($candidate))
		{
			debugging("Could not include element $name.");
            return;
        }

        extract($vars);
        ob_start();
        include($candidate);
        $output = ob_get_clean();
        return $output;

    }







    /**
     *
     * Method to get custom menu
     *
     */
    public function custom_menu($custommenuitems = '')
	{

		global $CFG, $DB;

		if ( empty( $custommenuitems ) && ! empty( $CFG->custommenuitems ) )
		{
            $custommenuitems = $CFG->custommenuitems;
        }

		// Deal with company custom menu items.
	    if ( class_exists( 'iomad' ) && $companyid = iomad::is_company_user() )
		{
	        if ( $companyrec = $DB->get_record( 'company', array( 'id' => $companyid ) ) )
			{
	            if ( ! empty( $companyrec->custommenuitems ) )
				{
	                $custommenuitems = $companyrec->custommenuitems;
	            }
	        }
	    }

        $custommenu = new custom_menu( $custommenuitems, current_language() );

        return $this->render_custom_menu($custommenu) . $this->page->headingmenu;

    }







    /**
     *
     * Method to render custom menu
     *
     */
    protected function render_custom_menu(custom_menu $menu)
	{


		global $CFG, $PAGE, $OUTPUT, $SITE, $USER, $COURSE;

		$content = '';
		$ddcls = '';
		$myCourses = ( isloggedin() && ! isguestuser() && theme_mb2mcl_theme_setting($PAGE,'mycinmenu') );
		$bookmarks  = ( theme_mb2mcl_theme_setting( $PAGE, 'bookmarks' ) && isloggedin() && !isguestuser() );
		$home_url = new moodle_url($CFG->wwwroot);
		$sitemenu = theme_mb2mcl_theme_setting($PAGE,'sitemnu');
		$coursepanel = theme_mb2mcl_theme_setting($PAGE,'coursepanel');
		$langs = get_string_manager()->get_list_of_translations();

	    $content .= '<ul class="main-menu theme-ddmenu theme-menu"' . theme_mb2mcl_menu_data( $PAGE ) . '>';
		$content .= $myCourses ? theme_mb2mcl_mycourses_list() : '';
		$content .= $bookmarks ? theme_mb2mcl_user_bookmarks() : '';

        foreach ( $menu->get_children() as $item )
		{
		    $content .= $this->render_custom_menu_item( $item, 1 );
        }

		if ( $CFG->langmenu && count( $langs ) > 1  )
		{
			$content .= '<li class="level-1 dropdown langitem">';
			$content .= '<a href="#">';
			$content .= theme_mb2mcl_language_code( current_language() );
			$content .= '<span class="mobile-arrow"></span>';
			$content .= '</a>';
			$content .= theme_mb2mcl_language_list();
			$content .= '</li>';
		}

        return $content.'</ul>';

    }









/**
 *
 * Method to render custom menu item
 *
 */
protected function render_custom_menu_item(custom_menu_item $menunode, $level = 0 )
{

	global $PAGE;

	$submenucount = 0;
	$content = '';
		$class = '';
		$themelinkcls = theme_mb2mcl_theme_setting( $PAGE, 'navcls' );
		$linkcls = $themelinkcls !== '' ? theme_mb2mcl_line_classes( $themelinkcls, $menunode->get_text() ) : '';
		$class .= 'sysitem level-' . $level;
		$class .= $linkcls ? ' li-' . $linkcls : '';

	    if ( $menunode->has_children() )
		{
			$class .= ' dropdown';

			// If the child has menus render it as a sub menu.
            $submenucount++;
			$level++;

			$content .= html_writer::start_tag( 'li', array( 'class' => $class) );

            if ($menunode->get_url() !== null)
			{
				$url = $menunode->get_url();
            }
			else
			{
			    $url = '#cm_submenu_' . $submenucount;
            }

			$content .= html_writer::start_tag('a', array('href'=>$url, 'class'=>$linkcls, 'data-toggle'=>''/*, 'title'=>$menunode->get_title()*/));

            $content .= $menunode->get_text();

			$content .= '<span class="mobile-arrow"></span>';

            $content .= '</a>';

            $content .= '<ul class="dropdown-list">';

            foreach ( $menunode->get_children() as $menunode )
			{
                $content .= $this->render_custom_menu_item( $menunode, $level );
            }

            $content .= '</ul>';

        }
		else
		{

		    // The node doesn't have children so produce a final menuitem.
            // Also, if the node's text matches '####', add a class so we can treat it as a divider.
            if (preg_match("/^#+$/", $menunode->get_text()))
			{
                // This is a divider.
                $content = '<li class="divider">&nbsp;</li>';
            }
			else
			{
                $content .= html_writer::start_tag('li', array('class' => $class));

                if ($menunode->get_url() !== null)
				{
                    $url = $menunode->get_url();
                }
				else
				{
					$url = '#';
                }

			    $content .= html_writer::link($url, $menunode->get_text(), array(/*'title' => $menunode->get_title(),*/ 'class'=>$linkcls));

                $content .= html_writer::end_tag('li');
            }
        }

        return $content;

    }






	/**
     *
     * Method to render tabtree
     *
     */
    protected function render_tabtree(tabtree $tabtree) {


		$output = '';

	    if (empty($tabtree->subtree))
		{
            return '';
        }

        $firstrow = $secondrow = '';

        foreach ($tabtree->subtree as $tab)
		{

		    $firstrow .= $this->render($tab);

			if (($tab->selected || $tab->activated) && !empty($tab->subtree) && $tab->subtree !== array())
			{
                $secondrow = $this->tabtree($tab->subtree);
            }

        }
		$output .= html_writer::start_tag('div', array('class' => 'theme-tabs moodle-tabs'));
        $output .= html_writer::tag('ul', $firstrow, array('class' => 'nav nav-tabs'));
		$output .= html_writer::end_tag('div');

		$output .=  $secondrow;

		return $output;

    }





	/**
     *
     * Method to render tab tree object
     *
     */
    protected function render_tabobject(tabobject $tab) {

	   if (($tab->selected and (!$tab->linkedwhenselected)) or $tab->activated)
	   {

		    return html_writer::tag('li', html_writer::tag('a', $tab->text, array('class'=>'nav-link active')), array('class' => 'nav-item'));

        }
		else if ($tab->inactive)
		{

			return html_writer::tag('li', html_writer::tag('a', $tab->text, array('class'=>'nav-link')), array('class' => 'nav-item'));

        }
		else
		{

			$isactive = $tab->inactive ? ' active' : '';


			if (!($tab->link instanceof moodle_url))
			{

				// backward compartibility when link was passed as quoted string
                $link = '<a class="nav-link' .  $isactive .'" href="' . $tab->link . '" title="' . $tab->title . '">' . $tab->text . '</a>';

            }
			else
			{

			    $link = html_writer::link($tab->link, $tab->text, array('class' => 'nav-link' . $isactive, 'title' => $tab->title));

            }



            return html_writer::tag('li', $link, array('class' => 'nav-item'));

        }

    }






}
