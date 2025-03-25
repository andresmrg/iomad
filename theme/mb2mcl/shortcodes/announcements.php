<?php

defined('MOODLE_INTERNAL') || die();


mb2_add_shortcode('announcements', 'mb2_shortcode_announcements');


function mb2_shortcode_announcements($atts, $content= null){

	extract(mb2_shortcode_atts(array(
		'limit' => 8,
		'catids' => 0,
		'excats' => 0,
		'layout' => 'cols',
		'colnum' => 3,
		'sdots' => 0,
		'sloop' => 0,
		'snav' => 1,
		'sautoplay' => 1,
		'spausetime' => 7000,
		'sanimate' => 600,
		'desclimit' => 25,
		'titlelimit' => 6,
		'gridwidth' => 'normal',
		'link' => 1,
		'readmoretext' => '',
		'itemdate' => 0,
		'image' => 1,
		'prestyle' => 0,
		'custom_class' => '',
		'colors' => '',
		'margin' => ''
	), $atts));


	$output = '';
	$cls = '';
	$list_cls = '';
	$col_cls = '';

	// Set column style
	$col = 0;
	$col_style = '';
	$list_style = '';
	$slider_data = '';

	// Get content source
	$items_opt = array(
		'limit'=>$limit,
		'catids'=>$catids,
		'excats'=>$excats,
		'colors'=>$colors,
		'image' => $image,
		'layout'=> $layout,
		'col_cls' => $col_cls,
		'link' => $link,
		'itemdate' => $itemdate,
		'titlelimit' => $titlelimit,
		'desclimit' => $desclimit,
		'colnum' => $colnum,
		'readmoretext' => $readmoretext
	);

	$announcements = theme_mb2mcl_shortcodes_announcements_get_items($items_opt);
	$itemCount = count($announcements);
	$carousel = ($layout === 'slidercols' && $itemCount > $colnum);

	// Get corousel options
	$carousel_opt = array(
		'colnum' => $colnum,
		'sdots' => $sdots,
		'sloop' => $sloop,
		'snav' => $snav,
		'sautoplay' => $sautoplay,
		'spausetime' => $spausetime,
		'sanimate' => $sanimate,
		'gridwidth' => $gridwidth
	);


	// Carousel layout
	if ($carousel)
	{
		$list_cls .= ' owl-carousel';
		$col_cls .= ' item';
		$slider_data = theme_mb2mcl_shortcodes_slider_data($carousel_opt);
	}

	if ($layout === 'slidercols' && $itemCount <= $colnum)
	{
		$layout = 'cols';
	}

	$cls .= ' ' . $layout;
	$cls .= ' gwidth-' . $gridwidth;
	$cls .= $colnum > 2 ? ' multicol' : '';
	$cls .= $prestyle ? ' ' . $prestyle : '';
	$cls .= $custom_class ? ' ' . $custom_class : '';
	$cls .= ($carousel) ? ' carousel' : ' nocarousel';

	$output .= '<div class="mb2-pb-content mb2-pb-announcements' . $cls . '">';
	$output .= '<div class="mb2-pb-content-inner clearfix">';
	$output .= '<div class="mb2-pb-content-list' . $list_cls . '"' . $slider_data . '>';

	if ($itemCount>0)
	{
		$output .= theme_mb2mcl_shortcodes_content_template($announcements, $items_opt);
	}
	else
	{
		$output .= get_string('nothingtodisplay');
	}

	$output .= '</div>';
	$output .= '</div>';
	$output .= '</div>';

	return $output;

}







/*
 *
 * Method to get categories list
 *
 */
