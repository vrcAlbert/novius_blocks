<?php
    $models = \Config::load('lib_blocs::connection_model', true);
    $select_id = uniqid('select_model_');
    $model_selected_id = uniqid('model_selected_');
    $function_js = uniqid('function_js_');
?>
<script type="text/javascript">
    require(['jquery-nos', 'static/apps/lib_blocs/js/admin/connection_model.js'], function ($, callback_fn) {
        $(function () {
            callback_fn.call($('#<?= $fieldset->form()->get_attribute('id') ?>'), '<?= $select_id ?>');
        });
    });
</script>
<div class="wrapper_assoc_model_choice">
    <label for="<?= $select_id ?>">Lier avec :</label>
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
</div>


<?php
echo \View::forge('lib_blocs::admin/bloc/assoc_model_js', array(
    'model_selected'    => $model_selected_id,
    'config_select'     => $select_id,
    'function_js'       => $function_js,
    'form_id'           => $fieldset->form()->get_attribute('id'),
), false);