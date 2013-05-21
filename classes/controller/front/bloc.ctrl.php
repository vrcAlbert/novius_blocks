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
                $blocs = array();
//                $blocs_ids = $args['blocs_ids'];
                $tmp_blocs = Model_Bloc::find('all', array(
                    'where' => array(
                        array('bloc_id', 'in', $args['blocs_ids'])
                    ),
                ));
                foreach ($args['blocs_ids'] as $bloc_id) {
                    $blocs[] = $tmp_blocs[$bloc_id];
                }
                break;
            case 'column' :
                if ($args['blco_id']) {
                    $column = Model_Column::find($args['blco_id']);
                    $blocs = $column->blocs;
                    if ($column->blco_blocs_ordre) {
                        $blocs_tmp = $blocs;
                        $blocs = array();
                        $ordre = unserialize($column->blco_blocs_ordre);
                        foreach ($ordre as $bloc_id) {
                            $blocs[] = $blocs_tmp[$bloc_id];
                        }
                    }
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