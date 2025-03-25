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


$temp = new admin_settingpage('theme_mb2mcl_settingsstyle',  get_string('settingsstyle', 'theme_mb2mcl'));



$bgPositionOpt = array(
	'center center'=>'center center',
	'left top'=>'left top',
	'left center'=>'left center',
	'left bottom'=>'left bottom',
	'right top'=>'right top',
	'right center'=>'right center',
	'right bottom'=>'right bottom',
	'center top'=>'center top',
	'center bottom'=>'center bottom'
);


$bgRepearOpt = array(
	'no-repeat'=>'no-repeat',
	'repeat'=>'repeat',
	'repeat-x'=>'repeat-x',
	'repeat-y'=>'repeat-y'
);


$bgSizeOpt = array(
	'cover'=>'cover',
	'auto'=>'auto',
	'contain'=>'contain'
);


$bgAttOpt = array(
	'scroll'=>'scroll',
	'fixed'=>'fixed',
	'local'=>'local'
);


$bgPredefinedOpt = array(
	''=>get_string('none','theme_mb2mcl'),
	'strip1'=>get_string('strip1','theme_mb2mcl'),
	'strip2'=>get_string('strip2','theme_mb2mcl'),
);


$bgPredefinedPageOpt = array(
	'' => get_string('none','theme_mb2mcl'),
	'default' => get_string('imgdefault','theme_mb2mcl'),
	'strip1'=>get_string('strip1','theme_mb2mcl'),
	'strip2'=>get_string('strip2','theme_mb2mcl'),
);


$colorSchemeOpt = array(
	'light' => get_string('light','theme_mb2mcl'),
	'dark' => get_string('dark','theme_mb2mcl'),
);


$setting = new admin_setting_configmb2start2('theme_mb2mcl/startcolors', get_string('colors','theme_mb2mcl'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2mcl/accent1';
	$title = get_string('accentcolor','theme_mb2mcl') . ' 1';
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#144858');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/accent2';
	$title = get_string('accentcolor','theme_mb2mcl') . ' 2';
	$setting = new admin_setting_configmb2color($name, $title, '', '#f3850c');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/accent3';
	$title = get_string('accentcolor','theme_mb2mcl') . ' 3';
	$setting = new admin_setting_configmb2color($name, $title, '', '#002030');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/stylespacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/textcolor';
	$title = get_string('textcolor','theme_mb2mcl');
	$setting = new admin_setting_configmb2color($name, $title, '', '#4d5156');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mcl/textcolor_lighten';
	$title = get_string('textcolor_lighten','theme_mb2mcl');
	$setting = new admin_setting_configmb2color($name, $title, '', '#888888');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	// $name = 'theme_mb2mcl/textcolor_footer';
	// $title = get_string('textcolor_footer','theme_mb2mcl');
	// $setting = new admin_setting_configmb2color($name, $title, '', '#afb0ad');
	// $setting->set_updatedcallback('theme_reset_all_caches');
	// $temp->add($setting);



	$name = 'theme_mb2mcl/linkcolor';
	$title = get_string('linkcolor','theme_mb2mcl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#f3850c');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/linkhcolor';
	$title = get_string('linkhcolor','theme_mb2mcl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#000000');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/headingscolor';
	$title = get_string('headingscolor','theme_mb2mcl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#144858');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/stylespacer2';
	$setting = new admin_setting_configmb2spacer($name);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/btncolor';
	$title = get_string('btncolor','theme_mb2mcl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#435764');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mcl/btnprimarycolor';
	$title = get_string('btnprimarycolor','theme_mb2mcl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#144858');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mcl/btnsecondarycolor';
	$title = get_string('btnsecondarycolor','theme_mb2mcl');
	$setting = new admin_setting_configmb2color($name, $title, $desc, '#f3850c');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endcolors');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);



$setting = new admin_setting_configmb2start2('theme_mb2mcl/startpagestyle', get_string('pagestyle','theme_mb2mcl'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2mcl/pbgpre';
	$title = get_string('pbgpre','theme_mb2mcl');
	$setting = new admin_setting_configselect($name, $title, '', '', $bgPredefinedPageOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/pbgcolor';
	$title = get_string('bgcolor','theme_mb2mcl');
	$setting = new admin_setting_configmb2color($name, $title, get_string('pbgdesc','theme_mb2mcl'), '');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/pbgimage';
	$title = get_string('bgimage','theme_mb2mcl');
	$setting = new admin_setting_configstoredfile($name, $title, get_string('pbgdesc','theme_mb2mcl'), 'pbgimage');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/pbgrepeat';
	$title = get_string('bgrepeat','theme_mb2mcl');
	$setting = new admin_setting_configselect($name, $title, '', 'no-repeat', $bgRepearOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/pbgpos';
	$title = get_string('bgpos','theme_mb2mcl');
	$setting = new admin_setting_configselect($name, $title, '', 'center center', $bgPositionOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/pbgattach';
	$title = get_string('bgattachment','theme_mb2mcl');
	$setting = new admin_setting_configselect($name, $title, '', 'fixed', $bgAttOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/pbgsize';
	$title = get_string('bgsize','theme_mb2mcl');
	$setting = new admin_setting_configselect($name, $title, '', 'cover', $bgSizeOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endpagestyle');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);



$setting = new admin_setting_configmb2start2('theme_mb2mcl/startcustomcssstyle', get_string('scustomcssstyleheading','theme_mb2mcl'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2mcl/customcss';
	$title = get_string('customcss','theme_mb2mcl');
	$setting = new admin_setting_configtextarea($name, $title, '', '');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	// $name = 'theme_mb2mcl/lessvars';
	// $title = get_string('lessvars','theme_mb2mcl');
	// $setting = new admin_setting_configtextarea($name, $title,get_string('lessvarsdesc','theme_mb2mcl'),'');
	// $setting->set_updatedcallback('theme_reset_all_caches');
	// $temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endcustomcssstyle');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);



$settings->add($temp);
