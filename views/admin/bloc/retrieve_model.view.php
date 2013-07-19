<?php
    $wrapper_id = uniqid('wrapper_');
    $btn_ok = uniqid('btn_ok_');
?>
<script type="text/javascript">
    require(['jquery-nos', 'static/apps/lib_blocs/js/admin/retrieve_model.js'], function ($, callback_fn) {
        $(function () {
            callback_fn.call($('#<?= $wrapper_id ?>'), '<?= $btn_ok ?>');
        });
    });
</script>
<div id="<?= $wrapper_id ?>">
    <h1>Rappatrier les données d'un objet</h1>
    <input type="hidden" name="retrieve_model_id" value="<?= $item_id ?>" />
    <?php
    //on va récupérer les différents champs disponibles
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
            <div style="margin: 3px; border: 1px solid #535353; padding: 8px;">
                <?= $value ?>
            </div>
            <textarea data-type="<?= $field['type']?>" style="display:none" id="<?= $t_id ?>_value"><?= $value ?></textarea>
        </p>
        <?php
    }

    //on vérifie que le model est une méthode pour afficher une url :
    if (method_exists($item, 'url')) {
        $t_id = uniqid('lien_');
        ?>
        <p>
            <input type="checkbox" name="get_link" id="<?= $t_id ?>" value="1" />
            <label for="<?= $t_id ?>">Utiliser l'URL de l'objet</label>
        </p>
        <?php
    }
    ?>
    <button id="<?= $btn_ok ?>"
            class="ui-button ui-state-default ui-corner-all ui-button-text-icon-primary">
        <span class="ui-button-icon-primary ui-icon ui-icon-play"></span>
        <span class="ui-button-text">Valider</span>
    </button>
</div>