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
 * Method to set body class
 *
 *
 */
function theme_mb2mcl_body_cls($page)
{

    global $PAGE, $USER, $COURSE;
    $output = array();

    // Page layout
    $output[] = 'theme-l' . theme_mb2mcl_theme_setting($page, 'layout', 'fw');

    // Header style
    $output[] = 'header-' . theme_mb2mcl_theme_setting($page, 'headerstyle', 'light');

    // Icon nav menu class
    if (theme_mb2mcl_theme_setting($page, 'navicons') !== '' )
    {
        $output[] = 'isiconmenu';
    }

    // Custom login page
    if (theme_mb2mcl_is_login($page, true))
    {
        $output[] = 'custom-login';
    }
    elseif ( theme_mb2mcl_is_login($page, false) )
    {
        $output[] = 'default-login';
    }

    if ( ! isloggedin() || isguestuser() )
    {
        $output[] = 'nouser';
    }

    // Check if is guest user
    if (isguestuser())
    {
        $output[] = 'isguestuser';
    }

    // Custom page classes
    if (theme_mb2mcl_page_cls($page))
    {
        $output[] = theme_mb2mcl_page_cls($page);
    }

    // Custom course pages class
    if (theme_mb2mcl_page_cls($page, true))
    {
        $output[] = theme_mb2mcl_page_cls($page, true);
    }

    // Custom course class
    if (theme_mb2mcl_course_cls($page))
    {
        $output[] = theme_mb2mcl_course_cls($page);
    }

    // Course category theme
    if (theme_mb2mcl_courselist_cls($page))
    {
        $output[] = theme_mb2mcl_courselist_cls($page);
    }

    // Fixed navigation
    if ( theme_mb2mcl_theme_setting( $page, 'stickyheader' ) )
    {
        $output[] = 'sticky-header' . theme_mb2mcl_theme_setting( $page, 'stickyheader' );
    }

    // Page predefined background
    if (!theme_mb2mcl_is_login($page, true) && theme_mb2mcl_theme_setting($page, 'pbgpre') !='')
    {
        $output[] = 'pre-bg' . theme_mb2mcl_theme_setting($page, 'pbgpre');
    }

    // Login page predefined background
    if (theme_mb2mcl_is_login($page, true) && theme_mb2mcl_theme_setting($page, 'loginbgpre') !='')
    {
        $output[] = 'pre-bg' . theme_mb2mcl_theme_setting($page, 'loginbgpre');
    }

    if (theme_mb2mcl_theme_setting($page,'sidebarbtn') == 2)
    {
        $output[] = 'hide-sidebars';
    }

    // Theme hidden region mode
    if (isloggedin() && !is_siteadmin())
    {
        $output[] = 'theme-hidden-region-mode';
    }

    if (!theme_mb2mcl_is_frontpage_content())
    {
        $output[] = 'fpempty';
    }

    if ( theme_mb2mcl_course_layout_class() )
    {
        $output[] = theme_mb2mcl_course_layout_class();
    }

    foreach ( theme_mb2mcl_midentify() as $class )
    {
        $output[] = $class;
    }

    $output[] = theme_mb2mcl_sidebar_cls();

    $output[] = 'page-sidebar-' . theme_mb2mcl_theme_setting($page, 'pagesidebar');

    if ( theme_mb2mcl_is_sidebar() )
    {
        $output[] = 'sidebar-allsize';
    }

    if ( isset($USER->gradeediting[$COURSE->id]) && $PAGE->pagetype === 'grade-report-grader-index' && $USER->gradeediting[$COURSE->id] )
    {
        $output[] = 'grading';
    }

    if ( theme_mb2mcl_is_toc() && ! $PAGE->user_is_editing() )
    {
        $output[] = 'ctoc';
    }

    return $output;


}


/*
 *
 * Method to check if front page is empty
 *
 */
function theme_mb2mcl_sidebar_cls()
{
    global $PAGE;

    $output = 'no-sidebars';
    $sidePre = theme_mb2mcl_isblock($PAGE, 'side-pre');
    $sidePost = theme_mb2mcl_isblock($PAGE, 'side-post');

    if ($sidePre && $sidePost)
    {
        $output = 'two-sidebars';
    }
    elseif ($sidePre || $sidePost)
    {
        $output = 'one-sidebar';
    }

    return $output;

}


/*
 *
 * Method to check if front page is empty
 *
 */
function theme_mb2mcl_is_frontpage_content()
{

    global $CFG;

    if (is_dir($CFG->dirroot . '/local/mb2builder'))
    {
        if ((isloggedin() && !isguestuser()))
        {
            if (($CFG->frontpageloggedin === 'none' || $CFG->frontpageloggedin === ''))
            {
                return false;
            }
        }
        elseif(!isloggedin() || isguestuser())
        {
            if (($CFG->frontpage === 'none' || $CFG->frontpage === ''))
            {
                return false;
            }
        }
    }

    return true;

}




/*
 *
 * Method to check if is login page
 *
 */
function theme_mb2mcl_is_login($page, $custom = false)
{

    $output = false;

    $pTypeArr = explode('-', $page->pagetype);
    $isLoginPage = ($pTypeArr[0] === 'login' && $pTypeArr[1] === 'index');
    $customLoginPage = theme_mb2mcl_theme_setting($page, 'cloginpage', '', 0);
    $isuserLogged = (isloggedin() && !isguestuser());

    if ( $custom )
    {
        $output = ( $isLoginPage && $customLoginPage && ! $isuserLogged );
    }
    else
    {
        $output = $isLoginPage;
    }

    return $output;

}







/*
 *
 * Method to get theme name
 *
 */
