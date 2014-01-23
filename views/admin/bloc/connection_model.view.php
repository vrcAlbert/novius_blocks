<?php
/**
 * Novius Blocs
 *
 * @copyright  2013 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

    $models = \Config::load('novius_blocs::connection_model', true);
    $select_id = uniqid('select_model_');
    $model_selected_id = uniqid('model_selected_');
?>
<script type="text/javascript">
    require(['jquery-nos', 'static/apps/novius_blocs/js/admin/connection_model.js'], function ($, callback_fn) {
        $(function () {
            callback_fn.call($('#<?= $fieldset->form()->get_attribute('id') ?>'), '<?= $select_id ?>');
        });
    });
</script>
<div class="wrapper_assoc_model_choice">
    <label for="<?= $select_id ?>">Link with :</label>
    <input type="hidden" name="autocomplete_url" value="__" />
    <select id="<?= $select_id ?>" name="select_model">
        <option value=""></option>
        <?php
        foreach ($models as $k => $model) {
            ?>
            <option value="<?= $k ?>"><?= $model['label'] ?></option>
            <?php
        }
        ?>
    </select>
</div>

<div class="wrapper_assoc_model_done" id="<?= $model_selected_id ?>">
<?php
echo \View::forge('novius_blocs::admin/bloc/assoc_model_js', array(
    'model_selected'    => $model_selected_id,
    'config_select'     => $select_id,
    'form_id'           => $fieldset->form()->get_attribute('id'),
), false);
?>
</div>