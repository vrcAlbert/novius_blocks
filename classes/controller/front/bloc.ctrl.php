<?php

namespace Lib\Blocs;

use Nos\Controller_Front_Application;

use View;

class Controller_Front_Bloc extends Controller_Front_Application
{
    public function action_main($args = array())
    {
        $enhancer_url = $this->main_controller->getEnhancerUrl();

        if (!empty($enhancer_url)) {
            $segments = explode('/', $enhancer_url);

            if (!empty($segments[0])) {
                return $this->display_bloc($segments[0]);
            }

            throw new \Nos\NotFoundException();
        }

        return $this->display_list_bloc();
    }

    protected function display_list_bloc()
    {
        $bloc_list =  Model_Bloc::find('all', array(
            'order_by' => array(
                'bloc_id' => 'ASC'
            ),
            'limit' => 10
        ));

        return \View::forge('front/bloc_list', array(
            'bloc_list' => $bloc_list,
        ));
    }


    protected function display_bloc($virtual_name)
    {
        $bloc = Model_Bloc::find('first', array(
            'where' => array(
                array('bloc_virtual_name', '=', $virtual_name)
            )
        ));

        if (empty($bloc)) {
            throw new \Nos\NotFoundException();
        }

        $this->main_controller->setTitle($bloc->bloc_title);
        //$this->main_controller->setMetaDescription($bloc->bloc_title);

        return \View::forge('front/bloc_item', array(
            'bloc' => $bloc,
        ));
    }


    public static function get_url_model($item, $params = array())
    {
        // url built according to $item'class
        switch (get_class($item)) {
            case 'Blocs\Model_Bloc' :
                return urlencode($item->virtual_name()).'.html';
                break;
        }

        return false;
    }
}