function theme_mb2mcl_themename ()
{
    global $CFG,$PAGE,$COURSE;

    $name = $CFG->theme;

    if (isset($PAGE->theme->name) && $PAGE->theme->name)
    {
        $name = $PAGE->theme->name;
    }
    elseif (isset($COURSE->theme) && $COURSE->theme)
    {
        $name = $COURSE->theme;
    }

    return $name;

}





/*
 *
 * Method to get menu data attributes
 *
 */
function theme_mb2mcl_menu_data ($page, $attribs = array())
{

    $output = '';

    $output .= ' data-animtype="' . theme_mb2mcl_theme_setting($page, 'navatype', 2) . '"';
    $output .= ' data-animspeed="' . theme_mb2mcl_theme_setting($page, 'navaspeed', 300) . '"';
    $output .= ' data-breakpoint="768"';

    return $output;

}


/*
 *
 * Method to get custom css and js file
 *
 *
 */
function theme_mb2mcl_get_custom_files ($type)
{

    global $CFG;

    $themename = theme_mb2mcl_themename();
    $cssDir = $CFG->dirroot . '/theme/' . $themename . '/style/custom/';
    $jsDir = $CFG->dirroot . '/theme/' . $themename . '/javascript/custom/';

    if (is_dir($cssDir) && $type == 1)
    {
        return theme_mb2mcl_file_arr($cssDir, array('css'));
    }
    elseif (is_dir($jsDir) && $type == 2)
    {
        return theme_mb2mcl_file_arr($jsDir, array('js'));
    }

    return array();

}






/*
 *
 * Method to get files array from directory
 *
 *
 */
function theme_mb2mcl_file_arr ($dir, $filter = array('jpg','jpeg','png','gif'))
{

    $output = '';
    $filesArray = array();

    if (!is_dir($dir))
    {
        $output = get_string('foldernoexists','theme_mb2mcl');
    }
    else
    {
        $dirContents = scandir($dir);

        foreach ($dirContents as $file)
        {
            $file_type = pathinfo($file, PATHINFO_EXTENSION);

            if (in_array($file_type, $filter))
            {
                $filesArray[] = basename($file, '.' . $file_type);
            }
        }

        $output = $filesArray;
    }

    return $output;

}








/*
 *
 * Method to get random image from array
 *
 *
 */
function theme_mb2mcl_random_image ($dir, $pixDirName, $attribs = array('jpg','jpeg','png','gif'))
{

    global $OUTPUT, $CFG;
    $moodle33 = 2017051500;
    $output = '';
    $arr = theme_mb2mcl_file_arr($dir, $attribs);

    if (is_array($arr) && !empty($arr))
    {
        $randomImg = array_rand($arr,1);
        $output = $CFG->version >= $moodle33 ? $OUTPUT->image_url($pixDirName . '/' . $arr[$randomImg],'theme') : $OUTPUT->pix_url($pixDirName . '/' . $arr[$randomImg],'theme');
    }

    return $output;

}




/*
 *
 * Method to get font icons
 *
 *
 */
function theme_mb2mcl_font_icon ($page, $attribs = array())
{

    $output = '';

    $glyphIcons = theme_mb2mcl_theme_setting($page, 'ficonglyph', 1);
    $lineIcons = 1;

    if ($glyphIcons == 1)
    {
        $page->requires->css('/theme/mb2mcl/assets/bootstrap/css/glyphicons.min.css');
    }

    if ($lineIcons == 1)
    {
        $page->requires->css('/theme/mb2mcl/assets/LineIcons/LineIcons.min.css');
    }

    return $output;

}






/*
 *
 * Method to get image url
 *
 *
 */
function theme_mb2mcl_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array())
{

    if ( $context->contextlevel == CONTEXT_SYSTEM )
    {
        $theme = theme_config::load('mb2mcl');

        switch ($filearea)
        {
            case 'logo' :
            return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
            break;

            case 'pbgimage' :
            return $theme->setting_file_serve('pbgimage', $args, $forcedownload, $options);
            break;

            case 'loginbgimage' :
            return $theme->setting_file_serve('loginbgimage', $args, $forcedownload, $options);
            break;

            case 'loginlogo' :
            return $theme->setting_file_serve('loginlogo', $args, $forcedownload, $options);
            break;

            case 'loadinglogo' :
            return $theme->setting_file_serve('loadinglogo', $args, $forcedownload, $options);
            break;

            case 'favicon' :
            return $theme->setting_file_serve('favicon', $args, $forcedownload, $options);
            break;

            case 'bannerimg' :
            return $theme->setting_file_serve('bannerimg', $args, $forcedownload, $options);
            break;

            default :
            send_file_not_found();
        }
    }
    else
    {
        send_file_not_found();
    }

}







/*
 *
 * Method to get array of css classes
 *
 */
function theme_mb2mcl_line_classes ($string, $id, $pref = '', $suff = '')
{

    $output = '';
    $blockStylesArr =  preg_split('/\r\n|\n|\r/', $string);

    if ($string !='')
    {
        foreach ($blockStylesArr as $line)
        {
            $lineArr = explode(':', $line);
            $prefArr = explode(',', $pref);

            if (trim($id) == trim($lineArr[0]))
            {
                $isPref1 = isset($prefArr[0]) ? $prefArr[0] : '';
                $output .= $prefArr[0] . $lineArr[1] . $suff;
            }

            if (isset($lineArr[2]))
            {
                if ( trim( $id ) == trim( $lineArr[0] ) )
                {
                    $isPref2 = isset($prefArr[1]) ? $prefArr[1] : '';
                    $output .= $isPref2 . $lineArr[2] . $suff;
                }
            }
        }
    }

    return $output;

}






/*
 *
 * Method to to get theme setting
 *
 */
