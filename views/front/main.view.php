<?php

//pas de blocs ?
if (!count($blocs)) {
    echo '&nbsp;';
    return;
}

//chargement de la config des templates
$templates_config = \Config::load('lib_blocs::templates', true);

?>
<div class="blocs_wrapper">
<?php

foreach ($blocs as $bloc) {
    $name = $bloc->bloc_template;
    if (!$template_config = $templates_config[$name]) {
        continue;
    }

    $image = '';
    $config = \Lib\Blocs\Model_Bloc::init_config($template_config, $name);
    if ($config['css']) {
        \Nos\Nos::main_controller()->addCss($config['css']);
    }
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

    $description = \Nos\Nos::parse_wysiwyg($bloc->wysiwygs->description);
    $title = $bloc->bloc_title;
    $link = $bloc->bloc_link;
    $link_title = $bloc->bloc_link_title;


    if ($bloc->bloc_class) {
        $config['class'] .= ($config['class'] ? ' ' : '') . $bloc->bloc_class;
    }

    $bloc_object = $bloc;

    $bloc = str_replace(array(
        '{title}',
        '{name}',
        '{description}',
        '{link}',
        '{link_title}',
        '{image}',
        '{class}',
    ), array(
        $title,
        $name,
        $description,
        $link,
        $link_title,
        $image,
        $config['class'],
    ), \View::forge($config['view'], array(
        'config'        => $config,
        'description'   => $description,
        'title'         => $title,
        'link'          => $link,
        'link_title'    => $link_title,
        'link_new_page' => $bloc->bloc_link_new_page,
        'image'         => $image,
        'bloc'          => $bloc_object
    ), false));

    echo $bloc;
}

?>
</div>