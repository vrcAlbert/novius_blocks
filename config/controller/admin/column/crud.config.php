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
    'controller_url'  => 'admin/novius_blocks/column/crud',
    'model' => 'Novius\Blocks\Model_Column',
    'layout' => array(
        'large' => true,
        'save' => 'save',
        'title' => 'blco_title',
        'content' => array(
            'blocks' => array(
                'view' => 'nos::form/expander',
                'params' => array(
                    'title'   => __('Blocks'),
                    'nomargin' => true,
                    'options' => array(
                        'allowExpand' => true,
                    ),
                    'content' => array(
                        'view' => 'novius_blocks::admin/column/multiselect_blocks',
                        'params' => array(
                            'fields' => array(
                                'blocks',
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
        'blco_blocks_ordre' => array(
            'form' => array(
                'type' => 'hidden',
            ),
            'before_save' => function($item, $data) {
                $item->blco_blocks_ordre = serialize($data['blocks']);
            },
        ),
        'blocks' => array(
            'renderer' => 'Novius\Renderers\Renderer_Multiselect',
            'renderer_options' => array(
                'order' => true,
            ),
            'order' => true,
            'label' => __('Blocks'),
            'form' => array(
                'options' => array(),
                'order' => true,
            ),
            'before_save' => function($item, $data) {
                $item->blocks;
                unset($item->blocks);
                if (!empty($data['blocks'])) {
                    foreach ($data['blocks'] as $block_id) {
                        if (ctype_digit($block_id) ) {
                            $item->blocks[$block_id] = \Novius\Blocks\Model_Block::find($block_id);
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