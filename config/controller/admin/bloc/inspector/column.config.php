<?php

return array(
    'model' => 'Lib\Blocs\Model_Column',
    'order_by' => 'blco_title',
    'input' => array(
        'key' => 'blco_id',
//        'query' => function ($value, $query)
//        {
//            if (is_array($value)) {
//                foreach ($value as $v) {
//                    $query->_join_relation('filtres_valeurs', $join);
//                    $query->where($join['alias_to'].'.cofv_filt_id', $v);
//                }
//            }
//            return $query;
//        },

//            'key' => 'cate_id', //filtre sur l'id renseigné sur le contenu
        'query' => function ($value, $query)
        {
            if (is_array($value)) {
                foreach ($value as $v) {
                    $query->_join_relation('columns', $join);
                    $query->where($join['alias_to'].'.blco_id', $v);
                }
            }
            return $query;
        },
    ),
    'appdesk' => array(
        'label'     => __('Columns'),
    ),
);
