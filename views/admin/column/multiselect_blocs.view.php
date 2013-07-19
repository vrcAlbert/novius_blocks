<?php
    $values = array();
    if ($item->blco_id && $item->blocs) {
        if($item->blco_blocs_ordre) {
            $values_tmp = unserialize($item->blco_blocs_ordre);
            $values = array();
            $bloc_in_column = array();
            foreach ($item->blocs as $bloc) {
                $bloc_in_column[] = $bloc->bloc_id;
            }
            foreach ($values_tmp as $bloc_id) {
                if (in_array($bloc_id, $bloc_in_column)) {
                    $values[] = $bloc_id;
                }
            }
            foreach ($item->blocs as $bloc) {
                if (!in_array($bloc->bloc_id, $values)) {
                    $values[] = $bloc->bloc_id;
                }
            }
        } else {
            foreach ($item->blocs as $bloc) {
                $values[] = $bloc->bloc_id;
            }
        }
    }

    echo \Lib\Renderers\Renderer_Multiselect::renderer(array(
        'options'       => \Arr::assoc_to_keyval(\Lib\Blocs\Model_bloc::find('all', array('where' => array('bloc_context' => $item->blco_context))), 'bloc_id', 'bloc_title'),
        'name'          => 'blocs[]',
        'values'        => $values,
        'order'         => true,
        'style'         => array(
            'width'     => '70%',
            'height'    => '400px',
        ),
    ));