function theme_mb2mcl_theme_setting ($page, $name, $default = '', $image = false, $theme= false)
{
    if ($theme)
    {
        if (!empty($theme->settings->$name))
        {
            if ($image === true)
            {
                $output = $theme->setting_file_url($name, $name);
            }
            else
            {
                $output = $theme->settings->$name;
            }
        }
        else
        {
            $output = $default;
        }
    }
    else
    {
        if (!empty($page->theme->settings->$name))
        {

            if ($image === true)
            {
                $output = $page->theme->setting_file_url($name, $name);
            }
            else
            {
                $output = $page->theme->settings->$name;
            }
        }
        else
        {
            $output = $default;
        }
    }

    return $output;

}






/*
 *
 * Method to get langauge list
 *
 */
function theme_mb2mcl_language_list ()
{

    global $PAGE, $OUTPUT, $CFG;

    $moodle33 = 2017051500;
    $output = '';
    $langs = get_string_manager()->get_list_of_translations();
    $strlang =  get_string('language');
    $currentlang = current_language();

    if (count($langs) == 1)
    {
        return ;
    }

    $langText = isset($langs[$currentlang]) ? $langs[$currentlang] : $strlang;
    $output .= '<ul class="language-list" style="display:none;">';

    foreach ($langs as $langtype => $langname)
    {
        if ($langtype)
        {
            $active_cls = '';

            if ($langtype === $currentlang)
            {
                $active_cls = 'active';
                continue;
            }

            $output .= '<li class="' . $active_cls . '">';
            $output .= '<a href="' . new moodle_url($PAGE->url, array('lang' => $langtype)) . '">';
            $output .= theme_mb2mcl_language_code($langtype);
            $output .= '</a>';
            $output .= '</li>';
        }
    }

    $output .= '</ul>';

    return $output;

}




/*
 *
 * Method to get language code
 *
 */
function theme_mb2mcl_language_code ($lang)
{

    $lang = strtoupper($lang);
    $lang = str_replace('_', ' ', $lang);
    return $lang;

}






/*
 *
 * Method to get my courses list
 *
 */
function theme_mb2mcl_mycourses_list()
{

    global $CFG, $PAGE;
    $output = '';
    $courses = theme_mb2mcl_get_mycourses();
    $limit = theme_mb2mcl_theme_setting($PAGE, 'mcnamelimit', 6);
    $alllink = $CFG->version >= 2022041900 ? new moodle_url( '/my/courses.php', array() ) : '#'; // Since Moodle 4

    if (!count($courses))
    {
        return;
    }

    $output .= '<li class="level-1 mycourses dropdown">';

    $output .= '<a href="' . $alllink . '" title="' . get_string('mycourses') . '">';
    $output .= '<span class="text">' . get_string('mycourses') . '</span><span class="menu-icon"><i class="lni-library"></i></span><span class="mycourses-num">(' . count($courses) . ')</span>';
    $output .= '<span class="mobile-arrow"></span>';
    $output .= '</a>';

    $output .= '<ul class="dropdown-list">';

    foreach ($courses as $c)
    {
        $course_url = new moodle_url('/course/view.php?id=' . $c['id']);
        $coursename = strip_tags(format_text($c['fullname']));

        $output .= '<li class="visible' . $c['visible'] . ' ' . $c['roles'] . '">';
        $output .= '<a href="' . $course_url . '" title="' . $coursename . '">';
        $output .= theme_mb2mcl_wordlimit($coursename, $limit);
        $output .= '</a>';
        $output .= '</li>';
    }

    $output .= '</ul>';
    $output .= '</li>';

    return $output;

}




/*
 *
 * Method to check if is my course list
 *
 */
function theme_mb2mcl_get_mycourses ()
{
    global $USER;
    $my_courses = enrol_get_my_courses();
    $courses = array();

    foreach ($my_courses as $c)
    {
        $course_access = theme_mb2mcl_site_access($c->id);

        if (!$c->visible && !in_array($course_access, array('admin', 'manager', 'editingteacher')))
        {
            continue;
        }

        $courses[] = array( 'id' => $c->id, 'fullname' => $c->fullname, 'visible' => $c->visible,
        'roles' => implode(' ', theme_mb2mcl_get_user_course_roles($c->id, $USER->id) ) );
    }

    return $courses;

}




/*
 *
 * Method to get safe url string
 *
 */
function theme_mb2mcl_string_url_safe($string)
{

    // Remove any '-' from the string since they will be used as concatenaters
    $output = str_replace('-', ' ', $string);

    // Trim white spaces at beginning and end of alias and make lowercase
    $output = trim(mb_strtolower($output));

    // Remove any duplicate whitespace, and ensure all characters are alphanumeric
    //$output = preg_replace('/(\s|[^A-Za-z0-9\-])+/', '-', $output);
   $output = preg_replace('#[^\w\d_\-\.]#iu', '-', $output);

    // Trim dashes at beginning and end of alias
    $output = trim($output, '-');

    return $output;

}






/*
 *
 * Method to get logo url
 *
 *
 */
function theme_mb2mcl_logo_url($page, $customLogo = '', $login = true)
{

    global $OUTPUT, $CFG, $DB;
    $moodle33 = 2017051500;

    // Url to default logo image
    $defaultLogo = theme_mb2mcl_theme_setting( $page, 'headerstyle' ) === 'color'
    ? $OUTPUT->image_url( 'logo-default-dark', 'theme' ) : $OUTPUT->image_url( 'logo-default', 'theme' );

    // Check if is custom login page
    $customLoginPage = theme_mb2mcl_is_login($page, true);

    if ($login && $customLoginPage && theme_mb2mcl_theme_setting($page,'loginlogo','', true) !='')
    {
        $isCustomLogo = theme_mb2mcl_theme_setting($page,'loginlogo','', true);
    }
    else
    {
        $isCustomLogo = $customLogo !='' ? $customLogo : theme_mb2mcl_theme_setting($page,'logo','', true);
    }

    $logoUrl = $isCustomLogo !='' ? $isCustomLogo : $defaultLogo;

    /**
     * Customization lmsdoctor.
     * Display logo based on the company selected.
     *
     * @author LMS Doctor <support@lmsdoctor.com>
     * @since  03.12.2025
     */
    if ($companyid = iomad::get_my_companyid(context_system::instance(), false)) {
        if ($companyid != '-1') {
            $company = new company($companyid);
            $logoUrl = company::get_logo_url($companyid, null, 75);
        } else {
            $companycode = optional_param('code', 1, PARAM_TEXT);
            $companyid = $DB->get_field('company', 'id', ['code' => $companycode]);
            $company = new company($companyid);
            $logoUrl = company::get_logo_url($companyid, null, 200);
        }
    }

    return $logoUrl;

}




