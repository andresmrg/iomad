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

define('AJAX_SCRIPT', true);
require('../../../config.php');
require_login();
require_sesskey();
$context = context_system::instance();
$PAGE->set_url('/theme/mb2mcl/lib/lib_ajax_bookmarks_manage.php');
$PAGE->set_context($context);
$bookmarks = array();
$bkupdate = 0;
$bkdelete = 0;
$bklimit = 999;

$bkurl = $_GET["mb2bkurl"];
$bktitle = $_GET["mb2bktitle"];
$bkdelete = $_GET["bkdelete"];
$bkupdate = $_GET["bkupdate"];
$bklimit = $_GET["bklimit"];

if (htmlspecialchars_decode($bkurl) && $bktitle && confirm_sesskey())
{

    if (get_user_preferences('user_bookmarks'))
    {
        // Get user bookmarks
        $bookmarks = explode(',', get_user_preferences('user_bookmarks'));

        foreach ($bookmarks as $b)
        {
            $b_arr = explode(';', $b);

            if ($b_arr[0] === $bkurl)
            {
                $bkupdate = 1;

                // Find key and update or remove it
                $k_to_update = array_search($b, $bookmarks);

                if ($bkdelete == 1)
                {
                    unset($bookmarks[$k_to_update]);
                }
                else
                {
                    // Create new bookmark record
                    $new_bookmark = $bkurl . ";" . $bktitle;
                    $bookmarks[$k_to_update] = $new_bookmark;
                }
            }
        }
     }

     // Add only new bookmark element to array
     if ($bkupdate == 0 && $bkdelete == 0)
     {
         $bookmarks[] = $bkurl . ";" . $bktitle;

         // Check bookmarks limit
         if (count($bookmarks) > $bklimit)
         {
             echo get_string('bkmarklimit','theme_mb2mcl', array('limit'=>$bklimit));
             die;
         }
     }

     $bookmarks = implode(',', $bookmarks);

     set_user_preference('user_bookmarks', $bookmarks);
     echo json_encode(explode(',',$bookmarks));

     die;
 }
 else
 {
     echo get_string('wentwrong','theme_mb2mcl');
     die;
 }
