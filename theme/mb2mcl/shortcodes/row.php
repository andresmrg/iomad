<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('row', 'mb2_shortcode_row');


function mb2_shortcode_row ($atts, $content= null)
{
	extract(mb2_shortcode_atts( array(
		'rowheader' => 0,
		'rowheader_content' => '',
		'rowheader_textcolor' => '',
		'rowheader_bgcolor' => '',
		'bgcolor' => '',
		'prbg' => 0,
		'scheme' => 'light',
		'bgimage' => '',
		'pt' =>0,
		'pb' => 0,
		'fw' => 0,
		'custom_class' => '',
		'rowhidden' => 0,
		'rowlang' => '',
		'rowaccess' => 0,
		'rowicon' => 0,
		'rowicon_icon' => '',
		'rowicon_posh' => 'right',
		'rowicon_posv' => 'top',
		'rowicon_size' => 28,
		'rowicon_margin' => '',
		'rowtext' => 0,
		'rowtext_text' => '',
		'rowtext_size' => 16
	), $atts));

	$output = '';
	$headercls = '';
	$rowheader_style = '';
	$rowicon_style = '';
	$rowpt = $pt;
	$bg_image_style = $bgimage ? ' style="background-image:url(\'' . $bgimage . '\');"' : '';
	$cls = $custom_class ? ' ' . $custom_class : '';
	$cls .= ' pre-bg' . $prbg;
	$cls .= ' ' . $scheme;
	$cls .= ' isfw' . $fw;
	$cls .= ' iconposh-' . $rowicon_posh;
	$cls .= ' iconposv-' . $rowicon_posv;

	$lang_arr = explode(',', $rowlang);
	$trimmed_lang_arr = array_map('trim', $lang_arr);

	if ($rowlang && !in_array(current_language(), $trimmed_lang_arr))
	{
		return ;
	}

	if ($rowhidden && !is_siteadmin())
	{
		return ;
	}

	if ($rowhidden && is_siteadmin())
	{
		$cls .= ' hiddenel';
		$headercls .= ' hiddenel';
	}

	if ($rowaccess == 1)
	{
		if ( ! isloggedin() || isguestuser() )
		{
			return ;
		}
	}
	elseif ($rowaccess == 2)
	{
		if ( isloggedin() && ! isguestuser() )
		{
			return ;
		}
	}

	if ( $rowheader && $rowheader_bgcolor )
	{
		$rowpt = 0;
		$cls .= ' rowheaderbg';
	}

	$row_style = ' style="';
	$row_style .= 'padding-top:' . str_replace( ',', '.', $rowpt ) . 'rem;';
	$row_style .= 'padding-bottom:' . str_replace( ',', '.', $pb ) . 'rem;';
	$row_style .= $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
	$row_style .= '"';

	$output .= '<div class="mb2-pb-fprow' . $cls . '"' . $bg_image_style . '>';
	$output .= '<div class="section-inner mb2-pb-row-inner "' . $row_style . '>';

	if ( $rowtext )
	{
		$output .= '<div class="row-header-big" style="top:' . round( $rowtext_size * -0.5, 3 ) . 'rem;">';
		$output .= '<h2 style="font-size:' . $rowtext_size . 'rem;letter-spacing:' . round( $rowtext_size * -0.0375, 3 ) . 'rem;">' . $rowtext_text . '</h2>';
		$output .= '</div>';
	}

	$output .= '<div class="section-inner2">';


	if ( $rowheader )
	{
		if ( $rowheader_bgcolor )
		{
			$rowheader_style .= ' style="';
			$rowheader_style .= 'background-color:' . $rowheader_bgcolor . ';';
			$rowheader_style .= 'margin-bottom:' . $pt . 'px;';
			$rowheader_style .= '"';

			$headercls .= ' isbg';
		}
		else
		{
			$headercls .= ' nobg';
		}

		$output .= '<div class="mb2-pb-fprow-header' . $headercls . '"' . $rowheader_style . '>';
		$output .= '<div class="container-fluid">';
		$output .= '<div class="row">';
		$output .= '<div class="col-md-12">';

		$content_arr =  preg_split( '/\r\n|\n|\r/', $rowheader_content );

		$output .= '<div class="row-title title-center">';
		$output .= '<h2 class="title" style="color:' . $rowheader_textcolor . ';">' . theme_mb2mcl_get_highlight_text( $content_arr[0] ) . '</h2>';

		if ( isset(  $content_arr[1] ) )
		{
			$output .= '<div class="title-subtext" style="color:' . $rowheader_textcolor . ';">' . $content_arr[1] . '</div>';
		}

		$output .= '</div>';

		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';
	}

	if ( $rowicon_margin )
	{
		$rowicon_style = ' style="margin:' . $rowicon_margin . ';"';
	}

	$output .= !$fw ? '<div class="container-fluid">' : '';
	$output .= !$fw ? '<div class="row">' : '';
	$output .= mb2_do_shortcode($content);
	$output .= !$fw ? '</div>' : '';
	$output .= !$fw ? '</div>' : '';
	$output .= '</div>';
	$output .= $rowicon ? '<div class="row-icon" style="font-size:' . str_replace(',', '.', $rowicon_size) . 'rem;"><div class="row-icon2"><div class="row-icon3"><i class="' . theme_mb2mcl_font_icon_prefix( $rowicon_icon ) . $rowicon_icon . '"' . $rowicon_style . '></i></div></div></div>' : '';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}
