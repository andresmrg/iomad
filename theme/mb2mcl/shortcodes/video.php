<?php

defined('MOODLE_INTERNAL') || die();


function mb2_shortcode_video($atts, $content= null)
{

	extract(mb2_shortcode_atts( array(
		'width'=>'',
		'id'=>'',
		'videoid' => '',
		'video_icon'=>'fa fa-play',
		'video_text'=>'',
		'ratio'=>'16:9',
		'margin' => '',
		'bg_image' => '',
		'custom_class' => '',
		'custom_video' => ''
	), $atts));

	$output = '';

	if ( $id !== '' )
	{
		$videoid = $id;
	}

	if ( $custom_video !== '' )
	{
		$style = $width ? ' style="width:' . $width . 'px;"' : '';
		$output .= '<video controls="true"' . $style . '>';
		$output .= '<source src="' . $custom_video . '">' . $custom_video;
		$output .= '</video>';
	}
	else
	{
		// Define margin
		$mg = $margin !='' ? 'margin:' . $margin . ';' : '';

		// Define video icon
		$isicon = $video_icon !='' ? $video_icon : 'fa fa-play';

		$video_url = theme_mb2mcl_get_video_url( $videoid );

		$isratio = str_replace(':', 'by', $ratio);

		$cls = 	$bg_image !='' ? ' isimage' : '';
		$cls .= $custom_class ? ' ' . $custom_class : '';

		$ifstyle = 'style="';
		$ifstyle .= $width ? 'max-width:' . $width . 'px;' : '';
		$ifstyle .= $mg;
		$ifstyle .= '"';

		$output .= '<div class="embed-responsive-wrap' . $cls . '"' . $ifstyle . '>';
		$output .= $bg_image !=''
		? '<i class="' . $isicon . '"></i><div class="embed-video-bg" style="background-image:url(\'' . $bg_image . '\');" data-videourl="' . $video_url . '?autoplay=1&showinfo=0&rel=0"></div>' : '';
		$output .= '<div class="embed-responsive embed-responsive-'. $isratio . '">';
		$output .=  $bg_image !='' ? '<iframe allowfullscreen></iframe>' : '<iframe src="' . $video_url . '?showinfo=0&rel=0" allowfullscreen></iframe>';
		$output .= '</div>';
		$output .= '</div>';
	}


	return $output;

}

mb2_add_shortcode('video', 'mb2_shortcode_video');
