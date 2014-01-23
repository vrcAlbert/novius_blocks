<?php
/**
 * Novius Blocs
 *
 * @copyright  2013 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

    $wrapper_id = uniqid('wrapper_');
    $btn_ok = uniqid('btn_ok_');
?>
<script type="text/javascript">
    require(['jquery-nos', 'static/apps/novius_blocs/js/admin/retrieve_model.js'], function ($, callback_fn) {
        $(function () {
            callback_fn.call($('#<?= $wrapper_id ?>'), '<?= $btn_ok ?>');
        });
    });
</script>
<div id="<?= $wrapper_id ?>">
    <h1>Retrieve the datas of an item</h1>
    <input type="hidden" name="retrieve_model_id" value="<?= $item_id ?>" />
    <?php
    foreach ($config['data_mapping'] as $key => $field) {
        $field = array_merge(array(
            'type' => 'text',
        ), $field);
        $t_id = uniqid($field['field']);
        $value = '';
        switch ($field['type']) {
            case 'wysiwyg' :
                $value = $item->wysiwygs->{$field['field']};
                break;
            case 'text' :
                default :
                    $value = $item->{$field['field']};
                break;
        }
        ?>
        <p>
            <input type="checkbox" name="<?= $key ?>" id="<?= $t_id ?>" value="1" />
            <label for="<?= $t_id ?>"><?= $field['label'] ?></label>
            <div style="margin: 3px; border: 1px solid #535353; padding: 8px; max-height: 180px; overflow:hidden;">
                <?= $value ?>
            </div>
            <textarea data-type="<?= $field['type']?>" style="display:none" id="<?= $t_id ?>_value"><?= $value ?></textarea>
        </p>
        <?php
    }

    // We check that the model has a method to display an url
    $url = null;
    if ($item::behaviours('Nos\Orm_Behaviour_Urlenhancer', false) !== false || method_exists($item, 'url')) {
        $url = $item->url();
    }

    if (!is_null($url)) {
        $t_id = uniqid('lien_');
        ?>
        <p>
            <input type="checkbox" name="get_link" id="<?= $t_id ?>" value="1" />
            <label for="<?= $t_id ?>">Use the url of an item</label>
        </p>
        <?php
    }
    ?>
    <button id="<?= $btn_ok ?>"
            class="ui-button ui-state-default ui-corner-all ui-button-text-icon-primary">
        <span class="ui-button-icon-primary ui-icon ui-icon-play"></span>
        <span class="ui-button-text">Save</span>
    </button>
</div>