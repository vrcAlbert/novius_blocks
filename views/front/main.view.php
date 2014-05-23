<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

// Nothing to display
if (empty($blocks)) {
    echo '&nbsp;';
    return ;
}

?>
<div class="blocks_wrapper">
    <?= $blocks ?>
</div>
