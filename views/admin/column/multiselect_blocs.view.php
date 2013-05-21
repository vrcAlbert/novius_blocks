<?php
    $values = array();
    if ($item->blco_id && $item->blocs) {
        if($item->blco_blocs_ordre) {
            $values = unserialize($item->blco_blocs_ordre);
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
        ),
    ));