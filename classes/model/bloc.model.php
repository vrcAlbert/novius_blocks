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
        'Nos\Orm_Behaviour_Urlenhancer' => array(
            'enhancers' => array('blocs_bloc'),
        ),
        'Nos\Orm_Behaviour_Contextable' => array(
            'events' => array('before_insert'),
            'context_property' => 'bloc_context',
        ),
        'Nos\Orm_Behaviour_Twinnable' => array(
            'events' => array('before_insert', 'after_insert', 'before_save', 'after_delete', 'change_parent'),
            'context_property'      => 'bloc_context',
            'common_id_property' => 'bloc_context_common_id',
            'is_main_property' => 'bloc_context_is_main',
            'common_fields' => array(),
        ),
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
     * @return mixed|\Nos\Orm\Model|null
     */
    public function get_url ()
    {
        if ($this->bloc_model_id && $this->bloc_model) {
            $models = \Config::load('lib_blocs::connection_model', true);
            if (!isset($models[$this->bloc_model])) {
                return $this->bloc_link;
            }
            $model_config = $models[$this->bloc_model];
            $class_name = $model_config['model'];
            if (!$item = $class_name::find($this->bloc_model_id)) {
                return $this->bloc_link;
            }

            $url = null;
            if ($item::behaviours('Nos\Orm_Behaviour_Urlenhancer', false) !== false || method_exists($item, 'url')) {
                $url = $item->url();
            }

            if ($url) {
                return $url;
            }
        }
        return $this->bloc_link;
    }

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
        $default_config['css'] = str_replace('{name}', $name, $default_config['css']);

        //charge vue locale
        if (is_file(APPPATH . 'views/lib_blocs/' . $name . '.view.php')) {
            $default_config['view'] = 'local::/lib_blocs/' . $name;
        }

        //on vérifie si une feuille de style a été crée en local :
        if (is_file(DOCROOT . 'static/css/blocs/' . $name . '.css')) {
            $default_config['css'] = 'static/css/blocs/' . $name . '.css';
        }
        $retour_config = \Arr::merge($default_config, $config);
        if (isset($config['fields']) && $config['fields']) {
            $retour_config['fields'] = $config['fields'];
        }
        return $retour_config;
    }

}
