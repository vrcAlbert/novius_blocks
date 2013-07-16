<?php
namespace Lib\Blocs;

use Fuel\Core\Input;

class Controller_Admin_Bloc_Crud extends \Nos\Controller_Admin_Crud
{

    /**
     *
     */
    protected function init_item()
    {
        parent::init_item();

        $title = \Input::get('title', null);
        $absolute_url = \Input::get('absolute_url', null);
        $summary = \Input::get('summary', null);
        $thumbnail = \Input::get('thumbnail', null);
        if (!empty($title)) {
            $this->item->bloc_title = $title;
        }
        if (!empty($summary)) {
            $this->item->wysiwygs->description = nl2br($summary);
        }
        if (!empty($thumbnail)) {
            $this->item->{'medias->image->medil_media_id'} = $thumbnail;
        }
        if (!empty($absolute_url)) {
            $this->item->bloc_link = str_replace(\Uri::base(), '', $absolute_url);
        }
    }

    /**
     * @return Array
     */
    protected function get_tab_params()
    {
        $tabInfos = parent::get_tab_params();

        if ($this->is_new) {
            $params = array();
            foreach (array('title', 'summary', 'thumbnail', 'absolute_url') as $key) {
                $value = \Input::get($key, false);
                if ($value !== false) {
                    $params[$key] = $value;
                }
            }
            if (count($params)) {
                $tabInfos['url'] = $tabInfos['url'].'&'.http_build_query($params);
            }
        }
        return $tabInfos;
    }


    /**
     * Permet de rappatrier des informations d'autres modèles
     */
    public function action_synchro ()
    {
        //on récupère la clé de la config qui nous interesse
        $model_key = \Input::get('model_key');
        //on charge la config des models compatibles
        $models = \Config::load('lib_blocs::model_compatibility');
        if (!isset($models[$model_key])) {
            return false;
        }
        $config_model = $models[$model_key];
        //On appelle la vue qui permet de récupérer des infos
        return \View::forge($this->config['model_compatibility']['view'], array('config_model' => $config_model), false);
    }

    /**
     * @param null $id
     * @return \Fuel\Core\View|\Nos\View
     */
    public function action_form($id = null)
    {
        $context = Input::get('context', $this->item->bloc_context);
        $this->config['fields']['columns']['form']['options'] = \Arr::assoc_to_keyval(\Lib\Blocs\Model_Column::find('all', array('where' => array('blco_context' => $context))), 'blco_id', 'blco_title');
        $this->item = $this->crud_item($id);
        $this->clone = clone $this->item;
        $this->is_new = $this->item->is_new();
        if ($this->is_new) {
            $this->init_item();
        }
        $this->checkPermission($this->is_new ? 'add' : 'edit');

        $fields = $this->fields($this->config['fields']);
        $fieldset = \Fieldset::build_from_config($fields, $this->item, $this->build_from_config());
        $fieldset = $this->fieldset($fieldset);

        $view_params = $this->view_params();
        $view_params['fieldset'] = $fieldset;

        // We can't do this form inside the view_params() method, because additional vars (added
        // after the reference was created) won't be available from the reference
        $view_params['view_params'] = &$view_params;

        return \View::forge($this->config['views'][$this->is_new ? 'insert' : 'update'], $view_params, false);
    }

    /**
     * @param string $model_key
     */
    public function action_autocomplete_model($config_key = 'no')
    {
        $models = \Config::load('lib_blocs::connection_model');
        $filter = \Fuel\Core\Input::post('search', '');

        if (!isset($models[$config_key])) {
            return \Response::json(array());
        }

        $model_config = $models[$config_key];
        $model = $model_config['model'];

        $table = $model::table();

        $show = \Fuel\Core\DB::select(
            array($model_config['autocomplete_value'], 'value'),
            array($model_config['autocomplete_label'], 'label')
        )->from($table);

        if (strlen($filter) > 0
            && isset($model_config['search_autocomplete_fields'])
            && is_array($model_config['search_autocomplete_fields'])
            && count($model_config['search_autocomplete_fields']))
        {
            $show->where_open();
            foreach ($model_config['search_autocomplete_fields'] as $field) {
                $show->or_where($field, 'LIKE', '%' . $filter . '%');
            }
            $show->where_close();
        }

        $show = (array) $show->distinct(true)->execute()->as_array();

        return \Response::json($show);
    }

    /**
     * @param $config_key
     * @param $model_id
     * @param $wrapper_dialog
     * @return bool|\Fuel\Core\View
     */
    public function action_retrieve_model ($config_key, $model_id, $wrapper_dialog)
    {
        $models = \Config::load('lib_blocs::connection_model');
        if (!isset($models[$config_key])) {
            return false;
        }
        $model_config = $models[$config_key];
        $class_name = $model_config['model'];
        if (!$item = $class_name::find($model_id)) {
            return false;
        }

        return \View::forge('lib_blocs::admin/bloc/retrieve_model', array(
            'item'              => $item,
            'config'            => $model_config,
            'wrapper_dialog'    => $wrapper_dialog,
            'item_id'           => $model_id,
        ), false);
    }

    /**
     * @param $config_key
     * @param $model_id
     * @return bool|\Fuel\Core\View
     */
    public function action_get_model_assoc_infos ($config_key, $model_id)
    {
        $models = \Config::load('lib_blocs::connection_model');
        if (!isset($models[$config_key])) {
            return false;
        }
        $model_config = $models[$config_key];
        $class_name = $model_config['model'];
        if (!$item = $class_name::find($model_id)) {
            return false;
        }

        $return = \View::forge('lib_blocs::admin/bloc/model_assoc_infos', array(
            'item'              => $item,
            'config'            => $model_config,
            'item_id'           => $model_id,
        ), false);
        \Response::forge($return)->send(true);
        exit();
    }
}