/*
 *
 * Method to get page background image
 *
 *
 */
function theme_mb2mcl_pagebg_image($page)
{

    global $OUTPUT, $CFG, $DB;
    $moodle33 = 2017051500;
    $pageBgUrl = '';

    // Url to page background image
    $pageBgDef = $CFG->version >= $moodle33 ? $OUTPUT->image_url('pagebg/default','theme') : $OUTPUT->pix_url('pagebg/default','theme');
    $pageBgLoginDef = $CFG->version >= $moodle33 ? $OUTPUT->image_url('pagebg/default-login','theme') : $OUTPUT->pix_url('pagebg/default-login','theme');
    $pageBg = theme_mb2mcl_theme_setting($page, 'pbgimage', '', true);
    $pageBgPre = theme_mb2mcl_theme_setting($page, 'pbgpre', '');
    $pageBgLogin = theme_mb2mcl_theme_setting($page, 'loginbgimage', '', true);
    $pageBgLoginPre = theme_mb2mcl_theme_setting($page, 'loginbgpre', '');

    // Check if is custom login page
    $customLoginPage = theme_mb2mcl_is_login($page, true);


    if ($customLoginPage && ($pageBgLogin || $pageBgLoginPre === 'default'))
    {
        if ($pageBgLogin)
        {
            $pageBgUrl = $pageBgLogin;
        }
        elseif ($pageBgLoginPre === 'default')
        {
            $pageBgUrl = $pageBgLoginDef;
        }
    }
    elseif ($pageBg)
    {
        $pageBgUrl = $pageBg;
    }
    elseif ($pageBgPre === 'default')
    {
        $pageBgUrl = $pageBgDef;
    }

    /**
     * Customization lmsdoctor.
     * Display logo based on the company selected.
     *
     * @author LMS Doctor <support@lmsdoctor.com>
     * @since  03.12.2025
     */
    if ($companyid = iomad::get_my_companyid(context_system::instance(), false)) {
        if ($companyid == '-1') {
            $companycode = optional_param('code', 1, PARAM_TEXT);
            $companyid = $DB->get_field('company', 'id', ['code' => $companycode]);
            $company = new company($companyid);
            $pageBgUrl = company::get_login_background_url($companyid);

        }
    }

    return $pageBgUrl !='' ? ' style="background-image:url(\'' . $pageBgUrl . '\');"' : '';

}






/*
 *
 * Method to get loading screen
 *
 *
 */
function theme_mb2mcl_loading_screen($page)
{

    global $OUTPUT, $SITE;
    $output = '';
    $logo_height = theme_mb2mcl_theme_setting($page,'loadinglogoh');
    $bg_color = theme_mb2mcl_theme_setting($page,'lbgcolor');

    $style_bg_color = $bg_color !=='' ? ' style="background-color:' . $bg_color . ';"' : '';
    $style_logo_height = $logo_height !== '' ? ' style="max-height:' . $logo_height. 'rem;"' : '';

    if (!is_siteadmin())
    {
        $output .= '<div class="loading-scr" data-hideafter="' . theme_mb2mcl_theme_setting($page, 'loadinghide',600) . '"' . $style_bg_color . '>';
        $output .= '<div class="loading-scr-inner">';
        $output .= '<img class="loading-scr-logo" src="' .
        theme_mb2mcl_logo_url($page, theme_mb2mcl_theme_setting($page,'loadinglogo','', true), false) . '" alt="' . $SITE->shortname . '"' . $style_logo_height . '>';
        $output .= '<div class="loading-scr-spinner"><img src="' . theme_mb2mcl_loading_spinner() . '" alt="' . get_string('loading','theme_mb2mcl') . '" style="width:' . theme_mb2mcl_theme_setting($page, 'spinnerw', 50) . 'px;"></div>';
        $output .= '</div>';
        $output .= '</div>';
    }

    return $output;

}





/*
 *
 * Method to get spinner svg image
 *
 *
 */
function theme_mb2mcl_loading_spinner ()
{

    global $CFG;
    $output = '';

    $spinnerDir = $CFG->dirroot . '/theme/mb2mcl/pix/spinners/';
    $spinnerCustomDir = $CFG->dirroot . '/theme/mb2mcl/pix/spinners/custom';

    $spinner = theme_mb2mcl_random_image($spinnerDir, 'spinners', array('gif','svg'));
    $spinnerCustom = theme_mb2mcl_random_image($spinnerCustomDir, 'spinners/custom', array('gif','svg'));

    $output = $spinnerCustom ? $spinnerCustom : $spinner;

    return $output;

}






/*
 *
 * Method to get loading screen
 *
 */
function theme_mb2mcl_scrolltt($page)
{

    global $OUTPUT, $SITE;

    $output = '';

    $output .= '<a class="theme-scrolltt" href="#" title="' . get_string('scrolltotop', 'theme_mb2mcl') . '"><span><i class="fa fa-angle-up" data-scrollspeed="' .
    theme_mb2mcl_theme_setting($page, 'scrollspeed',400) . '"></i></span></a>';

    return $output;

}








