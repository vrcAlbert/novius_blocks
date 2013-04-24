<?php
return array(
    'controller_url'  => 'admin/lib_blocs/bloc/crud',
    'model' => 'Lib\Blocs\Model_Bloc',
    'layout' => array(
        'large' => true,
        'save' => 'save',
        'title' => 'bloc_title',
        'medias' => array('medias->image->medil_media_id'),
        'subtitle' => array('bloc_type'),
        'content' => array(
            'proprietes' => array(
                'view' => 'nos::form/expander',
                'params' => array(
                    'title'   => __('Propri&eacute;t&eacute;s'),
                    'nomargin' => true,
                    'options' => array(
                        'allowExpand' => true,
                    ),
                    'content' => array(
                        'view' => 'nos::form/fields',
                        'params' => array(
                            'begin' => '<div class="wrapper_bloc">',
                            'fields' => array(
                                'wysiwygs->description->wysiwyg_text'
                            ),
                            'end' => '</div>',
                        ),
                    ),
                ),
            ),
            'js' => array(
                'view' => 'lib_blocs::admin/bloc_form',
            ),
        ),
        'menu' => array(
            __('Arborescence') => array(
                'bloc_parent_id',
            ),
        ),
    ),
    'fields' => array(
        'bloc__id' => array (
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
        ),
        'bloc_type' => array(
            'label' => __('Type'),
            'form' => array(
                'type' => 'select',
                'options' => array(
                    'bloc' => 'Bloc',
                    'folder' => 'Dossier',
                ),
            ),
        ),
        'wysiwygs->description->wysiwyg_text' => array(
            'label' => __('Description'),
            'renderer' => 'Nos\Renderer_Wysiwyg',
            'template' => '{field}',
            'form' => array(
                'style' => 'width: 100%; height: 500px;',
            ),
        ),
        'medias->image->medil_media_id' => array(
            'label' => '',
            'renderer' => 'Nos\Renderer_Media',
            'form' => array(
                'title' => __('Image'),
            ),
        ),
        'bloc_parent_id' => array(
            'renderer' => 'Lib\Blocs\Renderer_Selector',
            'renderer_options' => array(
                'height' => '250px',
            ),
            'label' => __('Location:'),
            'form' => array(),
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