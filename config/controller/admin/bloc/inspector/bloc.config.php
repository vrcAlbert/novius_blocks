<?php

return array(
    'models' => array(
        array(
            'model' => 'Lib\Blocs\Model_Bloc',
            'where' => array(
                array('bloc_type', 'folder'),
            ),
            'childs' => array('Lib\Blocs\Model_Bloc'),
            'dataset' => array(
                'id' => 'bloc_id',
                'title' => 'bloc_title',
            ),
            'callback' => array(
                function($query) {
                    $query->where(array('bloc_type', 'folder'));
                }
            ),
        ),
    ),

    'data_mapping' => array(
        'id' => 'bloc_id',
        'title' => 'bloc_title',
    ),
    'roots' => array(
        array(
            'model' => 'Lib\Blocs\Model_Bloc',
            'where' => array(array('bloc_parent_id', 'IS', \DB::expr('NULL')), array('bloc_type', 'folder')), //@todo : à virer
            'order_by' => 'bloc_level',
        ),
    ),
    'root_node' => array(
        'title' => __('Root'),
    ),
);