/*
 *
 * Method to get icon navigation
 *
 *
 */
function theme_mb2mcl_iconnav($page)
{

    $iconnavs = theme_mb2mcl_theme_setting($page, 'navicons');

    if ($iconnavs !='')
    {
        return theme_mb2mcl_static_content($iconnavs, array( 'listcls' => 'theme-iconnav' ) );
    }

}




/*
 *
 * Method to get Gogole Analytics code
 *
 *
 */
function theme_mb2mcl_ganalytics($page, $type = 1)
{

    $output = '';
    $codeId = theme_mb2mcl_theme_setting($page, 'ganaid');
    $codeAsync = theme_mb2mcl_theme_setting($page, 'ganaasync', 0);

    if ($codeId !='')
    {
        //Alternative async tracking snippet
        if($codeAsync == 1)
        {
            $output .= '<script>';
            $output .= 'window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;';
            $output .= 'ga(\'create\', \'' . $codeId . '\', \'auto\');';
            $output .= 'ga(\'send\', \'pageview\');';
            $output .= '</script>';
            $output .= '<script async src=\'https://www.google-analytics.com/analytics.js\'></script>';
        }
        else
        {
            $output .= '<script>';
            $output .= '(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){';
            $output .= '(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),';
            $output .= 'm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)';
            $output .= '})(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');';
            $output .= 'ga(\'create\', \'' . $codeId . '\', \'auto\');';
            $output .= 'ga(\'send\', \'pageview\');';
            $output .= '</script>';
            $output .= '';
        }
    }

    return $output;


}






/*
 *
 * Method to get favicon
 *
 *
 */
function theme_mb2mcl_favicon ($page)
{

    global $OUTPUT, $CFG;

    $output = '';
    $moodle33 = ($CFG->version >= 2017051500);
    $favImg = $CFG->dirroot . '/theme/mb2mcl/pix/favicon/favicon-16x16.ico';

    // Additional favicons
    $favDeskDir = $CFG->dirroot . '/theme/mb2mcl/pix/favicon/desktop/';
    $favMobDir = $CFG->dirroot . '/theme/mb2mcl/pix/favicon/mobile/';
    $deskIcons = theme_mb2mcl_file_arr($favDeskDir, array('png'));
    $mobIcons = theme_mb2mcl_file_arr($favMobDir, array('png'));

    return $output;

}







/*
 *
 * Method to display sho/hide sidebar button
 *
 *
 */
function theme_mb2mcl_show_hide_sidebars ($page, $vars = array())
{

    $output = '';

    $sidebarBtn = theme_mb2mcl_theme_setting($page,'sidebarbtn');
    $showSdebar = ($sidebarBtn == 1 || $sidebarBtn == 2);

    if (isset($vars['sidebar']) && $vars['sidebar'] && $showSdebar)
    {
        $output .= '<a href="#" class="theme-hide-sidebar mode' . $sidebarBtn . '" data-showtext="' . get_string('showsidebar','theme_mb2mcl') . '" data-hidetext="' .
        get_string('hidesidebar','theme_mb2mcl') . '">';
        $output .= $sidebarBtn == 2 ? get_string('showsidebar','theme_mb2mcl') : get_string('hidesidebar','theme_mb2mcl');
        $output .= '</a>';
    }

    return $output;

}








/*
 *
 * Method to add body class to idetntify moodle version in js files
 *
 *
 */
function theme_mb2mcl_midentify($vars = array())
{

    global $CFG;
    $classes = array();

    // Moodle 3.8+ class
    if ( $CFG->version >= 2019111800 )
    {
        $classes[] = 'css_rbxt';
    }

    // Moodle 4.0+ class
    if ( $CFG->version >= 2022041900 )
    {
        $classes[] = 'css_6wum';
    }

    // Class for all moodle before 4.0
    if ( $CFG->version < 2022041900 )
    {
        $classes[] = 'css_f8a4';
    }

    // Moodle 4.2 + class
    if ( $CFG->version >= 2023042400 )
    {
        $classes[] = 'css_hy9f';
    }

    // Moodle 4.3
    if ( $CFG->version >= 2023100900 )
    {
        $classes[] = 'css_31a2';
    }

    // Moodle 4.4
    if ( $CFG->version >= 2024042200 )
    {
        $classes[] = 'css_af5e';
    }

    return $classes;

}






/*
 *
 * Method to get all plugins array
 *
 *
 */
function theme_mb2mcl_plugins_arr()
{

    global $CFG;

    $output = [
        'mb2shortcodes_filter' => ['text' => get_string('mb2shortcodes_filter_plugin','theme_mb2mcl'), 'file' =>
        $CFG->dirroot . '/filter/mb2shortcodes/version.php'],
    ];

    return $output;

}





/*
 *
 * Method to check if plugins are installed
 *
 */
 function theme_mb2mcl_check_plugins()
 {

     $output = '';
     $plugins = theme_mb2mcl_plugins_arr();
     $show_alert = 0;

     foreach ( $plugins as $id => $plugin ) {
         $show_alert = !file_exists($plugin['file']);

         if ($id === 'mb2shortcodes_filter' && !theme_mb2mcl_check_shortcodes_filter()) {
             $show_alert = 1;
         }
//var_dump($show_alert);
         if ($show_alert) {
             $output .= '<div class="alert alert-warning" role="alert">' . $plugin['text'] . '</div>';
         }
     }

     return $output;

 }






/*
 *
 * Method to get shot text from string
 *
 *
 */
function theme_mb2mcl_wordlimit( $string, $limit = 999, $end = '...' )
{

    $output = $string;

    if ( $limit >= 999 )
    {
        return $output;
    }

    $content_limit = strip_tags( $string );
    $words = explode( ' ', $content_limit );
    $words_count = count( $words );
    $new_string = implode( ' ', array_splice( $words, 0, $limit ) );
    $end_char = ( $end !== '' && $words_count > $limit ) ? $end : '';
    $output = $new_string . $end_char;

    return $output;

}





