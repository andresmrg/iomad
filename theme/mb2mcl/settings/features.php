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


$temp = new admin_settingpage('theme_mb2mcl_settingsfeatures',  get_string('settingsfeatures', 'theme_mb2mcl'));
$yesNoOptions = array('1'=>get_string('yes','theme_mb2mcl'), '0'=>get_string('no','theme_mb2mcl'));

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
	'default' => get_string('imgdefault','theme_mb2mcl'),
	'strip1'=>get_string('strip1','theme_mb2mcl'),
	'strip2'=>get_string('strip2','theme_mb2mcl'),
);



$setting = new admin_setting_configmb2start2('theme_mb2mcl/startaccessibility', get_string('accessibility','theme_mb2mcl'));
$temp->add($setting);

	$name = 'theme_mb2mcl/fontsizer';
	$title = get_string('fontsizer','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title,'', 0);
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mcl/endaccessibility');
$temp->add($setting);



$setting = new admin_setting_configmb2start2('theme_mb2mcl/startbookmarks', get_string('bookmarks','theme_mb2mcl'));
$temp->add($setting);

	$name = 'theme_mb2mcl/bookmarks';
	$title = get_string('bookmarks','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);

	$name = 'theme_mb2mcl/bookmarkslimit';
	$title = get_string('bookmarkslimit','theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title, '', 15);
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mcl/endbookmarks');
$temp->add($setting);


$setting = new admin_setting_configmb2start2('theme_mb2mcl/startcoursepanel', get_string('coursepanel','theme_mb2mcl'));
$temp->add($setting);


	$name = 'theme_mb2mcl/coursepanel';
	$title = get_string('coursepanel','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);

	$name = 'theme_mb2mcl/roleshortname';
	$title = get_string('roleshortname','theme_mb2mcl');
	$setting = new admin_setting_configtext($name,$title,'','editingteacher');
	$temp->add($setting);


	$name = 'theme_mb2mcl/teacheremail';
	$title = get_string('teacheremail','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);


	$name = 'theme_mb2mcl/teachermessage';
	$title = get_string('teachermessage','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);


	$name = 'theme_mb2mcl/cpaneldesclimit';
	$title = get_string('cpaneldesclimit','theme_mb2mcl');
	$setting = new admin_setting_configtext($name,$title,'',24);
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endcoursepanel');
$temp->add($setting);


$setting = new admin_setting_configmb2start2('theme_mb2mcl/startloading', get_string('loadingscreen','theme_mb2mcl'));
$temp->add($setting);


	$name = 'theme_mb2mcl/loadingscr';
	$title = get_string('loadingscreen','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title, get_string('loadingscrdesc', 'theme_mb2mcl'), 0);
	$temp->add($setting);


	$name = 'theme_mb2mcl/loadinghide';
	$title = get_string('loadinghide','theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title, '', 600);
	$temp->add($setting);


	$name = 'theme_mb2mcl/spinnerw';
	$title = get_string('spinnerw','theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title, '', 50);
	$temp->add($setting);


	$name = 'theme_mb2mcl/lbgcolor';
	$title = get_string('bgcolor','theme_mb2mcl');
	$setting = new admin_setting_configmb2color($name, $title, '', '');
	$temp->add($setting);


	$name = 'theme_mb2mcl/loadinglogo';
	$title = get_string('logoimg','theme_mb2mcl');
	$setting = new admin_setting_configstoredfile($name, $title, get_string('loadinglogodesc','theme_mb2mcl'), 'loadinglogo');
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mcl/loadinglogoh';
	$title = get_string('logoh','theme_mb2mcl');
	$desc = get_string('logohdesc', 'theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title, $desc, '');
	$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mcl/endloading');
$temp->add($setting);


$setting = new admin_setting_configmb2start2('theme_mb2mcl/startloginform', get_string('loginsearchform','theme_mb2mcl'));
$temp->add($setting);

	$name = 'theme_mb2mcl/loginlinktopage';
	$title = get_string('loginlinktopage','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);

	$name = 'theme_mb2mcl/loginlinks';
	$title = get_string('loginlinks','theme_mb2mcl');
	$setting = new admin_setting_configtextarea($name, $title, get_string('loginlinksdesc','theme_mb2mcl'), '');
	$temp->add($setting);


	$name = 'theme_mb2mcl/loginsocial';
	$title = get_string('loginsocial','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name,$title,'',0);
	$temp->add($setting);


	$name = 'theme_mb2mcl/loginsearchspacer';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);


	$name = 'theme_mb2mcl/searchlinks';
	$title = get_string('searchlinks','theme_mb2mcl');
	$setting = new admin_setting_configtextarea($name,$title,get_string('staticmenudesc','theme_mb2mcl'),'');
	$temp->add($setting);



$setting = new admin_setting_configmb2end('theme_mb2mcl/endloginform');
$temp->add($setting);


$setting = new admin_setting_configmb2start2('theme_mb2mcl/startlogin', get_string('pagelogin','theme_mb2mcl'));
$temp->add($setting);




		$name = 'theme_mb2mcl/cloginpage';
		$title = get_string('cloginpage','theme_mb2mcl');
		$setting = new admin_setting_configcheckbox($name, $title, '', 0);
		$temp->add($setting);


		$name = 'theme_mb2mcl/loginlogo';
		$title = get_string('logoimg','theme_mb2mcl');
		$desc = get_string('loginlogodesc','theme_mb2mcl');
		$setting = new admin_setting_configstoredfile($name, $title, $desc, 'loginlogo');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		$name = 'theme_mb2mcl/loginlogoh';
		$title = get_string('logoh','theme_mb2mcl');
		$desc = get_string('logohdesc', 'theme_mb2mcl');
		$setting = new admin_setting_configtext($name, $title, $desc, '');
		$temp->add($setting);


		$name = 'theme_mb2mcl/loginpgespacer';
		$setting = new admin_setting_configmb2spacer($name);
		$temp->add($setting);


		$name = 'theme_mb2mcl/loginbgcolor';
		$title = get_string('bgcolor','theme_mb2mcl');
		$setting = new admin_setting_configmb2color($name, $title, get_string('pbgdesc','theme_mb2mcl'), '');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		$name = 'theme_mb2mcl/loginbgpre';
		$title = get_string('pbgpre','theme_mb2mcl');
		$setting = new admin_setting_configselect($name, $title, '', 'default', $bgPredefinedOpt);
		$temp->add($setting);


		$name = 'theme_mb2mcl/loginbgimage';
		$title = get_string('bgimage','theme_mb2mcl');
		$setting = new admin_setting_configstoredfile($name, $title, get_string('pbgdesc','theme_mb2mcl'), 'loginbgimage');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		// $name = 'theme_mb2mcl/loginbgrepeat';
		// $title = get_string('bgrepeat','theme_mb2mcl');
		// $setting = new admin_setting_configselect($name, $title, '', 'no-repeat', $bgRepearOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


		// $name = 'theme_mb2mcl/loginbgpos';
		// $title = get_string('bgpos','theme_mb2mcl');
		// $setting = new admin_setting_configselect($name, $title, '', 'center bottom', $bgPositionOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


		// $name = 'theme_mb2mcl/loginbgattach';
		// $title = get_string('bgattachment','theme_mb2mcl');
		// $setting = new admin_setting_configselect($name, $title, '', 'fixed', $bgAttOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


		// $name = 'theme_mb2mcl/loginbgsize';
		// $title = get_string('bgsize','theme_mb2mcl');
		// $setting = new admin_setting_configselect($name, $title, '', 'cover', $bgSizeOpt);
		// $setting->set_updatedcallback('theme_reset_all_caches');
		// $temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endlogin');
$temp->add($setting);



$setting = new admin_setting_configmb2start2('theme_mb2mcl/startscrolltt', get_string('scrolltt','theme_mb2mcl'));
$temp->add($setting);


	$name = 'theme_mb2mcl/scrolltt';
	$title = get_string('scrolltt','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title,'', 1);
	$temp->add($setting);


	$name = 'theme_mb2mcl/scrollspeed';
	$title = get_string('scrollspeed','theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title, '', 400);
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endscrolltt');
$temp->add($setting);


$setting = new admin_setting_configmb2start2('theme_mb2mcl/startsitemenu', get_string('sitemenu','theme_mb2mcl'));
$temp->add($setting);


	$name = 'theme_mb2mcl/sitemnu';
	$title = get_string('sitemenu','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name,$title,'',1);
	$temp->add($setting);


	$name = 'theme_mb2mcl/sitemnuitems';
	$title = get_string('sitemnuitems','theme_mb2mcl');
	$setting = new admin_setting_configtextarea($name, $title,get_string('sitemnuitemsdesc','theme_mb2mcl'),'dashboard,frontpage,calendar,badges,mycourses,courses');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endsitemenu');
$temp->add($setting);


$setting = new admin_setting_configmb2start2('theme_mb2mcl/startganalitycs', get_string('ganatitle','theme_mb2mcl'));
$temp->add($setting);


	$name = 'theme_mb2mcl/ganaid';
	$title = get_string('ganaid','theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title,$title = get_string('ganaiddesc','theme_mb2mcl'), '');
	$temp->add($setting);


	$name = 'theme_mb2mcl/ganaasync';
	$title = get_string('ganaasync','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title,'', 0);
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endganalitycs');
$temp->add($setting);


$settings->add($temp);
