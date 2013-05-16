<?php

namespace Lib\Blocs;

class Model_Bloc extends \Nos\Orm\Model
{

    protected static $_primary_key = array('bloc_id');
    protected static $_table_name = 'blocs';

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
            'property'=>'bloc_created_at'
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => true,
            'property'=>'bloc_updated_at'
        )
    );

    protected static $_behaviours = array(
        /*
        'Nos\Orm_Behaviour_Publishable' => array(
            'publication_bool_property' => 'bloc__published',
        ),
        */
        'Nos\Orm_Behaviour_Urlenhancer' => array(
            'enhancers' => array('blocs_bloc'),
        ),
//        'Nos\Orm_Behaviour_Tree' => array(
//            'events' => array('before_query', 'before_delete'),
//            'parent_relation' => 'parent',
//            'children_relation' => 'children',
//            'level_property' => 'bloc_level',
//        ),
        /*
        'Nos\Orm_Behaviour_Twinnable' => array(
            'events' => array('before_insert', 'after_insert', 'before_save', 'after_delete', 'change_parent'),
            'context_property'      => 'bloc__context',
            'common_id_property' => 'bloc__context_common_id',
            'is_main_property' => 'bloc__context_is_main',
            'invariant_fields'   => array(),
        ),
        */
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
        'columns' => array( // key must be defined, relation will be loaded via $bloc->key
            'table_through' => 'blocs_columns_liaison', // intermediary table must be defined
            'key_from' => 'bloc_id', // Column on this model
            'key_through_from' => 'blcl_bloc_id', // Column "from" on the intermediary table
            'key_through_to' => 'blcl_blco_id', // Column "to" on the intermediary table
            'key_to' => 'blco_id', // Column on the other model
            'cascade_save' => false,
            'cascade_delete' => false,
            'model_to'       => 'Lib\Blocs\Model_Column', // Model to be defined
        ),
    );

    /**
     * Retourne la config pour un bloc en particulier
     * dans cette fonction sont définis les paramètres par défaut
     * @param $config
     * @param $name
     * @return array
     */
    public static function init_config ($config, $name) {
        $default_config = \Config::load('lib_blocs::template_default', true);
        $default_config['view'] = str_replace('{name}', $name, $default_config['view']);
        return array_merge($default_config, $config);
    }

}