/*
 *
 * Method to check moodle version
 *
 */
function theme_mb2mcl_moodle_from ($version)
{
    global $CFG;

    if ($CFG->version >= $version)
    {
        return true;
    }

    return false;
}




/*
 *
 * Method to check if user has role
 *
 */
function theme_mb2mcl_is_user_role($courseid, $roleid, $userid = 0)
{

     $roles = get_user_roles(context_course::instance($courseid), $userid, false);

     foreach ($roles as $role)
     {
          if ($role->roleid == $roleid)
          {
              return true;
          }
     }

    return false;
}






/*
 *
 * Method to add font icon class prefix
 *
 */
function theme_mb2mcl_font_icon_prefix($icon)
{

    $output = '';

    $isfa = (preg_match('@fa-@', $icon) && !preg_match('@fa fa-@', $icon));
    $isglyph = (preg_match('@glyphicon-@', $icon) && !preg_match('@glyphicon glyphicon-@', $icon));

    if ($isfa)
    {
       $output = 'fa ';
    }
    elseif ($isglyph)
    {
       $output = 'glyphicon ';
    }

    return $output;

}





/*
 *
 * Method to set body class for course category theme
 *
 */
function theme_mb2mcl_page_title($coursename = true)
{

    global $PAGE, $COURSE;

    $title = '';
    $page_title = strip_tags( format_text( $PAGE->title ) );

    $itle_arr = explode(':', $page_title);

    if ($coursename && $COURSE->id > 1 && !preg_match('@course-view@', $PAGE->pagetype))
    {
        $title .= strip_tags( format_text( $COURSE->fullname ) ) . ': ';
    }

    $title .= end($itle_arr);

    return $title;

}




/*
 *
 * Method to get content from lines
 *
 */
function theme_mb2mcl_line_content($text)
{

    $output = '';
    $line = array();
    $content = array();
    $i = 0;

    // Explode new line
    $line_arr = preg_split('/\r\n|\n|\r/', trim($text));

    foreach ($line_arr as $line)
    {
        $i++;
        $line_arr = explode('|', trim($line));
        $line1 = $line_arr[0]; // Name and icon
        $line2 = isset($line_arr[1]) ? $line_arr[1] : ''; // Link and target attribute
        $line3 = isset($line_arr[2]) ? $line_arr[2] : ''; // Language codes
        $line4 = isset($line_arr[3]) ? $line_arr[3] : ''; // Logged in or none logged in users

        // Get sub array from line
        $text_arr = explode('::', trim($line1));
        $url_arr = explode('::', trim($line2));
        $lang_arr = $line3 ? explode(',', trim($line3)) : array();

        $content[$i]['text'] = trim($text_arr[0]);
        $content[$i]['icon'] = isset($text_arr[1]) ? trim($text_arr[1]) : '';
        $content[$i]['url'] = isset($url_arr[0]) ? trim($url_arr[0]) : '';
        $content[$i]['url_target'] = isset($url_arr[1]) ? trim($url_arr[1]) : 0;
        $content[$i]['lang'] = $lang_arr;
        $content[$i]['logged'] = trim($line4);
    }

    return $content;

}




/*
 *
 * Method to get static content top and bottom
 *
 */
function theme_mb2mcl_static_content( $text, $options = array() )
{

    $output = '';
    $i = 0;
    $content = theme_mb2mcl_line_content($text);
    $style = '';
    $listcls = '';
    $linkcls = '';
    $islist = isset( $options['nolist'] ) ? $options['nolist'] : true;

    if (isset($options['mt']))
    {
        $style = ' style="margin-top:' . trim($options['mt']) . 'px;"';
    }

    if ( isset( $options['listcls'] ) )
    {
        $listcls = ' ' . $options['listcls'];
    }

    if ( isset( $options['linkcls'] ) )
    {
        $linkcls = ' ' . $options['linkcls'];
    }

    $output .= $islist ? '<ul class="theme-static-content' . $listcls . '"' . $style . '>' : '';

    if ( isset( $options['first'] ) && $options['first'] )
    {
        $output .= '<li class="theme-static-item-first">';
        $output .= '<span class="text">' . $options['first'] . '</span>';
        $output .= '</li>';
    }

    foreach ( $content as $item )
    {

        $target = '';
        $icon_pref = '';

        // Check language
        if ( count( $item['lang'] ) > 0 && !in_array( current_language(), $item['lang'] ) )
        {
            continue;
        }

        // Check logged
        if ( $item['logged'] == 1 || $item['logged'] == 2 )
        {
            // Content for logged in users only
            if ( $item['logged'] == 1 && ( ! isloggedin() || isguestuser() ) )
            {
                continue;
            }
            // Content for none logged in users and gusets only
            elseif ( $item['logged'] == 2 && ( isloggedin() && ! isguestuser() ) )
            {
                continue;
            }
        }

        $i++;

        $output .= $islist ? '<li class="theme-static-item' . $i . '">' : '';

        if ($item['url'] && $item['url_target'])
        {
            $target = ' target="_blank"';
        }

        if ($item['icon'])
        {
            $icon_pref = theme_mb2mcl_font_icon_prefix($item['icon']);
        }

        $output .= $item['url'] ? '<a class="link-replace' . $linkcls . '" href="' . $item['url'] . '"' . $target . '>' : '<span class="link-replace">';
        $output .= $item['icon'] ? '<span class="static-icon"><i class="' . $icon_pref . $item['icon'] . '"></i></span>' : '';
        $output .= '<span class="text">' . $item['text'] . '</span>';
        $output .= $item['url'] ? '</a>' : '</span>';
        $output .= $islist ? '</li>' : '';

    }

    $output .= $islist ? '</ul>' : '';

    return $output;

}




