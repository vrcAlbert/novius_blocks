<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

namespace Novius\Blocks;

use Fuel\Core\Input;

class Controller_Admin_Block_Crud extends \Nos\Controller_Admin_Crud
{
    protected function init_item()
    {
        parent::init_item();

        // We retrieve the get values
        $title = \Input::get('title', null);
        $absolute_url = \Input::get('absolute_url', null);
        $summary = \Input::get('summary', null);
        $thumbnail = \Input::get('thumbnail', null);

        // And we set them to the item if they're not empty
        if (!empty($title)) {
            $this->item->block_title = $title;
        }
        if (!empty($summary)) {
            $this->item->wysiwygs->description = nl2br($summary);
        }
        if (!empty($thumbnail)) {
            $this->item->{'medias->image->medil_media_id'} = $thumbnail;
        }
        if (!empty($absolute_url)) {
            $this->item->block_link = str_replace(\Uri::base(), '', $absolute_url);
        }
    }

    /**
     * Return the config for setting the url of the novius-os tab
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
     * Allows to retrieve informations from other models
     */
    public function action_synchro ()
    {
        // We get the key from the config we want
        $model_key = \Input::get('model_key');

        // We load the config of the compatible models
        $models = \Config::load('novius_blocks::model_compatibility', true);
        if (!isset($models[$model_key])) {
            return false;
        }

        $config_model = $models[$model_key];

        // We call the view that allows us to retrieve the informations of the other model
        return \View::forge($this->config['model_compatibility']['view'], array('config_model' => $config_model), false);
    }

    /**
     * @param null $id
     * @return \Fuel\Core\View|\Nos\View
     */
    public function action_form($id = null)
    {
        $context = Input::get('context', $this->item->block_context);
        $this->config['fields']['columns']['form']['options'] = \Arr::assoc_to_keyval(\Novius\Blocks\Model_Column::find('all', array('where' => array('blco_context' => $context))), 'blco_id', 'blco_title');
        return parent::action_form($id);
    }

    /**
     * Get the compatible models we search with some text
     * @param string $model_key
     */
    public function action_autocomplete_model($config_key = 'no')
    {
        // We load the config of the compatible models
        $models = \Config::load('novius_blocks::connection_model', true);
        $filter = \Fuel\Core\Input::post('search', '');

        // We assure that the model is compatible with the block
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

        // We search the results
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
        $models = \Config::load('novius_blocks::connection_model', true);
        if (!isset($models[$config_key])) {
            return false;
        }
        $model_config = $models[$config_key];
        $class_name = $model_config['model'];
        if (!$item = $class_name::find($model_id)) {
            return false;
        }

        return \View::forge('novius_blocks::admin/block/retrieve_model', array(
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
        $models = \Config::load('novius_blocks::connection_model', true);
        if (!isset($models[$config_key])) {
            return false;
        }
        $model_config = $models[$config_key];
        $class_name = $model_config['model'];
        if (!$item = $class_name::find($model_id)) {
            return false;
        }

        $return = \View::forge('novius_blocks::admin/block/model_assoc_infos', array(
            'item'              => $item,
            'config'            => $model_config,
            'item_id'           => $model_id,
        ), false);
        \Response::forge($return)->send(true);
        exit();
    }
}
