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
        'Nos\Orm_Behaviour_Contextable' => array(
            'events' => array('before_insert'),
            'context_property' => 'blco_context',
        ),
        'Nos\Orm_Behaviour_Twinnable' => array(
            'events' => array('before_insert', 'after_insert', 'before_save', 'after_delete', 'change_parent'),
            'context_property'      => 'blco_context',
            'common_id_property' => 'blco_context_common_id',
            'is_main_property' => 'blco_context_is_main',
            'common_fields'   => array(),
        ),
//        'Nos\Orm_Behaviour_Tree' => array(
//            'events' => array('before'),
//            'parent_relation' => 'parent',
//            'children_relation' => 'children',
//        ),
        /*
        'Nos\Orm_Behaviour_Publishable' => array(
            'publication_bool_property' => 'cate__published',
        ),
        */
//        'Nos\Orm_Behaviour_Urlenhancer' => array(
//            'enhancers' => array('contenu_malin_url'),
//        ),
//        'Nos\Orm_Behaviour_Sortable' => array(
//            'events' => array('after_sort', 'before_insert'),
//            'sort_property' => 'cate_ordre',
//        ),
//        'Nos\Orm_Behaviour_Virtualpath' => array(
//            'events' => array('before_save', 'after_save', 'check_change_parent'),
//            'virtual_name_property' => 'cate_virtual_name',
//            'virtual_path_property' => 'cate_virtual_url',
//            'extension_property' => '.html',
//            'parent_relation' => 'parent',
//        ),
        /*
        'Nos\Orm_Behaviour_Twinnable' => array(
            'events' => array('before_insert', 'after_insert', 'before_save', 'after_delete', 'change_parent'),
            'context_property'      => 'cate__context',
            'common_id_property' => 'cate__context_common_id',
            'is_main_property' => 'cate__context_is_main',
            'invariant_fields'   => array(),
        ),
        */
    );

//    protected static $_has_many = array(
//        'children' => array(
//            'key_from'       => 'blco_id',
//            'model_to'       => 'Lib\Blocs\Model_Column',
//            'key_to'         => 'blco_parent_id',
//            'cascade_save'   => false,
//            'cascade_delete' => false,
//        ),
//    );
//
//    protected static $_belongs_to = array(
//        'parent' => array(
//            'key_from'       => 'blco_parent_id',
//            'model_to'       => 'Lib\Blocs\Model_Column',
//            'key_to'         => 'blco_id',
//            'cascade_save'   => false,
//            'cascade_delete' => false,
//        ),
//    );

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
