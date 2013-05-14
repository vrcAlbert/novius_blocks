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
            $this->item->bloc_link = $absolute_url;
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
}
