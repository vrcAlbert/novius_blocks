<?php

namespace Lib\Blocs;

class Model_Column extends \Nos\Orm\Model
{

    protected static $_primary_key = array('blco_id');
    protected static $_table_name = 'blocs_columns';

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
            'property'=>'blco_created_at'
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => true,
            'property'=>'blco_updated_at'
        )
    );

    protected static $_behaviours = array(
    );

//    protected static $_has_many = array(
//        'children' => array(
//            'key_from'       => 'bloc_id',
//            'model_to'       => 'Lib\Blocs\Model_Bloc',
//            'key_to'         => 'bloc_parent_id',
//            'cascade_save'   => false,
//            'cascade_delete' => false,
//        ),
//    );

    protected static $_belongs_to = array(
//        'parent' => array(
//            'key_from'       => 'bloc_parent_id',
//            'model_to'       => 'Lib\Blocs\Model_Folder',
//            'key_to'         => 'blfo_id',
//            'cascade_save'   => false,
//            'cascade_delete' => false,
//        ),
    );

    protected static $_many_many = array(
        'blocs' => array( // key must be defined, relation will be loaded via $bloc->key
            'table_through' => 'blocs_columns_liaison', // intermediary table must be defined
            'key_from' => 'blco_id', // Column on this model
            'key_through_from' => 'blcl_blco_id', // Column "from" on the intermediary table
            'key_through_to' => 'blcl_bloc_id', // Column "to" on the intermediary table
            'key_to' => 'bloc_id', // Column on the other model
            'cascade_save' => false,
            'cascade_delete' => false,
            'model_to'       => 'Lib\Blocs\Model_Bloc', // Model to be defined
        ),
    );
}
