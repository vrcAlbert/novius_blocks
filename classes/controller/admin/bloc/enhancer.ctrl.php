<?php

namespace Lib\Blocs;

class Controller_Admin_Bloc_Enhancer extends \Nos\Controller_Admin_Enhancer
{
//    public function action_popup()
//    {
//        return \View::forge($this->config['popup']['view'], array(
//            'url' => $this->config['controller_url'].'/save',
//            'layout' => $this->config['popup']['layout'],
//            'params' => $this->config['popup']['params'],
//            'enhancer_args' => \Input::get(),
//        ), false);
//    }

    public function action_save(array $args = null)
    {
        if (empty($args)) {
            $args = $_POST;
        }
        if (!empty($args['enhancer'])) {
            $enhancers = \Nos\Config_Data::get('enhancers', array());
            if (!empty($enhancers[$args['enhancer']])) {
                $enhancer = $enhancers[$args['enhancer']];
                $icon = \Config::icon($enhancer['application'], 64);
                $this->config['preview']['params'] = array_merge(array(
                    'icon' => !empty($icon) ? $icon : 'static/apps/noviusos_appmanager/img/64/app-manager.png',
                    'title' => \Arr::get($enhancer, 'title', __('I’m an application. Give me a name!')),
                ), $this->config['preview']['params']);
            }
        }

        $blocs = Controller_Front_Bloc::get_blocs($args);

        if ($this->config['preview']['custom']) {
            $view = $this->config['preview']['view'];
        } else {
            $view = 'nos::admin/enhancer/preview';
        }

        $body = array(
            'debug'  => $this->config['preview'],
            'config'  => $args,
            'preview' => \View::forge($view, array(
                    'layout' => $this->config['preview']['layout'],
                    'params' => $this->config['preview']['params'],
                    'enhancer_args' => $args,
                    'blocs' => $blocs,
                ))->render(),
        );
        \Response::json($body);
    }
}