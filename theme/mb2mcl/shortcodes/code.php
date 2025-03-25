<?php

defined('MOODLE_INTERNAL') || die();

mb2_add_shortcode('code', 'mb2_shortcode_code');


function mb2_shortcode_code ($atts, $content= null){

	extract(mb2_shortcode_atts( array(), $atts));

	return mb2_do_shortcode($content);

}