function theme_mb2mcl_shortcodes_announcements_get_items ($options)
{

	global $CFG, $OUTPUT;

	$output = array();

	// We'll need this
	require_once($CFG->dirroot . '/mod/forum/lib.php');

	$cid = 1; // '1' = site anouncements
	if (!$forum = forum_get_course_forum($cid, 'news'))
	{
		return '';
	}

	$modinfo = get_fast_modinfo(get_course($cid));
	if (empty($modinfo->instances['forum'][$forum->id]))
	{
		return '';
	}

	$cm = $modinfo->instances['forum'][$forum->id];
	if (!$cm->uservisible)
	{
		return '';
	}

	$context = context_module::instance($cm->id);


	// User must have perms to view discussions in that forum
	if (!has_capability('mod/forum:viewdiscussion', $context))
	{
		return '';
	}


	// First work out whether we can post to this group and if so, include a link
	$groupmode = groups_get_activity_groupmode($cm);
	$currentgroup = groups_get_activity_group($cm, true);

	if (forum_user_can_post_discussion($forum, $currentgroup, $groupmode, $cm, $context))
	{
		//$output .= '<div class="mb2content-newlink"><a href="' . $CFG->wwwroot . '/mod/forum/post.php?forum=' . $forum->id . '">' . get_string('addanewtopic', 'forum').'</a></div>';
	}


	// Get all the recent discussions we're allowed to see
	// This block displays the most recent posts in a forum in
	// descending order. The call to default sort order here will use
	// that unless the discussion that post is in has a timestart set
	// in the future.
	// This sort will ignore pinned posts as we want the most recent.
	!defined('FORUM_POSTS_ALL_USER_GROUPS') ? define('FORUM_POSTS_ALL_USER_GROUPS','') : '';
	$sort = 'p.modified DESC';
	if (!$discussions = forum_get_discussions($cm, $sort, true, -1, $options['limit'], false, -1, 0, FORUM_POSTS_ALL_USER_GROUPS) )
	{
		$output = array();
	}
	else
	{
		$output = $discussions;
	}

	$showDetails = $options['itemdate'];

	if (count($discussions) > 0)
	{
		foreach ($discussions as $discussion)
		{
			$discussion->showitem = true;
			$discussion->subject = $discussion->name;
			$discussion->subject = format_string($discussion->subject, true, $forum->course);

			// Get image url
			// If attachment is empty get image from post
			$imgUrlAtt = theme_mb2mcl_shortcodes_content_get_image(array('context'=>$context->id,'mod'=>'mod_forum','area'=>'attachment','itemid'=>$discussion->id));
			$imgNameAtt = theme_mb2mcl_shortcodes_content_get_image(array('context'=>$context->id,'mod'=>'mod_forum','area'=>'attachment','itemid'=>$discussion->id), true);

			$imgUrlPost = theme_mb2mcl_shortcodes_content_get_image(array('context'=>$context->id,'mod'=>'mod_forum','area'=>'post','itemid'=>$discussion->id));
			$imgNamePost = theme_mb2mcl_shortcodes_content_get_image(array('context'=>$context->id,'mod'=>'mod_forum','area'=>'post','itemid'=>$discussion->id), true);

			$discussion->imgurl = $imgUrlAtt ? $imgUrlAtt : $imgUrlPost;
			$discussion->imgname = $imgNameAtt ? $imgNameAtt : $imgNamePost;


			if (!$options['image'])
			{
				$discussion->imgurl = '';
			}

			if ($options['image'] && !$discussion->imgurl)
			{
				$moodle33 = 2017051500;
				$discussion->imgurl = $CFG->version >= $moodle33 ? $OUTPUT->image_url('course-default','theme') : $OUTPUT->pix_url('course-default','theme');
			}

			// Define item elements
			$discussion->link_edit = new moodle_url($CFG->wwwroot . '/mod/forum/post.php', array('edit'=>$discussion->id));
			$discussion->id = $discussion->discussion;
			$discussion->link = new moodle_url($CFG->wwwroot . '/mod/forum/discuss.php', array('d'=>$discussion->discussion));
			$discussion->edit_text = get_string('edit', 'core');

			$discussion->title = $discussion->subject;
			$discussion->description = format_text($discussion->message);
			$strftimerecent = get_string('strftimerecent');
			$discussion->details = $showDetails == 1 ? userdate($discussion->modified, $strftimerecent) : '';
			$discussion->redmoretext = get_string('readmore', 'theme_mb2mcl');

			$discussion->price = '';

		}
	}

	return  $output;

}
