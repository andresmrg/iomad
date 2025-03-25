<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('section', 'mb2_shortcode_section');

function mb2_shortcode_section ($atts, $content= null)
{
	extract(mb2_shortcode_atts( array(
		'size'=> '4',
		'margin' => '',
		'bgcolor' => '',
		'prbg' => 0,
		'scheme' => 'light',
		'bgimage' => '',
		'pt' =>0,
		'pb' => 0,
		'custom_class' => '',
		'sectionhidden' => 0,
		'sectionlang' => '',
		'sectionaccess' => 0
	), $atts));

	$output = '';
	$bg_image_style = $bgimage ? ' style="background-image:url(\'' . $bgimage . '\');"' : '';
	$cls = $custom_class ? ' ' . $custom_class : '';
	$cls .= ' pre-bg' . $prbg;
	$cls .= ' ' . $scheme;

	$lang_arr = explode(',', $sectionlang);
	$trimmed_lang_arr = array_map('trim', $lang_arr);

	if ($sectionlang && !in_array(current_language(), $trimmed_lang_arr))
	{
		return ;
	}

	if ($sectionhidden && !is_siteadmin())
	{
		return ;
	}

	if ($sectionhidden && is_siteadmin())
	{
		$cls .= ' hiddenel';
	}

	if ($sectionaccess == 1)
	{
		if (!isloggedin() || isguestuser())
		{
			return ;
		}
	}
	elseif ($sectionaccess == 2)
	{
		if (isloggedin() && !isguestuser())
		{
			return ;
		}
	}

	$section_style = ' style="';
	$section_style .= 'padding-top:' . $pt . 'px;';
	$section_style .= 'padding-bottom:' . $pb . 'px;';
	$section_style .= $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
	$section_style .= '"';

	$output .= '<div class="mb2-pb-fpsection' . $cls . '"' . $bg_image_style . '>';
	$output .= '<div class="section-inner"' . $section_style . '>';
	$output .= mb2_do_shortcode($content);
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
