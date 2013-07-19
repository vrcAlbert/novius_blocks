<?php
return array(
    'controller_url'  => 'admin/lib_blocs/column/crud',
    'model' => 'Lib\Blocs\Model_Column',
    'layout' => array(
        'large' => true,
        'save' => 'save',
        'title' => 'blco_title',
        'content' => array(
            'blocs' => array(
                'view' => 'nos::form/expander',
                'params' => array(
                    'title'   => __('Blocs'),
                    'nomargin' => true,
                    'options' => array(
                        'allowExpand' => true,
                    ),
                    'content' => array(
                        'view' => 'lib_blocs::admin/column/multiselect_blocs',
                        'params' => array(
                            'fields' => array(
                                'blocs',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'fields' => array(
        'blco_id' => array (
            'label' => 'ID: ',
            'form' => array(
                'type' => 'hidden',
            ),
            'dont_save' => true,
        ),
        'blco_title' => array(
            'label' => __('Title'),
            'form' => array(
                'type' => 'text',
            ),
        ),
        'blco_blocs_ordre' => array(
            'form' => array(
                'type' => 'hidden',
            ),
            'before_save' => function($item, $data) {
                $item->blco_blocs_ordre = serialize($data['blocs']);
            },
        ),
        'blocs' => array(
            'renderer' => 'Lib\Renderers\Renderer_Multiselect',
            'renderer_options' => array(
                'order' => true,
            ),
            'order' => true,
            'label' => __('Blocs'),
            'form' => array(
                'options' => array(),//rempli par la méthode fields du crud
                'order' => true,
            ),
//            'populate' => function($item) {
//                if (!empty($item->blocs)) {
//                    if ($item->blco_id) {
//                        $return = array();
//                        $result = \Fuel\Core\DB::query('SELECT * FROM blocs_columns_liaison WHERE blcl_blco_id = ' . $item->blco_id . ' ORDER BY CASE WHEN blcl_ordre IS NULL THEN 1 ELSE 0 END, blcl_ordre')->execute();
//                        $result_array = $result->as_array();
//                        foreach($result_array as $item)
//                        {
//                            $return[] = $item['blcl_bloc_id'];
//                        }
//                        return $return;
//                    }
//                    return array_keys($item->blocs);
//                } else {
//                    return array();
//                }
//            },
            'before_save' => function($item, $data) {
                $item->blocs;//fetch et 'cree' la relation
                unset($item->blocs);
                if (!empty($data['blocs'])) {
                    foreach ($data['blocs'] as $bloc_id) {
                        if (ctype_digit($bloc_id) ) {
                            $item->blocs[$bloc_id] = \Lib\Blocs\Model_Bloc::find($bloc_id);
                        }
                    }
                }
            },
        ),
        'save' => array(
            'label' => '',
            'form' => array(
                'type' => 'submit',
                'tag' => 'button',
                // Note to translator: This is a submit button
                'value' => __('Save'),
                'class' => 'primary',
                'data-icon' => 'check',
            ),
        ),
    )
);