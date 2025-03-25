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


$temp = new admin_settingpage('theme_mb2mcl_settingstypography',  get_string('settingstypography', 'theme_mb2mcl'));


$fontsGlobalOpt = array(
	'nfont1'=>get_string('nfont','theme_mb2mcl') . ' #1',
	'nfont2'=>get_string('nfont','theme_mb2mcl') . ' #2',
	'nfont3'=>get_string('nfont','theme_mb2mcl') . ' #3',
	''=>'------------',
	'gfont1'=>get_string('gfont','theme_mb2mcl') . ' #1',
	'gfont2'=>get_string('gfont','theme_mb2mcl') . ' #2',
	'gfont3'=>get_string('gfont','theme_mb2mcl') . ' #3',
);


$fontsOpt = array(
	'0'=>get_string('global','theme_mb2mcl'),
	'nfont1'=>get_string('nfont','theme_mb2mcl') . ' #1',
	'nfont2'=>get_string('nfont','theme_mb2mcl') . ' #2',
	'nfont3'=>get_string('nfont','theme_mb2mcl') . ' #3',
	''=>'------------',
	'gfont1'=>get_string('gfont','theme_mb2mcl') . ' #1',
	'gfont2'=>get_string('gfont','theme_mb2mcl') . ' #2',
	'gfont3'=>get_string('gfont','theme_mb2mcl') . ' #3',
);


$fontsWeightOpt = array(
	'normal'=>get_string('normal','theme_mb2mcl'),
	'bold'=>get_string('bold','theme_mb2mcl'),
	'bolder'=>get_string('bolder','theme_mb2mcl'),
	'lighter'=>get_string('lighter','theme_mb2mcl'),
	'100'=>'100',
	'200'=>'200',
	'300'=>'300',
	'400'=>'400',
	'500'=>'500',
	'600'=>'600',
	'700'=>'700',
	'800'=>'800',
	'900'=>'900',
	'inherit'=>get_string('inherit','theme_mb2mcl')
);


$ftextTransfromOpt = array(
	'none'=>get_string('none','theme_mb2mcl'),
	'uppercase'=>get_string('uppercase','theme_mb2mcl'),
	'capitalize'=>get_string('capitalize','theme_mb2mcl'),
	'lowercase'=>get_string('lowercase','theme_mb2mcl')
);


$fontStyleOpt = array(
	'normal'=>get_string('normal','theme_mb2mcl'),
	'italic'=>get_string('italic','theme_mb2mcl'),
	'oblique'=>get_string('oblique','theme_mb2mcl')
);



