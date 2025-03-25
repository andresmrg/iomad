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


$temp = new admin_settingpage('theme_mb2mcl_settingssocial',  get_string('settingssocial', 'theme_mb2mcl'));


$setting = new admin_setting_configmb2start2('theme_mb2mcl/socialstart1', get_string('options','theme_mb2mcl'));
$temp->add($setting);

$name = 'theme_mb2mcl/socialheader';
$title = get_string('socialheader','theme_mb2mcl');
$desc = '';
$setting = new admin_setting_configcheckbox($name, $title, $desc, 0);
$temp->add($setting);


$name = 'theme_mb2mcl/socialfooter';
$title = get_string('socialfooter','theme_mb2mcl');
$desc = '';
$setting = new admin_setting_configcheckbox($name, $title, $desc, 0);
$temp->add($setting);



$name = 'theme_mb2mcl/sociallinknw';
$title = get_string('sociallinknw','theme_mb2mcl');
$desc = '';
$setting = new admin_setting_configcheckbox($name, $title, $desc, 0);
$temp->add($setting);

$name = 'theme_mb2mcl/socialtt';
$title = get_string('socialtt','theme_mb2mcl');
$desc = '';
$setting = new admin_setting_configcheckbox($name, $title, $desc, 0);
$temp->add($setting);

$setting = new admin_setting_configmb2end('theme_mb2mcl/socialend');
$temp->add($setting);

$socialnameChoices = array(
	'' => get_string('none','theme_mb2mcl'),
	'android,Android'=>'Android',
	'apple,App Store'=>'App Store',
	'dribbble,Dribbble'=>'Dribbble',
	'dropbox,Dropbox'=>'Dropbox',
	'envelope,Email' => 'Email',
	'facebook,Facebook'=>'Facebook',
	'flickr,Flickr'=>'Flickr',
	'github,Github'=>'Github',
	'google-plus,Google Plus'=>'Google Plus',
	'instagram,Instagram'=>'Instagram',
	'linkedin,Linkedin'=>'Linkedin',
	'pinterest,Pinterest'=>'Pinterest',
	'rss,Rss'=>'Rss',
	'skype,Skype'=>'Skype',
	'spotify,Spotify' => 'Spotify',
	'tumblr,Tumblr'=>'Tumblr',
	'twitter,Twitter'=>'Twitter',
	'globe,Web' => 'Web',
	'whatsapp,WhatsApp' => 'WhatsApp',
	'vimeo,Vimeo'=>'Vimeo',
	'vk,VKontakte'=>'VKontakte',
	'xing,Xing'=>'Xing',
	'youtube-play,Youtube'=>'Youtube'
);


$setting = new admin_setting_configmb2start2('theme_mb2mcl/socialliststart', get_string('socillist','theme_mb2mcl'));
$temp->add($setting);

for ( $i = 1; $i <= 7; $i++ )
{

	$name = 'theme_mb2mcl/socialname' . $i;
	$title = get_string('name','theme_mb2mcl') . ' #' . $i;
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, '', $socialnameChoices);
	$temp->add($setting);

	$name = 'theme_mb2mcl/sociallink' . $i;
	$title = get_string('link','theme_mb2mcl') . ' #' . $i;
	$desc = '';
	$setting = new admin_setting_configtext($name, $title, $desc, '');
	$temp->add($setting);

	if ( $i < 7 )
	{
		$setting = new admin_setting_configmb2spacer('theme_mb2mcl/socialspacer' . $i);
		$temp->add($setting);
	}
}

$setting = new admin_setting_configmb2end('theme_mb2mcl/sociallistend');
$temp->add($setting);

$settings->add($temp);
