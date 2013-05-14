<?php
    $models = \Config::load('lib_blocs::model_compatibility');
    $select_id = uniqid('select_model_');
?>
<script type="text/javascript">
    require(['jquery-nos', 'static/apps/lib_blocs/js/admin/bloc_synchro.js'], function ($, callback_fn) {
        $(function () {
            callback_fn.call($('#<?= $fieldset->form()->get_attribute('id') ?>'), '<?= $select_id ?>');
        });
    });
</script>
<label for="<?= $select_id ?>">Retrieve informations from :</label>
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
