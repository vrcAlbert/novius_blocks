<?php

return array(
    'tpl1' => array(),
    'tpl2' => array(
//        'label' => 'Template 2',
//        'view' => 'lib_blocs::templates/babar', //facultatif, nom de la vue correspondant
        'fields' => array( //facultatif, liste des champs utilisés
            'description',
            'link',
        ),
    ),
    'tpl3' => array(
        'fields' => array(
            'image',
            'link',
        ),
    ),
);