/*
 *
 * Method to get static content top and bottom
 *
 */
function theme_mb2mcl_check_for_tags ($string, $tags = 'p|span|b|strong|i|u')
{

    $pattern = "/<($tags) ?.*>(.*)<\/($tags)>/";
    preg_match($pattern, $string, $matches);

    if (!empty($matches))
    {
        return true;
    }

    return false;
}



/*
 *
 * Method to set course layout body class
 *
 */
function theme_mb2mcl_course_layout_class()
{

    global $PAGE;
    $output = '';
    $is_course_cat = ($PAGE->pagetype === 'course-index-category' && theme_mb2mcl_theme_setting($PAGE, 'coursegridcat'));
    $is_course_fp = ($PAGE->pagetype === 'site-index' && theme_mb2mcl_theme_setting($PAGE, 'coursegridfp'));

    if ($is_course_cat || $is_course_fp)
    {
        return 'course-layout-grid';
    }

    return ;

}



/*
 *
 * Method to get course categor layout switcher
 *
 */
function theme_mb2mcl_course_layout_switcher()
{
    global $PAGE;
    $output = '';
    $is_course_cat = ($PAGE->pagetype === 'course-index-category' && theme_mb2mcl_theme_setting($PAGE, 'coursegridcat'));
    $is_course_fp = ($PAGE->pagetype === 'site-index' && theme_mb2mcl_theme_setting($PAGE, 'coursegridfp'));
    $actice_cls_grid = '';
    $actice_cls_list = ' active';

    if ($is_course_cat || $is_course_fp)
    {
        $actice_cls_grid = ' active';
        $actice_cls_list = '';
    }

    $output .= '<div class="course-layout-switcher">';
    $output .= '<a href="#" class="grid-layout' . $actice_cls_grid . '" title="' .
    get_string('layoutgrid', 'theme_mb2mcl') . '" data-toggle="tooltip" data-trigger="hover"><i class="fa fa-th-large"></i></a>';
    $output .= '<a href="#" class="list-layout' . $actice_cls_list . '" title="' .
    get_string('layoutlist', 'theme_mb2mcl') . '" data-toggle="tooltip" data-trigger="hover"><i class="fa fa-th-list"></i></a>';
    $output .= '</div>';

    return $output;

}


/*
 *
 * Method to check for front page courses
 *
 */
function theme_mb2mcl_frontpage_courses()
{

    global $CFG;

    $loggedin_arr = explode(',', $CFG->frontpageloggedin);
    $noneloggedin_arr = explode(',', $CFG->frontpage);

    if (isloggedin() && !isguestuser())
    {
        if (in_array(6, $loggedin_arr))
        {
            return true;
        }
    }
    else
    {
        if (in_array(6, $noneloggedin_arr))
        {
            return true;
        }
    }

    return false;

}




/*
 *
 * Method to check if shortcodes filter is activated
 *
 */
function theme_mb2mcl_check_shortcodes_filter() {
    global $DB;

    // Get array of active filters.
    $sql = 'SELECT * FROM {filter_active} WHERE ' . $DB->sql_like('filter', '?') . ' AND active=?';

    if ($DB->record_exists_sql($sql, ['mb2shortcodes', 1])) {
        return true;
    }

    return false;

}






/*
 *
 * Method to get param value from url
 *
 */
function theme_mb2mcl_get_url_param ($url, $param = 'id')
{
    $parts = parse_url($url);
    parse_str($parts['query'], $query);

    if (isset($query[$param]))
    {
        return $query[$param];
    }

    return null;

}



/*
 *
 * Method to get user details by user id
 *
 */
function theme_mb2mcl_get_user_details ($id, $detail = 1, $options = array('size'=>148))
{
    global $OUTPUT, $DB, $USER;

    if (!$id)
    {
        $id = $USER->id;
    }

    $user = $DB->get_record('user', array('id'=>$id));

    if ($detail == 1)
    {
        return $OUTPUT->user_picture($user, $options);
    }
    elseif ($detail == 2)
    {
        return $user->firstname . ' ' . $user->lastname;
    }

}





/*
 *
 * Method to get lighten/darken color
 *
 */
function theme_mb2mcl_luminance ($hex, $percent)
{

    // Make sure that we have hex color
    if (preg_match('@rgb@', $hex))
    {
        $hex = theme_mb2mcl_rgb_to_hex($hex);
    }

    // validate hex string
    $hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
    $new_hex = '#';

    if ( strlen( $hex ) < 6 ) {
        $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
    }

    // convert to decimal and change luminosity
    for ($i = 0; $i < 3; $i++) {
        $dec = hexdec( substr( $hex, $i*2, 2 ) );
        $dec = min( max( 0, $dec + $dec * $percent ), 255 );
        $new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
    }

    return $new_hex;

}



function theme_mb2mcl_rgb_to_hex($color)
{
    $pattern = "/(\d{1,3})\,?\s?(\d{1,3})\,?\s?(\d{1,3})/";

    // Only if it's RGB
    if ( preg_match( $pattern, $color, $matches ) )
    {
        $r = $matches[1];
          $g = $matches[2];
          $b = $matches[3];
          $color = sprintf("#%02x%02x%02x", $r, $g, $b);
    }

    return $color;
}






/*
 *
 * Method to check if is course module context
 *
 */
function theme_mb2mcl_is_module_context()
{

    global $PAGE;

    $context = $PAGE->context;

    if ($context->contextlevel == CONTEXT_MODULE)
    {
        return true;
    }

    return false;

}





/*
 *
 * Method to check if abcd columns has content
 *
 */
