<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

$blocks = trim($blocks);

// Nothing to display ?
if (empty($blocks)) {
    ?>
    <div>
        <?= __('No block to display') ?>
    </div>
    <?php
    return ;
}

?>
<div>
    <div class="blocks_wrapper blocks_wrapper_enhancer novius_blocks_preview">
        <?= $blocks ?>
        <link rel="stylesheet" href="static/apps/novius_blocks/css/admin/preview.css"/>
    </div>
</div>
