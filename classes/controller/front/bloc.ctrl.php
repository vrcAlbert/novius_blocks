<?php

namespace Lib\Blocs;

use Nos\Controller_Front_Application;

use View;

class Controller_Front_Bloc extends Controller_Front_Application
{
    public function action_main($args = array())
    {
        $blocs = array();
        //on va récupérer la liste des blocs
        switch ($args['type_affichage']) {
            case 'blocs' :
                $blocs = Model_Bloc::find('all', array(
                    'where' => array(
                        array('bloc_id', 'in', $args['blocs_ids'])
                    ),
                ));
                break;
            case 'column' :
                if ($args['blco_id']) {
                    $column = Model_Column::find($args['blco_id']);
                    $blocs = $column->blocs;
                }
                break;
            default :
                return false;
                break;
        }

        return \View::forge($this->config['views'][$args['type_affichage']], array(
            'blocs'     => $blocs,
        ), false);
    }
}