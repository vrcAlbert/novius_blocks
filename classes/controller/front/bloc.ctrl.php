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
                if (!empty($args['blocs_ids'])) {
                    $blocs = Model_Bloc::find('all', array(
                        'where' => array(
                            array('bloc_id', 'in', $args['blocs_ids'])
                        ),
                    ));
                }
                break;
            case 'column' :
                if (!empty($args['blco_id'])) {
                    $column = Model_Column::find($args['blco_id']);
                    $blocs_tmp = $column->blocs;
                    if ($column->blco_blocs_ordre) {
                        $ordre = unserialize($column->blco_blocs_ordre);
                        $ids = array();
                        foreach ($blocs_tmp as $tmp_bloc) {
                            $ids[$tmp_bloc->bloc_id] = $tmp_bloc->bloc_id;
                        }
                        foreach ($ordre as $bloc_id) {
                            if (in_array($bloc_id, $ids)) {
                                $blocs[] = $blocs_tmp[$bloc_id];
                                unset($ids[$bloc_id]);
                            }
                        }
                        if (count($ids)) {
                            foreach ($ids as $bloc_id) {
                                $blocs[] = $blocs_tmp[$bloc_id];
                            }
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