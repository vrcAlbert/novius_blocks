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

<div class="block_wrapper {name} {class}">
    <h2>{title}</h2>
    {image}
    <div class="content">
        {description}
    </div>
    <a href="{link}" class="bottom"<?= $link_new_page ? ' target="blank"' : '' ?>">{link_title}</a>
</div>