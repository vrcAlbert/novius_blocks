<?php

return array(
    'basic' => array(
        'image_params' => array(
            'width_admin'   => 130,
            'height_admin'  => 80,
            'tpl'           => '<div class="wrapper_img"><img src="{src}" alt="{title}" border="0" /></div>',
            'tpl_admin'     => '<div class="wrapper_img"><img src="{src}" alt="{title}" border="0" width="{width}" height="{height}" /></div>',
            'width'         => 220,
            'height'        => 150,
        ),
    ),
    'image_large' => array(
        'fields' => array(
            'image',
            'link',
        ),
    ),
    'only_wysiwyg' => array(
        'css' => '',
        'fields' => array(
            'description',
        ),
    ),
//    'tpl' => array(
//        'view' => 'lib_blocs::templates/tpl', //facultatif : vue du template
//        'fields' => array( //facultatif : liste des chahmps disponibles pour ce template
//            'description',
//            'link',
//            'title',
//            'image',
//        ),
//    ),
);