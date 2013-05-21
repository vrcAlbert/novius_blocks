<?php

return array(
    'css'               => 'static/apps/lib_blocs/css/front/{name}.css',
    'view'              => 'lib_blocs::templates/{name}',
    'fields'            => array(
        'description',
        'link',
        'image',
    ),
    'image_params'      => array(
        'width'         => 300,
        'height'        => 200,
        'width_admin'   => 188,
        'height_admin'  => 100,
        'tpl'           => '<img src="{src}" alt="{title}" border="0" />',
        'tpl_admin'     => '<img src="{src}" alt="{title}" border="0" width="{width}" height="{height}" />',
    ),
    'link_text'         => 'Lire la suite',
    'class'             => '',
);