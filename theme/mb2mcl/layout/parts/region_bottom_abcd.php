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

$a = theme_mb2mcl_isblock($PAGE, 'bottom-a');
$b = theme_mb2mcl_isblock($PAGE, 'bottom-b');
$c = theme_mb2mcl_isblock($PAGE, 'bottom-c');
$d = theme_mb2mcl_isblock($PAGE, 'bottom-d');

$col1 = (($a && !$b && !$c && !$d) || (!$a && $b && !$c && !$d) || (!$a && !$b && $c && !$d) || (!$a && !$b && !$c && $d));
$col2 = (($a && $b && !$c && !$d) || ($a && !$b && $c && !$d) || ($a && !$b && !$c && $d) || (!$a && $b && $c && !$d) || (!$a && $b && !$c && $d) || (!$a && !$b && $c && $d));
$col3 = (($a && $b && $c && !$d) || ($a && $b && !$c && $d) || ($a && !$b && $c && $d) || (!$a && $b && $c && $d));
$col4 = ($a && $b && $c && $d);


if ($col4)
{
	$col = '3';
}
elseif ($col3)
{
	$col = '4';
}
elseif ($col2)
{
	$col = '6';
}
else
{
	$col = '12';
}

$abcd = array('a','b','c','d');

if ( theme_mb2mcl_is_footer_columns() ) : ?>
<div id="bottom-abcd">
	<div class="container-fluid">
		<div class="row">
			<?php foreach ($abcd as $block) : ?>
            	<?php if (theme_mb2mcl_isblock($PAGE, 'bottom-' . $block)) : ?>
                	<div class="col-md-<?php echo $col; ?>">
						<?php echo $OUTPUT->blocks('bottom-' . $block, theme_mb2mcl_block_cls($PAGE, 'bottom-' . $block,'bottom')); ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>
