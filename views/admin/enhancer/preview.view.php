<?php

if (!count($blocs)) {
    echo 'Aucun bloc ne sera affiché';
    exit();
}

$templates_config = \Config::load('lib_blocs::templates', true);

?>

    <div class="blocs_wrapper blocs_wrapper_enhancer">
<?php
foreach ($blocs as $bloc) {
    $name = $bloc->bloc_template;
    if (!$template_config = $templates_config[$name]) {
        continue;
    }

    $image = '';
    $config = \Lib\Blocs\Model_Bloc::init_config($template_config, $name);
    if ($config['css']) {
        ?>
        <link rel="stylesheet" href="<?= $config['css'] ?>" />
        <?php
    }

    //on vérifie si il existe une feuille de style spéciale pour l'admin
    if (is_file(DOCROOT . 'static/css/blocs/admin/' . $name . '.preview.css')) {
        ?>
        <link rel="stylesheet" href="static/css/blocs/admin/<?= $name ?>.preview.css" />
    <?php
    } else if (is_file(DOCROOT . 'static/css/blocs/admin/' . $name . '.css')) {
        ?>
        <link rel="stylesheet" href="static/css/blocs/admin/<?= $name ?>.css" />
    <?php
    }

    echo \Lib\Blocs\Controller_Front_Bloc::get_bloc_view($bloc, $config, $name);
}
?>
    </div>