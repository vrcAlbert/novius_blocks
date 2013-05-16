<?php

//pas de blocs ?
if (!count($blocs)) {
    echo '&nbsp;';
    return;
}

//chargement de la config des templates
$templates_config = \Config::load('lib_blocs::templates', true);

foreach ($blocs as $bloc) {
    $name = $bloc->bloc_template;
    if (!$template_config = $templates_config[$name]) {
        continue;
    }

    $image = '';
    $config = \Lib\Blocs\Model_Bloc::init_config($template_config, $name);
    if (!empty($bloc->medias->image)) {
        $image = str_replace(
            array(
                '{src}',
                '{title}',
            ),
            array(
                $bloc->medias->image->get_public_path_resized($config['image_params']['width'], $config['image_params']['height']),
                $bloc->bloc_title,
            ),
            $config['image_params']['tpl']
        );
    }
    echo \View::forge($config['view'], array(
        'description'   => $bloc->wysiwygs->description,
        'title'         => $bloc->bloc_title,
        'link'          => $bloc->bloc_link,
        'link_new_page' => $bloc->bloc_link_new_page,
        'image'         => $image,
    ), false);
}