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

    echo \Lib\Blocs\Controller_Front_Bloc::get_bloc_view($bloc, $config, $name);
}

?>
</div>