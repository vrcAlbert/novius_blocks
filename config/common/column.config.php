<?php
return array(
    'data_mapping' => array(
        'blco_title' => array(
            'title' => __('Columns'),
        ),
    ),
    'controller' => 'column/crud',
    'actions' => array(
        /*'child' => array(
            'action' => array(
                'action' => 'nosTabs',
                'tab' => array(
                    'url' => '{{controller_base_url}}child/{{_id}}',
                ),
            ),
            'label' => __('Ajouter une catégorie fille'),
            'icon' => 'plus',
            'primary' => false,
            'targets' => array(
                'grid' => true,
                'toolbar-edit' => true,
            ),
            'visible' => function($params) {
                return !isset($params['item']) || !$params['item']->is_new();
            },
        ),*/
//        'delete' => array(
//            'label' => __('Supprimer'),
//            'visible' => function($params) {
//                return Nos\User\Permission::check('portailmalin_contenumalin::has_profile', 'administrateur');
//            },
//            'disabled' => function ($categorie) {
//                return count($categorie->contenus_principaux) > 0;
//            },
//        ),
//        'add' => array(
//            'label' => __('Ajouter une catégorie'),
//            'visible' => function($params) {
//                return Nos\User\Permission::check('portailmalin_contenumalin::has_profile', 'administrateur');
//            },
//        ),
//        'edit' => array(
//            'label' => __('Modifier'),
//            'visible' => function($params) {
//                return Nos\User\Permission::check('portailmalin_contenumalin::has_profile', 'administrateur');
//            },
//        ),
//        'visualise' => array(
//            'label' => __('Visualiser'),
//        )
    ),
);