function theme_mb2mcl_is_footer_columns()
{
    global $PAGE;

    $a = theme_mb2mcl_isblock($PAGE, 'bottom-a');
    $b = theme_mb2mcl_isblock($PAGE, 'bottom-b');
    $c = theme_mb2mcl_isblock($PAGE, 'bottom-c');
    $d = theme_mb2mcl_isblock($PAGE, 'bottom-d');

    if ( $a || $b || $c || $d )
    {
        return true;
    }

    return false;

}






/*
 *
 * Method to check if sidebar appears
 *
 */
function theme_mb2mcl_is_sidebar()
{
    global $PAGE;

    if ( theme_mb2mcl_isblock( $PAGE, 'page-sidebar' ) && ! theme_mb2mcl_is_login( $PAGE, true ) || theme_mb2mcl_is_toc() )
    {
        return true;
    }

    return false;

}





/*
 *
 * Method to get array of file area images
 *
 */
function theme_mb2mcl_get_fileareaimages( $filearea = null )
{

    global $CFG;
    $images = array();

    if ( ! $filearea )
    {
        return;
    }

    require_once( $CFG->libdir . '/filelib.php' );
    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files( $context->id, 'theme_mb2mcl', $filearea, 0, 'itemid, filepath, filename', false );

    foreach ( $files as $f )
    {
        if ( $f->is_valid_image() )
        {
            $images[] = moodle_url::make_pluginfile_url(
                $f->get_contextid(), $f->get_component(), $f->get_filearea(), $f->get_itemid(), $f->get_filepath(), $f->get_filename(), false );
        }
    }


    return $images;

}





/*
 *
 * Method to different span in text
 *
 */
function theme_mb2mcl_get_highlight_text( $text, $class = 'thintext' )
{

    $newtitle = '';
    $i = 0;

    if ( preg_match( '@|@', $text ) == 0 )
    {
        return $text;
    }

    $titlearr = explode('|', $text);
    $titlearr = array_map( 'trim', $titlearr );

    if ( ! isset( $titlearr[1] ) )
    {
        return $text;
    }

    $newtitle = $titlearr[0];

    foreach ( $titlearr as $el )
    {
        $i++;

        if ( $i == 1 )
        {
            continue;
        }

        $newtitle = str_replace( $el, '<span class="' . $class . '">' . $el . '</span>', $newtitle );
    }

    return $newtitle;

}



/*
 *
 * Method to get user roles
 *
 */
function theme_mb2mcl_get_user_roles( $userid = null )
{
    global $DB;
    $roles = array();

    if ( ! $userid )
    {
        return $roles;
    }

    $roles = $DB->get_records_list('role_assignments', 'userid', array('userid' => $userid ), '', 'id,contextid,roleid');

    return $roles;

}





/*
 *
 * Method to get user roles
 *
 */
function theme_mb2mcl_get_user_course_roles( $courseid = null, $userid = null )
{
    global $DB;
    $courseroles = array();

    if ( ! $userid || ! $courseid )
    {
        return array();
    }

    $context = context_course::instance( $courseid );
    $userroles = theme_mb2mcl_get_user_roles( $userid );

    foreach ( $userroles as $userrole )
    {
        if ( $context->id == $userrole->contextid )
        {
            $courseroles[] = theme_mb2mcl_get_role_shortname( $userrole->roleid );
        }
    }

    return $courseroles;

}





/*
 *
 * Method to get user role shortname
 *
 */
function theme_mb2mcl_get_role_shortname( $roleid = null )
{

    if ( ! $roleid )
    {
        return ;
    }

    $roles = get_all_roles();

    foreach ( $roles as $role )
    {
        if ( $roleid == $role->id )
        {
            return $role->shortname;
        }
    }

}




/*
 *
 * Method to get header actions
 *
 */
function theme_mb2mcl_header_actions()
{
    global $PAGE;

    $output = '';

    if ( ! theme_mb2mcl_moodle_from( 2020110900 ) )
    {
        return;
    }

    foreach ( $PAGE->get_header_actions() as $a )
    {
        $output .= $a;
    }

    return $output;

}



/*
 *
 * Method to check if front page is empty
 *
 */
function theme_mb2mcl_user_preference($name, $def = '', $type = PARAM_TEXT)
{
    global $CFG;

    // Moodle 4.3
    if ( $CFG->version >= 2023100900 && ( ! isloggedin() || isguestuser() ) )
    {
        // Get cookie
        if ( isset( $_COOKIE[$name] ) )
        {
            return clean_param( $_COOKIE[$name], $type );
        }

        return;
    }

    return get_user_preferences($name, $def);
}



/**
 * Get the current user preferences that are available
 *
 * @return array[]
 */
function theme_mb2mcl_user_preferences(){

    $pref = array();

    return $pref;

}



/*
 *
 * Method to set PHP variables fro jsvascript
 *
 */
function theme_mb2mcl_php2js()
{

    global $CFG;

    $output = '';

    $output .= '<div class="php2js" ';
    $output .= 'data-scp="' . $CFG->sessioncookiepath . '"'; // Session cookie path
    $output .= '></div>';

    return $output;

}



/**
 *
 * Method to set data attributes for ajax requests
 *
 */
function theme_mb2mcl_ajax_data_atts() {
    global $CFG, $PAGE;

    $data = '';

    $sectionid = preg_match('@section-@', $PAGE->pagetype) ? optional_param('id', 0, PARAM_INT) : 0;

    if ($CFG->version < 2024042200) {
        $sectionid = optional_param('section', 0, PARAM_INT);
    }

    $modid = is_object($PAGE->cm) && $PAGE->cm->id ? $PAGE->cm->id : 0;
    $sid = is_object($PAGE->cm) ? $PAGE->cm->section : 0;

    $data .= ' data-mod_id="' . $modid . '"';
    $data .= ' data-mod_sid="' . $sid . '"';
    $data .= ' data-uparam_sid="'. $sectionid .'"';

    return $data;
}
