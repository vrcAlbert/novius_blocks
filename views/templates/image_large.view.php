<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */
?>

<div class="block_wrapper {name}">
    <h2><?= $title ?></h2>
    <?php if ($image) {
        if ($url) {
            echo '<a href="' . $url . '">';
        }
            echo $image;
        if ($url) {
            echo '</a>';
        }
    }
    if ($url) {
    ?>
    <a class="bottom" href="<?= $url ?>">{link_title}</a>
    <? } ?>
</div>