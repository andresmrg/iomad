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

$temp = new admin_settingpage('theme_mb2mcl_settingsnav',  get_string('settingsnav', 'theme_mb2mcl'));

$setting = new admin_setting_configmb2start2('theme_mb2mcl/startnavgeneral', get_string('mainmenu','theme_mb2mcl'));
$temp->add($setting);

	// Navigation animation type
	$name = 'theme_mb2mcl/navatype';
	$title = get_string('navatype','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, '2', array('2'=>get_string('navatypeslide', 'theme_mb2mcl'),'1'=>get_string('navatypefade', 'theme_mb2mcl')));
	$temp->add($setting);


	// Navigation animation speed
	$name = 'theme_mb2mcl/navaspeed';
	$title = get_string('navaspeed','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configtext($name, $title, $desc,300);
	$temp->add($setting);


	// Navigation dropdown width
	$name = 'theme_mb2mcl/navddwidth';
	$title = get_string('navddwidth','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configtext($name, $title, $desc,184);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/mycinmenu';
	$title = get_string('mycinmenu','theme_mb2mcl');
	$setting = new admin_setting_configcheckbox($name, $title,'',1);
	$temp->add($setting);


	$name = 'theme_mb2mcl/mcnamelimit';
	$title = get_string('mcnamelimit','theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title,'',6);
	$temp->add($setting);


	$name = 'theme_mb2mcl/navcls';
	$title = get_string('navcls','theme_mb2mcl');
	$desc = get_string('navclsdesc','theme_mb2mcl');
	$setting = new admin_setting_configtextarea($name, $title, $desc, '');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endnavgeneral');
$temp->add($setting);


$setting = new admin_setting_configmb2start2('theme_mb2mcl/startnavicon', get_string('navicon','theme_mb2mcl'));
$temp->add($setting);


	$name = 'theme_mb2mcl/navicons';
	$title = get_string('links','theme_mb2mcl');
	$setting = new admin_setting_configtextarea($name, $title, get_string('naviconsdesc','theme_mb2mcl'), '');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endnavicon');
$temp->add($setting);


$settings->add($temp);
