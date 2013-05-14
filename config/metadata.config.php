<?php
return array(
    'name'    => __('Blocs'),
    'version' => 'dev',
    'icons' => array(
        64 => 'static/apps/lib_blocs/img/64-blocs.png',
        32 => 'static/apps/lib_blocs/img/32-blocs.png',
        16 => 'static/apps/lib_blocs/img/16-blocs.png',
    ),
    'permission' => array(
    ),
    'provider' => array(
        'name' => 'Novius',
    ),
    'namespace' => 'Lib\Blocs',
    'launchers' => array(
		'lib_blocs' => array(
            'name'    => 'Blocs',
            'action' => array(
                'action' => 'nosTabs',
                'tab' => array(
                    'url' => 'admin/lib_blocs/bloc/appdesk',
                ),
            ),
        ),
    ),
    'enhancers' => array(
//        'blocs_bloc' => array( // key must be defined
//            'title' => 'Blocs Bloc',
//            'desc'  => '',
//            'urlEnhancer' => 'blocs/front/bloc/main', // URL of the enhancer
//            //'previewUrl' => 'admin/blocs/application/preview', // URL of preview
//            //'dialog' => array(
//            //    'contentUrl' => 'admin/blocs/application/popup',
//            //    'width' => 450,
//            //    'height' => 400,
//            //    'ajax' => true,
//            //),
//        ),
        'blocs' => array(
            'title' => 'Blocs',
            'id' => 'blocs',
            'desc' => '',
            'enhancer' => 'lib_blocs/bloc/main',
            'previewUrl' => 'admin/lib_blocs/bloc/enhancer/preview',
            'dialog' => array(
                'contentUrl' => 'admin/lib_blocs/bloc/enhancer/popup',
                'ajax' => true,
                'width' => 500,
                'height' => 300,
            ),
        ),
//        'noviusos_slideshow' => array(
//            'title' => 'Slideshow',
//            'id'    => 'slideshow',
//            'desc'  => '',
//            'enhancer' => 'noviusos_slideshow/slideshow/main',
//            'iconUrl' => '/static/apps/noviusos_slideshow/img/slideshow-16.png',
//            'previewUrl' => 'admin/noviusos_slideshow/enhancer/preview',
//            'dialog' => array(
//                'contentUrl'    => 'admin/noviusos_slideshow/enhancer/popup',
//                'width'         => 450,
//                'height'        => 300,
//                'ajax'          => true,
//            ),
//        ),
    ),
    'data_catchers' => array(
        'lib_blocs' => array( // key must be defined
            'title' => 'Blocs',
            'description'  => 'mettez cet élément en avant',
            'action' => array(
                'action' => 'nosTabs',
                'tab' => array(
                    'url' => 'admin/lib_blocs/bloc/crud/insert_update/?context={{context}}&title={{urlencode:'.\Nos\DataCatcher::TYPE_TITLE.'}}&summary={{urlencode:'.\Nos\DataCatcher::TYPE_TEXT.'}}&thumbnail={{urlencode:'.\Nos\DataCatcher::TYPE_IMAGE.'}}&absolute_url={{urlencode:'.\Nos\DataCatcher::TYPE_URL.'}}',
                    'label' => 'Bloc',
                ),
            ),
            'onDemand' => true,
            'specified_models' => false,
            // data examples
            'required_data' => array(
                \Nos\DataCatcher::TYPE_TITLE,
            ),
            'optional_data' => array(
                \Nos\DataCatcher::TYPE_TEXT,
                \Nos\DataCatcher::TYPE_IMAGE,
                \Nos\DataCatcher::TYPE_URL,
            ),
        ),
    ),
);
