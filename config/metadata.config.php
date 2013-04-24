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
    ),
    /* Data catcher configuration sample
    'data_catchers' => array(
        'key' => array( // key must be defined
            'title' => 'title',
            'description'  => '',
            'action' => array(
                'action' => 'nosTabs',
                'tab' => array(
                    'url' => 'admin/blocs/post/insert_update/?context={{context}}&title={{urlencode:'.\Nos\DataCatcher::TYPE_TITLE.'}}&summary={{urlencode:'.\Nos\DataCatcher::TYPE_TEXT.'}}&thumbnail={{urlencode:'.\Nos\DataCatcher::TYPE_IMAGE.'}}',
                    'label' => 'label of the data catcher',
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
            ),
        ),
    ),
    */
);
