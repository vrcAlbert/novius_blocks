<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

    $title_id = uniqid('search_title_');
    $titre_liste_id = uniqid('titre_liste_');
    $wrapper_liste_id = uniqid('wrapper_liste_');
?>
<form action="#">
    <div>
        <h1><?= __('Search for an item to synchronize :'); ?></h1>
        <h2><label for="<?= $title_id ?>"><?= __('Title :'); ?></label></h2>
        <input type="text" name="search_title" value="" id="<?= $title_id ?>" />
        <h2 id="<?= $titre_liste_id ?>"><?= __('Last elements added :'); ?></h2>
        <div id="<?= $wrapper_liste_id ?>">
        </div>
    </div>
</form>
