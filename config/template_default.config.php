<?php

return array(
    'view'   => 'lib_blocs::templates/{name}',
    'fields' => array(
        'description',
        'link',
        'image',
    ),
    'image_params' => array(
        'width'     => 300,
        'height'    => 200,
        'tpl'       => '<img src="{src}" alt="{title}" border="0" />',
    ),
);