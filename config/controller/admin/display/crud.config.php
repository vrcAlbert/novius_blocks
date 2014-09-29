<?php
/**
 * Novius Blocks
 *
 * @copyright  2014 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

return array(
    'controller_url'  => 'admin/novius_blocks/display/crud',
    'model' => 'Novius\Blocks\Model_Display',
    'layout' => array(
        'large' => true,
        'save' => 'save',
        'title' => 'blod_title',
        'content' => array(
            'blocks' => array(
                'view' => 'nos::form/expander',
                'params' => array(
                    'title'   => __('Grid'),
                    'nomargin' => true,
                    'options' => array(
                        'allowExpand' => true,
                    ),
                    'content' => array(
//                        'view' => 'novius_blocks::admin/display/grid-builder',
                        'view' => 'novius_blocks::admin/display/grid-builder',
                        'params' => array(
                            'fields' => array(
                                'blod_structure',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'fields' => array(
        'blod_id' => array (
            'label' => __('ID: '),
            'form' => array(
                'type' => 'hidden',
            ),
            'dont_save' => true,
        ),
        'blod_title' => array(
            'label' => __('Title'),
            'form' => array(
                'type' => 'text',
            ),
        ),
        'blod_structure' => array(
            'form' => array(
                'type' => 'hidden',
            ),
            'populate' => function($item) {
                return \Format::forge($item->blod_structure)->to_json();
            },
            'before_save' => function($item, $data) {
                $item->blod_structure = \Fuel\Core\Format::forge($data['blod_structure'], 'json')->to_array();
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