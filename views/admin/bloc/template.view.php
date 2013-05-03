<?php

//chargement de la config
$templates_config = \Config::load('lib_blocs::templates', true);
?>
<link rel="stylesheet" href="static/apps/lib_blocs/css/admin/template.css" />
<script type="text/javascript">
    require(['jquery-nos', 'static/apps/lib_blocs/js/admin/blocs.js'], function ($, callback_fn) {
        $(function () {
            callback_fn.call($('#<?= $fieldset->form()->get_attribute('id') ?>'), '<?= uniqid('_this_blocs_'); ?>');
        });
    });
</script>
<div class="blocs_wrapper">
<?php

foreach ($templates_config as $name => $props) {
    $props = array_merge(array(
        'view'   => 'lib_blocs::templates/' . $name,
        'fields' => array(
            'description',
            'link',
            'image',
        ),
    ), $props);
    $props['fields'][] = 'titre';   //titre obligatoire
    //on charge la vue correspondante
    $view = \View::forge($props['view'], array(
        'name' => $name,
        'title' => $item->bloc_title ? $item->bloc_title : 'Titre',
        'description' => '
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ipsum eros, euismod sagittis interdum non, pulvinar in tellus.
        ',
        'url' => '#',
        'image' => 'img_admin',
    ), false);
    ?>
    <div class="bloc_over_wrapper">
        <?= $view ?>
        <div class="bloc_select">
            <label for="template_<?= $name ?>">
                <input data-fields="<?= implode('|', $props['fields']) ?>" class="notransform" type="radio" name="bloc_template" id="template_<?= $name ?>" value="<?= $name ?>"<?= $item->bloc_template == $name ? ' checked' : '' ?> />
            </label>
        </div>
    </div>
    <?php
}

?>
</div>