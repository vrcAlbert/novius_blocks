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
    $props = \Lib\Blocs\Model_Bloc::init_config($props, $name);
    $props['fields'][] = 'titre';   //titre obligatoire

    //set des données transmises
    $title = $item->bloc_title ? $item->bloc_title : 'Titre';
    $description = $item->wysiwygs->description ? $item->wysiwygs->description : '
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ipsum eros, euismod sagittis interdum non, pulvinar in tellus.
        ';
    $url = '#';
    $image = '';

    if (isset($props['image_params'])) {
        $image = str_replace(
            array(
                '{src}',
                '{width}',
                '{height}',
            ),
            array(
                'http://lorempixel.com/' . $props['image_params']['width_admin'] . '/' . $props['image_params']['height_admin'],
                $props['image_params']['width_admin'],
                $props['image_params']['height_admin'],
            ),
            $props['image_params']['tpl_admin']
        );
    }

    if ($item->bloc_class) {
        $props['class'] .= ($props['class'] ? ' ' : '') . $item->bloc_class;
    }

    //on charge la vue correspondante
    $view = \View::forge($props['view'], array(
        'config' => $props,
        'name' => $name,
        'title' => $title,
        'description' => $description,
        'url' => $url,
        'image' => $image,
    ), false);

    $view = str_replace(array(
        '{title}',
        '{name}',
        '{description}',
        '{link}',
        '{link_text}',
        '{image}',
        '{class}',
    ), array(
        $title,
        $name,
        $description,
        $url,
        $props['link_text'],
        $image,
        $props['class'],
    ), $view);

    if ($props['css']) {
        ?>
        <link rel="stylesheet" href="<?= $props['css'] ?>" />
        <?php
    }

    //on vérifie si il existe une feuille de style spéciale pour l'admin
    if (is_file(DOCROOT . 'static/css/blocs/admin/' . $name . '.css')) {
        ?>
        <link rel="stylesheet" href="static/css/blocs/admin/<?= $name ?>.css" />
        <?php
    }

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