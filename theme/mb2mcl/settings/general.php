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


$temp = new admin_settingpage('theme_mb2mcl_settingsgeneral',  get_string('settingsgeneral', 'theme_mb2mcl'));

$headerStyleOpt = array(
	'light' => get_string('light','theme_mb2mcl'),
	'color' => get_string('color','theme_mb2mcl')
);

$setting = new admin_setting_configmb2start2('theme_mb2mcl/startlogo', get_string('logo','theme_mb2mcl'));
$temp->add($setting);


	$name = 'theme_mb2mcl/logo';
	$title = get_string('logoimg','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configstoredfile($name, $title, $desc, 'logo');
	$temp->add($setting);

	$name = 'theme_mb2mcl/logoh';
	$title = get_string('logoh','theme_mb2mcl');
	$desc = get_string('logohdesc', 'theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title, $desc, 2.9);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mcl/logomtb';
	$title = get_string('logomtb','theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title, '', 1);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mcl/logotitle';
	$title = get_string('logotitle','theme_mb2mcl');
	$desc = get_string('logotitledesc', 'theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title, $desc, 'Macro Learning Theme');
	$temp->add($setting);

	$name = 'theme_mb2mcl/logoalttext';
	$title = get_string('logoalttext','theme_mb2mcl');
	$desc = get_string('logoalttextdesc', 'theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title, $desc, 'Macro Learning Theme');
	$temp->add($setting);

	$name = 'theme_mb2mcl/logospacer';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mcl/favicon';
	$title = get_string('favicon','theme_mb2mcl');
	$desc = get_string('favicondesc', 'theme_mb2mcl');
	$setting = new admin_setting_configstoredfile($name, $title, $desc, 'favicon', 0, array('accepted_types'=>array('.ico')));
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endlogo');
$temp->add($setting);



$setting = new admin_setting_configmb2start2('theme_mb2mcl/startlayout', get_string('layout','theme_mb2mcl'));
$temp->add($setting);


	$name = 'theme_mb2mcl/pagewidth';
	$title = get_string('pagewidth','theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title, '', 1320);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$layoutArr = array(
		'fw' => get_string('layoutfw','theme_mb2mcl'),
		'fx' => get_string('layoutfx','theme_mb2mcl')
	);
	$name = 'theme_mb2mcl/layout';
	$title = get_string('layout','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'fw', $layoutArr);
	$temp->add($setting);

	$name = 'theme_mb2mcl/layoutspacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$sidebarPosArr = array(
		'classic' => get_string('classic','theme_mb2mcl'),
		'left' => get_string('left','theme_mb2mcl'),
		'right' => get_string('right','theme_mb2mcl')
	);

	$name = 'theme_mb2mcl/sidebarpos';
	$title = get_string('sidebarpos','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'right', $sidebarPosArr);
	$temp->add($setting);

	$sidebarBtArr = array(
		0 => get_string('none','theme_mb2mcl'),
		1 => get_string('sidebaryesshow','theme_mb2mcl'),
		2 => get_string('sidebaryeshide','theme_mb2mcl')
	);

	$name = 'theme_mb2mcl/sidebarbtn';
	$title = get_string('sidebarbtn','theme_mb2mcl');
	$setting = new admin_setting_configselect($name, $title, '', 0, $sidebarBtArr);
	$temp->add($setting);

	$name = 'theme_mb2mcl/layoutspacer2';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$pageSidebarArr = array(
		'none' => get_string('none','theme_mb2mcl'),
		'left' => get_string('left','theme_mb2mcl'),
		'right' => get_string('right','theme_mb2mcl')
	);

	$name = 'theme_mb2mcl/pagesidebar';
	$title = get_string('pagesidebar','theme_mb2mcl');
	$setting = new admin_setting_configselect($name, $title, '', 'left', $pageSidebarArr);
	$temp->add($setting);

	$name = 'theme_mb2mcl/sidebarw';
	$title = get_string('sidebarw','theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title, '', 345);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endlayout');
$temp->add($setting);


$setting = new admin_setting_configmb2start2('theme_mb2mcl/startheaderstyle', get_string('headerstyleheading','theme_mb2mcl'));
$temp->add($setting);

	$name = 'theme_mb2mcl/headerstyle';
	$title = get_string('headerstyle','theme_mb2mcl');
	$setting = new admin_setting_configselect($name, $title, '', 'light', $headerStyleOpt);
	$temp->add($setting);

	$name = 'theme_mb2mcl/stickyheader';
	$title = get_string('stickyheader','theme_mb2mcl');
	$setting = new admin_setting_configselect( $name, $title, '', 2, array(
		0 => get_string('none','theme_mb2mcl'),
		1 => get_string('yes','theme_mb2mcl'),
		2 => get_string('stickyheader2','theme_mb2mcl')
	 ));
	$temp->add($setting);

	$name = 'theme_mb2mcl/navbarplugin';
	$title = get_string('navbarplugin','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title,'',1);
	$temp->add($setting);

	$name = 'theme_mb2mcl/headerspacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mcl/headerbtn';
	$title = get_string('headerbtn','theme_mb2mcl');
	$setting = new admin_setting_configtextarea($name, $title, get_string('headerbtndesc','theme_mb2mcl'),'');
	$temp->add($setting);

	$name = 'theme_mb2mcl/headerspacer2';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mcl/banner';
	$title = get_string('banner','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);

	$name = 'theme_mb2mcl/bannerimg';
	$title = get_string('bannerimg','theme_mb2mcl');
	$desc = get_string('bannerimgdesc', 'theme_mb2mcl');
	$setting = new admin_setting_configstoredfile($name, $title, $desc, 'bannerimg', 0, array( 'maxfiles'=> 5 ));
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mcl/endheaderstyle');
$temp->add($setting);


$setting = new admin_setting_configmb2start2('theme_mb2mcl/startslider', get_string('frontpage','theme_mb2mcl'));
$temp->add($setting);

	$name = 'theme_mb2mcl/slider';
	$title = get_string('slider','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mcl/endslider');
$temp->add($setting);


$setting = new admin_setting_configmb2start2('theme_mb2mcl/startcourse', get_string('coursesettings','theme_mb2mcl'));
$temp->add($setting);

	$name = 'theme_mb2mcl/coursegridfp';
	$title = get_string('coursegridfp','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);


	$name = 'theme_mb2mcl/coursegridcat';
	$title = get_string('coursegridcat','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);


	$name = 'theme_mb2mcl/courseswitchlayout';
	$title = get_string('courseswitchlayout','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);

	$name = 'theme_mb2mcl/coursespacer3';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mcl/coursetoc';
    $title = get_string('coursetoc','theme_mb2mcl');
    $setting = new admin_setting_configcheckbox($name, $title, '', 1);
    $temp->add($setting);

	$name = 'theme_mb2mcl/coursespacer17';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mcl/cbannerimg';
	$title = get_string('cbannerstyle','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);


	$name = 'theme_mb2mcl/courseplimg';
	$title = get_string('courseplimg','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);

	$name = 'theme_mb2mcl/coursespacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mcl/coursebtn';
	$title = get_string('coursebtn','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title, '', 1);
	$temp->add($setting);


	$name = 'theme_mb2mcl/coursestudentscount';
	$title = get_string('coursestudentscount','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);


	$name = 'theme_mb2mcl/studentsroleid';
	$title = get_string('studentsroleid','theme_mb2mcl');
	$setting = new admin_setting_configtext($name,$title,'',5);
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mcl/endcourse');
$temp->add($setting);



$setting = new admin_setting_configmb2start2('theme_mb2mcl/startregions', get_string('regions','theme_mb2mcl'));
$temp->add($setting);

	$name = 'theme_mb2mcl/blockstyle';
	$title = get_string('blockstyle','theme_mb2mcl');
	$desc = get_string('blockstyledesc','theme_mb2mcl');
	$setting = new admin_setting_configtextarea($name, $title, $desc, '');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endregions');
$temp->add($setting);



$setting = new admin_setting_configmb2start2('theme_mb2mcl/startstatic', get_string('staticcontent','theme_mb2mcl'));
$temp->add($setting);

	$name = 'theme_mb2mcl/topinfo';
	$title = get_string('topinfo','theme_mb2mcl');
	$setting = new admin_setting_configtextarea($name, $title, get_string('staticinfodesc','theme_mb2mcl'),'');
	$temp->add($setting);

	$name = 'theme_mb2mcl/staticcontentspacer';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mcl/btninfo';
	$title = get_string('btinfo','theme_mb2mcl');
	$setting = new admin_setting_configtextarea($name, $title, get_string('staticinfodesc','theme_mb2mcl'),'');
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mcl/endstatic');
$temp->add($setting);



$setting = new admin_setting_configmb2start2('theme_mb2mcl/startfooter', get_string('footer','theme_mb2mcl'));
$temp->add($setting);

	$name = 'theme_mb2mcl/foottext';
	$title = get_string('foottext','theme_mb2mcl');
	$setting = new admin_setting_configtextarea($name, $title,'', '');
	$temp->add($setting);

	$name = 'theme_mb2mcl/footmenu';
	$title = get_string('footmenu','theme_mb2mcl');
	$setting = new admin_setting_configtextarea($name, $title, get_string('staticmenudesc','theme_mb2mcl'),'');
	$temp->add($setting);

	$name = 'theme_mb2mcl/footlogin';
	$title = get_string('footlogin','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configcheckbox($name, $title, $desc, 0);
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mcl/endfooter');
$temp->add($setting);



$settings->add($temp);
