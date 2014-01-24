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
        if ($link) {
            echo '<a href="' . $link . '">';
        }
            echo $image;
        if ($link) {
            echo '</a>';
        }
    }
    if ($link) {
    ?>
    <a class="bottom" href="<?= $link ?>">{link_title}</a>
    <? } ?>
</div>