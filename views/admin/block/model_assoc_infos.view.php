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

<h2>This block is linked to an item (<?= $config['label'] ?>)</h2>
&nbsp;
<p>Title of the item : <strong>"<?= $item->{$config['display_label']} ?>"</strong></p>
&nbsp;
<p>
    <button class="delete_liaison_model ui-state-error ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false">
        <span class="ui-button-icon-primary ui-icon ui-icon-trash"></span>
        <span class="ui-button-text">Delete this link</span>
    </button>
</p>