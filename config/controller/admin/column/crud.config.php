<?php
return array(
    'controller_url'  => 'admin/lib_blocs/column/crud',
    'model' => 'Lib\Blocs\Model_Column',
    'layout' => array(
        'large' => true,
        'save' => 'save',
        'title' => 'blco_title',
        'content' => array(
//            'proprietes' => array(
//                'view' => 'nos::form/expander',
//                'params' => array(
//                    'title'   => __('Propri&eacute;t&eacute;s'),
//                    'nomargin' => true,
//                    'options' => array(
//                        'allowExpand' => true,
//                    ),
//                    'content' => array(
//                        'view' => 'nos::form/fields',
//                        'params' => array(
//                            'fields' => array(
//                                'medias->image->medil_media_id',
//                            ),
//                        ),
//                    ),
//                ),
//            ),

//            'contenu' => array(
//                'view' => 'nos::form/expander',
//                'params' => array(
//                    'title'   => __('Contenu'),
//                    'nomargin' => true,
//                    'options' => array(
//                        'allowExpand' => true,
//                    ),
//                    'content' => array(
//                        'view' => 'nos::form/fields',
//                        'params' => array(
//                            'fields' => array(
//                                'wysiwygs->description->wysiwyg_text',
//                            ),
//                        ),
//                    ),
//                ),
//            ),
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