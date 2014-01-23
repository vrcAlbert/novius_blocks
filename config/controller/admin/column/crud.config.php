<?php
/**
 * Novius Blocs
 *
 * @copyright  2013 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

return array(
    'controller_url'  => 'admin/novius_blocs/column/crud',
    'model' => 'Novius\Blocs\Model_Column',
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
                        'view' => 'novius_blocs::admin/column/multiselect_blocs',
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
            'renderer' => 'Novius\Renderers\Renderer_Multiselect',
            'renderer_options' => array(
                'order' => true,
            ),
            'order' => true,
            'label' => __('Blocs'),
            'form' => array(
                'options' => array(),
                'order' => true,
            ),
            'before_save' => function($item, $data) {
                $item->blocs;
                unset($item->blocs);
                if (!empty($data['blocs'])) {
                    foreach ($data['blocs'] as $bloc_id) {
                        if (ctype_digit($bloc_id) ) {
                            $item->blocs[$bloc_id] = \Novius\Blocs\Model_Bloc::find($bloc_id);
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
                'value' => __('Save'),
                'class' => 'primary',
                'data-icon' => 'check',
            ),
        ),
    )
);