<?php

return array(
    'model_compatibility' => array(
        'view' => 'lib_blocs::admin/bloc/model_compatibility',
    ),
    'controller_url'  => 'admin/lib_blocs/bloc/crud',
    'model' => 'Lib\Blocs\Model_Bloc',
    'layout' => array(
        'large' => true,
        'save' => 'save',
        'title' => 'bloc_title',
        'content' => array(
            'template' => array(
                'view' => 'nos::form/expander',
                'params' => array(
                    'title'   => __('Template'),
                    'nomargin' => true,
                    'options' => array(
                        'allowExpand' => true,
                    ),
                    'content' => array(
                        'view' => 'lib_blocs::admin/bloc/template',
                        'params' => array(
                            'fields' => array(
                                'bloc_template',
                            ),
                        ),
                    ),
                ),
            ),
            'image' => array(
                'view' => 'nos::form/expander',
                'params' => array(
                    'title'   => __('Image'),
                    'nomargin' => true,
                    'options' => array(
                        'allowExpand' => true,
                        'fieldset' => 'image',
                    ),
                    'content' => array(
                        'view' => 'nos::form/fields',
                        'params' => array(
                            'fields' => array(
                                'medias->image->medil_media_id',
                            ),
                        ),
                    ),
                ),
            ),
            'description' => array(
                'view' => 'nos::form/expander',
                'params' => array(
                    'title'   => __('Contenu'),
                    'nomargin' => true,
                    'options' => array(
                        'allowExpand' => true,
                        'fieldset' => 'description',
                    ),
                    'content' => array(
                        'view' => 'nos::form/fields',
                        'params' => array(
                            'fields' => array(
                                'wysiwygs->description->wysiwyg_text',
                            ),
                        ),
                    ),
                ),
            ),
            'link' => array(
                'view' => 'nos::form/expander',
                'params' => array(
                    'title'   => __('Link'),
                    'nomargin' => true,
                    'options' => array(
                        'allowExpand' => true,
                        'fieldset' => 'link',
                    ),
                    'content' => array(
                        'view' => 'nos::form/fields',
                        'params' => array(
                            'fields' => array(
                                'bloc_link',
                                'bloc_link_title',
                                'bloc_link_new_page',
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'menu' => array(
            'accordion' => array(
                'view' => 'nos::form/accordion',
                'params' => array(
                    'accordions' => array(
//                        'synchro' => array(
//                            'title' =>  __('Retrieve infos'),
//                            'view' => 'lib_blocs::admin/bloc/synchro',
//                            'fields' => array(
//                                'bloc_model',
//                                'bloc_model_id',
//                            ),
//                        ),
                        'columns' => array(
                            'title' => __('Columns'),
                            'fields' => array(
                                'columns'
                            ),
                        ),
                        'params' => array(
                            'title' => __('Configuration'),
                            'fields' => array(
                                'bloc_class',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'fields' => array(
        'bloc_id' => array (
            'label' => 'ID: ',
            'form' => array(
                'type' => 'hidden',
            ),
            'dont_save' => true,
        ),
        'bloc_title' => array(
            'label' => __('Title'),
            'form' => array(
                'type' => 'text',
            ),
            'validation' => array('required'),
        ),
        'wysiwygs->description->wysiwyg_text' => array(
            'label' => __('Description'),
            'renderer' => 'Nos\Renderer_Wysiwyg',
            'template' => '{field}',
            'form' => array(
                'style' => 'width: 100%; height: 200px;',
            ),
        ),
        'medias->image->medil_media_id' => array(
            'label' => '',
            'renderer' => 'Nos\Renderer_Media',
            'form' => array(
                'title' => __('Image'),
            ),
        ),
        'bloc_template' => array(
            'label' => '',
        ),
        'bloc_link' => array(
            'label' => 'Lien',
            'description' => '',
        ),
        'bloc_link_title' => array(
            'label' => 'Intitulé du lien',
        ),
        'bloc_link_new_page' => array(
            'label' => 'Ouvrir dans une nouvelle page',
            'form' => array(
                'type' => 'checkbox',
                'value' => 1,
            ),
        ),
        'bloc_class' => array(
            'label' => __('Class'),
            'form' => array(
                'type' => 'text',
            ),
        ),
        'columns' => array(
            'renderer' => 'Lib\Renderers\Renderer_Multiselect',
            'label' => __('Columns'),
            'form' => array(
                'options' => array(),
                'style' => array(
                    'width' => '70%'
                )
            ),
            'populate' => function($item) {
                if (!empty($item->columns)) {
                    return array_keys($item->columns);
                } else {
                    return array();
                }
            },
            'before_save' => function($item, $data) {
                $item->columns;//fetch et 'cree' la relation
                unset($item->columns);
                if (!empty($data['columns'])) {
                    foreach ($data['columns'] as $blco_id) {
                        if (ctype_digit($blco_id) ) {
                            $item->columns[$blco_id] = \Lib\Blocs\Model_Column::find($blco_id);
                        }
                    }
                }
            },
        ),
        'bloc_model' => array(
            'form' => array(
                'type' => 'hidden',
            ),
        ),
        'bloc_model_id' => array(
            'form' => array(
                'type' => 'hidden',
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
    /* UI texts sample
    'messages' => array(
        'successfully added' => __('Item successfully added.'),
        'successfully saved' => __('Item successfully saved.'),
        'successfully deleted' => __('Item has successfully been deleted!'),
        'you are about to delete, confim' => __('You are about to delete item <span style="font-weight: bold;">":title"</span>. Are you sure you want to continue?'),
        'you are about to delete' => __('You are about to delete item <span style="font-weight: bold;">":title"</span>.'),
        'exists in multiple context' => __('This item exists in <strong>{count} contexts</strong>.'),
        'delete in the following contexts' => __('Delete this item in the following contexts:'),
        'item deleted' => __('This item has been deleted.'),
        'not found' => __('Item not found'),
        'error added in context' => __('This item cannot be added {context}.'),
        'item inexistent in context yet' => __('This item has not been added in {context} yet.'),
        'add an item in context' => __('Add a new item in {context}'),
        'delete an item' => __('Delete a item'),
    ),
    */
    /*
    Tab configuration sample
    'tab' => array(
        'iconUrl' => 'static/apps/{{application_name}}/img/16/icon.png',
        'labels' => array(
            'insert' => __('Add a item'),
            'blankSlate' => __('Translate a item'),
        ),
    ),
    */
);