$setting = new admin_setting_configmb2start2('theme_mb2mcl/startfgeneral', get_string('global','theme_mb2mcl'));
$temp->add($setting);


	$name = 'theme_mb2mcl/ffgeneral';
	$title = get_string('ffamily','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'gfont1', $fontsGlobalOpt);
	$temp->add($setting);


	$name = 'theme_mb2mcl/typoblobalspacer0';
	$setting = new admin_setting_configmb2spacer($name);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mcl/fsbase';
	$title = get_string('fsbase','theme_mb2mcl');
	$setting = new admin_setting_configtext($name,$title,'',17);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/fsbase2';
	$title = get_string('fsbase2','theme_mb2mcl');
	$setting = new admin_setting_configtext($name,$title,get_string('fsizepxdesc', 'theme_mb2mcl'),19);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/fsbase3';
	$title = get_string('fsbase3','theme_mb2mcl');
	$setting = new admin_setting_configtext($name,$title,get_string('fsizepxdesc', 'theme_mb2mcl'),20);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/typoblobalspacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/fwgeneral';
	$title = get_string('fweight','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 400, $fontsWeightOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mcl/typoblobalspacer';
	$setting = new admin_setting_configmb2spacer($name);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mcl/fwbold';
	$title = get_string('fwbold','theme_mb2mcl');
	$setting = new admin_setting_configselect($name, $title, '', 'bold', $fontsWeightOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endfgeneral');
$temp->add($setting);





$setting = new admin_setting_configmb2start2('theme_mb2mcl/startfheadings', get_string('headings','theme_mb2mcl'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2mcl/ffheadings';
	$title = get_string('ffamily','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, '0', $fontsOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);

	$name = 'theme_mb2mcl/fheadingsspacer1';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	for ($i = 1; $i <= 6; $i++ )
	{
		$name = 'theme_mb2mcl/fsheading' . $i;
		$title = get_string('hsize','theme_mb2mcl', array( 'size'=>$i ) );
		$setting = new admin_setting_configtext($name,$title,'','');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);
	}

	$name = 'theme_mb2mcl/fheadingsspacer2';
	$setting = new admin_setting_configmb2spacer($name);
	$temp->add($setting);

	$name = 'theme_mb2mcl/fwheadings';
	$title = get_string('fweight','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 600, $fontsWeightOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/ttheadings';
	$title = get_string('ttransform','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'none', $ftextTransfromOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/fstheadings';
	$title = get_string('fstyle','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'normal', $fontStyleOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endfheadings');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);






$setting = new admin_setting_configmb2start2('theme_mb2mcl/startfmenu', get_string('menu','theme_mb2mcl'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2mcl/ffmenu';
	$title = get_string('ffamily','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, '0', $fontsOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/fsmenu';
	$title = get_string('fsize','theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title,'', 0.9);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/fwmenu';
	$title = get_string('fweight','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 600, $fontsWeightOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/ttmenu';
	$title = get_string('ttransform','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'uppercase', $ftextTransfromOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/fstmenu';
	$title = get_string('fstyle','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'normal', $fontStyleOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endfmenu');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);



$setting = new admin_setting_configmb2start2('theme_mb2mcl/startfddmenu', get_string('ddmenu','theme_mb2mcl'));
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);


	$name = 'theme_mb2mcl/ffddmenu';
	$title = get_string('ffamily','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc,'0', $fontsOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/fsddmenu';
	$title = get_string('fsize','theme_mb2mcl');
	$setting = new admin_setting_configtext($name, $title,'', 0.8);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/fwddmenu';
	$title = get_string('fweight','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 600, $fontsWeightOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/ttddmenu';
	$title = get_string('ttransform','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'uppercase', $ftextTransfromOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


	$name = 'theme_mb2mcl/fstddmenu';
	$title = get_string('fstyle','theme_mb2mcl');
	$desc = '';
	$setting = new admin_setting_configselect($name, $title, $desc, 'normal', $fontStyleOpt);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


$setting = new admin_setting_configmb2end('theme_mb2mcl/endfddmenu');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);




for ($i = 1; $i<=3; $i++)
{
	$setting = new admin_setting_configmb2start2('theme_mb2mcl/startceltypo' . $i, get_string('celtypo','theme_mb2mcl') . ' #' . $i);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);


		$name = 'theme_mb2mcl/celsel' . $i;
		$title = get_string('celsel','theme_mb2mcl');
		$setting = new admin_setting_configtextarea($name, $title, get_string('celseldesc','theme_mb2mcl'),'');
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		$name = 'theme_mb2mcl/ffcel' . $i;
		$title = get_string('ffamily','theme_mb2mcl');
		$setting = new admin_setting_configselect($name, $title, '', '0', $fontsOpt);
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


		$name = 'theme_mb2mcl/fwcel' . $i;
		$title = get_string('fweight','theme_mb2mcl');
		$setting = new admin_setting_configselect($name, $title, '', 'inherit', $fontsWeightOpt);
		$setting->set_updatedcallback('theme_reset_all_caches');
		$temp->add($setting);


	$setting = new admin_setting_configmb2end('theme_mb2mcl/endceltypo' . $i);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$temp->add($setting);
}






$settings->add($temp);
